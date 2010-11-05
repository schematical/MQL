<?php
/* 
 * Created By: Matt Lea
 * Date: 8/9/10
 *
 * Description: This class should serve as the base for any entity that can be queried using MQL
 */
abstract class MQLEntityBase{
    //Key Words
    const WHERE = 'WHERE';
    const AND_OPERATOR = 'AND';
    const OR_OPERATOR = 'OR';
    const ORDERBY = 'ORDERBY';
    const ASC = 'ASC';
    const DESC = 'DESC';
    const LIMIT = 'LIMIT';

    //Arr Keys
    const QQUERY = 'QQUERY';
    const QCLAUSE = 'QCLAUSE';
    
    protected $arrFields = array();

    
    public function AddField($strFieldName, $objDataType){
        $objDataType->SetPublicName($strFieldName);
        $this->arrFields[$strFieldName] = $objDataType;
    }
    /**
     *
     * @param <String> $strQuery Repersents everything after the WHERE keyword in the statement
     */
    public function ParseQuery($strQuery){
        
        $strQuery = trim($strQuery);
        $arrParts = explode(' ', $strQuery);
        foreach($arrParts as $intKey=>$strPart){
            $arrParts[$intKey] = str_replace('&nbsp;', ' ', $strPart);
        }
        $intIndex = 0;
        $intPartsCount = count($arrParts);
        
        $objFullQuery = null;
        $arrClauses = array();
        while ($intIndex < $intPartsCount) {
            $strFunction = $arrParts[$intIndex];
            switch($strFunction){
                case(self::WHERE):
                case(self::AND_OPERATOR):
                case(self::OR_OPERATOR):
                    if(($intIndex + 3) <= $intPartsCount){
                        $strField = $arrParts[$intIndex + 1];
                        $strOperator = $arrParts[$intIndex + 2];
                        $strValue = $arrParts[$intIndex + 3];
                        $objQQuery = $this->ParseQueryNode($strField, $strOperator, $strValue);
                        $intIndex += 4;
                        if(self::WHERE){
                            $objFullQuery = $objQQuery;
                        }elseif(self::AND_OPERATOR){
                            $objFullQuery = new QQConditionAnd($objFullQuery, $objQQuery);
                        }elseif(self::OR_OPERATOR){
                            $objFullQuery = new QQConditionOr($objFullQuery, $objQQuery);
                        }
                    }else{
                        throw new Exception('Not enough parameters in your query near xxxx');
                    }
                break;
                case(self::ORDERBY):
                    if(($intIndex + 1) <= $intPartsCount){
                        $strField = $arrParts[$intIndex + 1];
                        
                        if((($intIndex + 2) < $intPartsCount) && (
                                ($arrParts[$intIndex + 2] == self::ASC) || ($arrParts[$intIndex + 2] == self::DESC)
                                )){
                            $arrClauses[] = $this->ParseOrderBy($strField, $arrParts[$intIndex + 2]);
                            $intIndex += 3;
                        }else{
                            $arrClauses[] = $this->ParseOrderBy($strField);
                            $intIndex += 2;
                        }
                    }else{
                        throw new Exception('Not enough parameters in your query near xxxx');
                    }
                break;
                case(self::LIMIT):
                    if(($intIndex + 1) < $intPartsCount){
                        $strLimit = $arrParts[$intIndex + 1];
                        if((($intIndex +1) <= $intPartsCount) && (is_numeric($arrParts[$intIndex + 2]))){
                            $intLimitOffset = $arrParts[$intIndex + 2];
                        }else{
                            $intLimitOffset = 0;
                        }
                        $arrClauses[] = new QQLimitInfo($strLimit);
                        $intIndex += 2;
                    }else{
                        throw new Exception('Not enough parameters in your query near xxxx');
                    }
                break;
                default:
                    $intIndex = $intPartsCount+ 1;
                break;
            }
        }
        return array(self::QCLAUSE=>$arrClauses, self::QQUERY=>$objFullQuery);


    }
    public function ParseQueryNode($strField, $strOperator, $strValue){
        if(key_exists($strField, $this->arrFields)){
            $objField = $this->arrFields[$strField];
            return $objField->Query($strOperator, $strValue);
        }else{
            throw new Exception("No field exists named '" . $strField . "'");
        }
        
    }
    public function ParseOrderBy($strField, $strDirection = self::ASC){
        if(key_exists($strField, $this->arrFields)){
            $objField = $this->arrFields[$strField];
            return $objField->OrderBy($strDirection);
        }else{
            throw new Exception("No field exists named '" . $strField . "'");
        }
    }
}
?>

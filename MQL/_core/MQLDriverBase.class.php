<?php
/* 
 * Created By: Matt Lea
 * Date: 8/9/10
 *
 * Description: This class will hold the base functionality for handeling calls to MQL Entitys
 */
abstract class MQLDriverBase{
    const SELECT_FROM = 'SELECT FROM';

    const DOUBLE_QUOTE = '"';
    const SINGLE_QUOTE = '\'';

    protected static $arrEntitys = array();
    protected static $objQueryObject = null;
    public static function Init(){

    }
    public static function AddEntity($strPublicName, $strClassName){
        self::$arrEntitys[$strPublicName] = $strClassName;
    } 
    /**
     *
     * @param <String> $strQuery The Query as posted to the API via http request
     * @return <Array> of what ever objects were queried
     */
    public static function Exicute($strQuery){

        $strQuery = self::EncapsulateStrings(trim(urldecode($strQuery)), self::DOUBLE_QUOTE);
        $strQuery = self::EncapsulateStrings($strQuery, self::SINGLE_QUOTE);
      
        $intPosSel = strpos($strQuery, self::SELECT_FROM);
        
        if($intPosSel !== false){
            $strQuery = trim(substr($strQuery, $intPosSel + strlen(self::SELECT_FROM)));
            $intPosTableEnd = strpos($strQuery, ' ');            
            if($intPosTableEnd === false){
                $intPosTableEnd = strlen($strQuery);
            }
            $strTableName = trim(substr($strQuery, 0, $intPosTableEnd));
            if(key_exists($strTableName, self::$arrEntitys)){
                $strClassName = self::$arrEntitys[$strTableName];
                self::$objQueryObject = new $strClassName();
                return self::$objQueryObject->Query(trim(substr($strQuery, $intPosTableEnd)));
            }else{
                throw new Exception("No entity named '" . $strTableName . "' to query");
            }
        }else{
            throw new Exception("Invalid Query");
        }
    }

    public static function EncapsulateStrings($strQuery, $strQuoteStyle){
        $intEndPos = 0;
        $intStartPos = strpos($strQuery, $strQuoteStyle);
        $strReturn = '';
        while($intStartPos !== false){

            $strReturn .= substr($strQuery, $intEndPos, $intStartPos);
            $intEndPos = strpos($strQuery, $strQuoteStyle, $intStartPos + 1) + 1;
            $strQuoted = substr($strQuery, $intStartPos, $intEndPos - $intStartPos);
            $strQuoted = substr($strQuoted, strlen($strQuoteStyle), strlen($strQuoted) - (strlen($strQuoteStyle)*2 ));
            
            $strReturn .= str_replace(' ', '&nbsp;', $strQuoted);
   
            $intStartPos = strpos($strQuery, $strQuoteStyle, $intEndPos);
        }
        
        $strReturn .= substr($strQuery, $intEndPos);
        return $strReturn;

    }
}
?>
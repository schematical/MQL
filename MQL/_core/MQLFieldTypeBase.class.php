<?php
/*
 * Created By: Matt Lea
 * Date: 8/10/10
 * Description: This holds base functionality for MQLEntity field data types
 */
abstract class MQLFieldTypeBase{
    protected $strName = null;
    protected $objQQNode = null;
    protected $arrAllowedOperators = array();
    public function  __construct($objQQNode) {
        $this->objQQNode = $objQQNode;
    }
    public function SetPublicName($strName){
        $this->strName = $strName;
    }
    public function AddAllowedOperator($strOperator, $strQConditionClassName){
        $this->arrAllowedOperators[$strOperator] = $strQConditionClassName;
    }
    public function Query($strOperator, $strValue){
        if(key_exists($strOperator, $this->arrAllowedOperators)){
            $strQConditionClassName = $this->arrAllowedOperators[$strOperator];
            return new $strQConditionClassName($this->objQQNode, $strValue);
        }else{
            throw new Exception("'" . $strOperator . "' is not a valid operator for field name '" . $this->strName . "'");
        }
    }
    public function OrderBy($strDirection){
        return new QQOrderBy(array($this->objQQNode, $strDirection));
    }
   
}
?>

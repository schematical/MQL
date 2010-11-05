<?php
/* 
 */
class MQLComplexQueryFieldType extends MQLFieldTypeBase {
    protected $objObject = null;
    protected $strFunction = null;
    public function  __construct($objObject, $strFunction) {
        $this->objObject = $objObject;
        $this->strFunction = $strFunction;
        //parent::__construct($objQQNode);
        

    }
    public function Query($strOperator, $strValue) {
        $strFunction = $this->strFunction;
        return $this->objObject->$strFunction($strOperator, $strValue);
    }
    public function OrderBy($strDirection) {
        throw new Exception("Cannot do an orderby on this field '" . $this->strName . "'");
        //parent::OrderBy($strDirection);
    }
}
?>

<?php
/* 
 */
class MQLVarcharFieldType extends MQLFieldTypeBase {


    public function  __construct($objQQNode) {
        parent::__construct($objQQNode);
        $this->AddAllowedOperator('=', 'QQConditionEqual');
        $this->AddAllowedOperator('LIKE', 'QQConditionLike');
        $this->AddAllowedOperator('NOTLIKE', 'QQConditionNotLike');

    }
}
?>

<?php
/* 
 */
class MQLDateTimeFieldType extends MQLFieldTypeBase {


    public function  __construct($objQQNode) {
        parent::__construct($objQQNode);
        $this->AddAllowedOperator('=', 'QQConditionEqual');
        $this->AddAllowedOperator('!=', 'QQConditionNotEqual');
        $this->AddAllowedOperator('<', 'QQConditionLessThan');
        $this->AddAllowedOperator('>=', 'QQConditionGreaterThan');
        $this->AddAllowedOperator('<', 'QQConditionLessThan');
        $this->AddAllowedOperator('>=', 'QQConditionLessOrEqual');


    }
}
?>

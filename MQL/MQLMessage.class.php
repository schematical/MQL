<?php
/*
 * Created By: Matt Lea
 * Date: 8/9/10
 *
 * Description: This class will handel any functionality specific to quering message objects
 */
class MQLMessage extends MQLEntityBase{

    public function  __construct() {
        $this->AddField('IdMessage', MQLFieldType::Int(QQN::Message()->IdMessage));
        $this->AddField('IdUser', MQLFieldType::Int(QQN::Message()->IdUser));
        $this->AddField('Location', MQLFieldType::Location(QQN::Message()->Lat, QQN::Message()->Long));
        $this->AddField('Body', MQLFieldType::ComplexQuery($this, 'ParseQuery_MessageBody')); 
        $this->AddField('CreDate', MQLFieldType::DateTime(QQN::Message()->CreDate));
    }
    public function Query($strQuery){
        $arrData = parent::ParseQuery($strQuery);
        if(is_null($arrData[self::QQUERY])){
            return Message::LoadAll($arrData[self::QCLAUSE]);
        }else{
            return Message::QueryArray($arrData[self::QQUERY], $arrData[self::QCLAUSE]);
        }
    }
    public function ParseQuery_MessageBody($strOperator, $strValue){
        return QQ::AndCondition(
            QQ::Equal(QQN::Message()->MessageAttrAsId->Key, MessageAttrType::BODY),
            QQ::Like(QQN::Message()->MessageAttrAsId->Value, $strValue)
        );
    }

}
?>

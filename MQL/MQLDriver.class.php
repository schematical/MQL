<?php
/*
 * Created By: Matt Lea
 * Date: 8/9/10
 *
 * Description: This class will hold the functionality for specific calls to MQL Entitys
 */
abstract class MQLDriver extends MQLDriverBase{

    public static function Init($strQuery){
        MQLDriverBase::Init();

        self::AddEntity('Message', 'MQLMessage');
        self::AddEntity('User', 'MQLUser');
        return self::Exicute($strQuery);
    }


}
?>

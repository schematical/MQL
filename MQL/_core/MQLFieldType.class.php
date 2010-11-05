<?php
/* 
 * Created By: Matt Lea
 * Date: 8/10/10
 * Description: This distribuites different field types statically
 */
class MQLFieldType{

    public static function Int($objQQNode){
        return new MQLIntFieldType($objQQNode);
    }
    public static function Varchar($objQQNode){
        return new MQLVarcharFieldType($objQQNode);
    }
    public static function DateTime($objQQNode){
        return new MQLDateTimeFieldType($objQQNode);
    }
    /**
     *
     * @param <String> $strFunName this should be a function name
     */
    public static function ComplexQuery($objObject, $strFunName){
        return new MQLComplexQueryFieldType($objObject, $strFunName);
    }
    /**
     * This function is used to combine a latitude and longitutde to a specific location call, this enables users to call  the 'DistanceFrom compairison operatior
     * @param <QQNode> $objOONodeLat Latitude
     * @param <QQNode> $objOONodeLong Longitude
     */
    public static function Location($objOONodeLat, $objOONodeLong){
        return new MQLLocationFieldType($objOONodeLat, $objOONodeLong);
    }
}
?>

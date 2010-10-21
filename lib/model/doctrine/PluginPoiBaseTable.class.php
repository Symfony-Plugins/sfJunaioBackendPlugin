<?php


abstract class PluginPoiBaseTable extends Doctrine_Table
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('PoiBase');
    }
}
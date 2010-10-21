<?php

/**
 * sfJunaioBackendPlugin configuration.
 * 
 * @package     sfJunaioBackendPlugin
 * @subpackage  config
 * @author      Your name here
 * @version     SVN: $Id: PluginConfiguration.class.php 17207 2009-04-10 15:36:26Z Kris.Wallsmith $
 */
class sfJunaioBackendPluginConfiguration extends sfPluginConfiguration
{
   const VERSION = '1.0.0-DEV';

   public function initialize()
   {
      $this->dispatcher->connect('user.method_not_found', array('sfJunaioBackendUser', 'methodNotFound'));
   }
}

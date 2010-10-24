<?php

class sfJunaioBackendUser
{
   static public function methodNotFound(sfEvent $event)
   {
      if (method_exists('sfJunaioBackendUser', $event['method']))
      {
         $event->setReturnValue(call_user_func_array(
           array('sfJunaioBackendUser', $event['method']),
           array_merge(array($event->getSubject()), $event['arguments'])
         ));

         return true;
      }
   }

   static public function getSfJunaioBackendParams(sfUser $user) {
      $lat  = $user->getAttribute('lat', sfConfig::get('app_google_maps_default_latitude'));
      $lng  = $user->getAttribute('lng', sfConfig::get('app_google_maps_default_longitude'));
      $zoom = $user->getAttribute('zoom', sfConfig::get('app_google_maps_default_zoom'));

      return array (
         "latitude" => $lat,
         "longitude" => $lng,
         "zoom" => $zoom
      );
   }

   static public function setSfJunaioBackendParams(sfUser $user, $data) {
      $user->setAttribute('lat', $data["latitude"]);
      $user->setAttribute('lng', $data["longitude"]);
      $user->setAttribute('zoom', $data["zoom"]);
   }
}

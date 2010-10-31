<?php

/**
 * maps actions.
 *
 * @package    sf_sandbox
 * @subpackage maps
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class sfJunaioBackendMapActions extends sfActions
{
  public function executeUpdatesession(sfWebRequest $request) {
    $params = $request->getGetParameters();
    $this->getUser()->setSfJunaioBackendParams($params);

    return sfView::NONE;
  }
  
  public function executeIndex(sfWebRequest $request) {
    $this->getResponse()->addJavascript('http://maps.google.com/maps/api/js?sensor=false&key=' . sfConfig::get('app_google_maps_api_key'));
    $this->getResponse()->addJavascript('/sfJunaioBackendPlugin/js/map.js');


    $about = "<br/><center><h1>sfJunaioBackendPlugin</h1></center><br/>";
    $xmlfile = realpath(dirname(__FILE__)."/../../../")."/package.xml";
    if (is_file($xmlfile)) {
       $xml = new SimpleXMLElement(file_get_contents($xmlfile));
       $about .= $xml->description;
       $about .= '<br/><br/>';
       $about .= "version: ".$xml->version->release . " date: ".$xml->date;
       $about .= '<br/><br/>';
       $about .= 'visit <a href="http://tinyurl.com/3y2htuj">http://tinyurl.com/3y2htuj</a> for more documentation.';
       $about .= "<br/><br/>&copy;3epnm 2010";
    } else {
       $about .= "package.xml file not found!";
    }
    $this->about = $about;

    $this->address = sfConfig::get('app_google_maps_default_address');

    $data = $this->getUser()->getSfJunaioBackendParams();

    $this->latitude = $data['latitude'];
    $this->longitude = $data['longitude'];
    $this->zoom = $data['zoom'];
  }
}

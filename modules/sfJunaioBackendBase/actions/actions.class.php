<?php

/**
 * 
 *
 * @package    3epnmJunaio
 * @subpackage simple
 * @author     Marcel Bretschneider
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class sfJunaioBackendBaseActions extends sfActions
{
  public function executePost(sfWebRequest $request) {
    $this->setLayout(false);
    $response = $this->getResponse();
    $response->setContentType('application/json');

    $pois = Doctrine::getTable('PoiBase')->find($request->getParameter("id"));
    $this->forward404Unless($pois);
    $pois->fromArray($_REQUEST);

    try {
        $pois->save();
        $out = (object) array("error" => false, "message" => "success", "id" => $pois->id, "result" => $pois->toArray());
    }
    catch (Exception $e) {
        $out = (object) array("error" => true, "message" => $e->getMessage(), "id" => $pois->id);
    }

    $response->setContent(json_encode($out));
    return sfView::NONE;
  }

  public function executeList(sfWebRequest $request) {
    $this->setLayout(false);
    $response = $this->getResponse();
    $response->setContentType('application/json');

    $pois = Doctrine::getTable('PoiBase')->findAll();
    $out = array ();
    foreach ($pois as $poi) {
        $tmp["id"]          = $poi->getId();
        $tmp["name"]        = $poi->getName();
        $tmp["description"] = $poi->getDescription();
        $tmp["icon"]        = $poi->getIcon();
        $tmp["thumbnail"]   = $poi->getThumbnail();
        $tmp["latitude"]    = $poi->getLatitude();
        $tmp["longitude"]   = $poi->getLongitude();
        $out[] = $tmp;
    }
    $response->setContent(json_encode($out));
    return sfView::NONE;
  }

  public function executeGet(sfWebRequest $request) {
    $this->setLayout(false);
    $response = $this->getResponse();
    $response->setContentType('application/json');

    $pois = Doctrine::getTable('PoiBase')->find($request->getParameter("id"));
    $this->forward404Unless($pois);

    $response->setContent(json_encode($out));
    return sfView::NONE;
  }

  public function executeIndex(sfWebRequest $request) {
    $this->pois = Doctrine::getTable('PoiBase')
      ->createQuery('a')
      ->execute();
  }

  public function executeNew(sfWebRequest $request) {
    $params = $request->getGetParameters();

    $data = new PoiBase();
    if (isset($params["lat"]) && isset($params["lng"])) {
        $data->latitude = $params["lat"];
        $data->longitude = $params["lng"];
    }
    if (isset($params["name"])) {
        $data->name = $params["name"];
    }
    if (isset($params["description"])) {
        $data->description = $params["description"];
    }
    $this->form = new PoiBaseForm($data);
  }

  public function executeCreate(sfWebRequest $request) {
    $this->forward404Unless($request->isMethod(sfRequest::POST));
    $this->form = new PoiBaseForm();
    $this->processForm($request, $this->form);
    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request) {
    $this->forward404Unless($poi = Doctrine::getTable('PoiBase')->find(array($request->getParameter('id'))), sprintf('Object poi_base does not exist (%s).', $request->getParameter('id')));
    $this->form = new PoiBaseForm($poi);
  }

  public function executeUpdate(sfWebRequest $request) {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($poi = Doctrine::getTable('PoiBase')->find(array($request->getParameter('id'))), sprintf('Object poi_base does not exist (%s).', $request->getParameter('id')));
    $this->form = new PoiBaseForm($poi);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request) {
    $request->checkCSRFProtection();

    $this->forward404Unless($poi = Doctrine::getTable('PoiBase')->find(array($request->getParameter('id'))), sprintf('Object poi_base does not exist (%s).', $request->getParameter('id')));
    $poi->delete();

    $response = $this->getResponse();
    $response->setContentType('text/html');
    $response->setContent('<script type="text/javascript">parent.updateMarker();</script>');
    return sfView::NONE;
  }

  public function executeListdelete(sfWebRequest $request) {
    $request->checkCSRFProtection();

    $this->forward404Unless($poi = Doctrine::getTable('PoiBase')->find(array($request->getParameter('id'))), sprintf('Object poi_base does not exist (%s).', $request->getParameter('id')));
    $poi->delete();

    $this->redirect('sfJunaioBackendBase/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form) {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid()) {
      $poi = $form->save();

      $this->redirect('sfJunaioBackendBase/edit?id='.$poi->getId());
    }
  }
}

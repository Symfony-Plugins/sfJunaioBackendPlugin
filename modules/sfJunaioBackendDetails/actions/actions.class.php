<?php

/**
 * details actions.
 * 
 * @package    sfJunaioBackendPlugin
 * @subpackage details
 * @author     marcel bretschneider
 * @version    0.1 beta
 */
class sfJunaioBackendDetailsActions extends sfActions
{
   public function executeEdit(sfWebRequest $request) {
      $this->forward404Unless($poi_base = Doctrine::getTable('PoiBase')->find(array($request->getParameter('id'))), sprintf('Object poi_base does not exist (%s).', $request->getParameter('id')));
      $this->form = new PoiBaseForm($poi_base);
   }

   public function executeUpdate(sfWebRequest $request) {
      $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
      $this->forward404Unless($poi_base = Doctrine::getTable('PoiBase')->find(array($request->getParameter('id'))), sprintf('Object poi_base does not exist (%s).', $request->getParameter('id')));

      $this->form = new PoiBaseForm($poi_base);
      $this->processForm($request, $this->form);

      $this->setTemplate('edit');
   }

   public function executeDelete(sfWebRequest $request) {
      $request->checkCSRFProtection();
      $this->forward404Unless($poi_base = Doctrine::getTable('PoiBase')->find(array($request->getParameter('id'))), sprintf('Object poi_base does not exist (%s).', $request->getParameter('id')));
      $poi_base->delete();

      $this->redirect('sfJunaioBackendDetails/index');
   }

   protected function processForm(sfWebRequest $request, sfForm $form) {
      $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
      if ($form->isValid())
      {
         $poi_base = $form->save();
         $this->redirect('sfJunaioBackendDetails/edit?id='.$poi_base->getId());
      }
   }
}

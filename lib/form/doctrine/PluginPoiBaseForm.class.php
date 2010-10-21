<?php

/**
 * PoiBase form.
 *
 * @package    3epnmJunaio
 * @subpackage form
 * @author     Marcel Bretschneider
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
abstract class PluginPoiBaseForm extends BasePoiBaseForm
{
  public function setup()
  {
    parent::setup();
    
    $this->removeFields();

    $files = array (
        "Thumbnail" => array("image/png", "image/jpg", "image/jpeg"),
        "Icon" => array ("image/png", "image/jpg", "image/jpeg"),
        "Mainresource" => array()
    );

    foreach ($files as $name => $types)
    {
       $get = "get".$name;
       $this->widgetSchema[strtolower($name)] = new sfWidgetFormInputFileEditable(array(
         'label'     => $name,
         'file_src'  => $this->getObject()->$get(),
         'is_image'  => !empty($types) ? true : false,
         'edit_mode' => !$this->isNew(),
         'template'  => '<div>%file%<br />%input%<br /><span class="delete">%delete% %delete_label%</span></div>',
       ));


       $conf = array(
           'required'   => false,
           'path'       => sfConfig::get('sf_upload_dir').'/'.strtolower($name),
           'validated_file_class' => 'mdValidatedFile'
       );
       if (!empty($types))
         $conf['mime_types'] = $types;

       $this->validatorSchema[strtolower($name)] = new sfValidatorFile($conf);
       $this->validatorSchema[strtolower($name).'_delete'] = new sfValidatorPass();
    }
  }

  protected function removeFields()
  {
      unset(
        $this['created_at'], $this['updated_at']
      );
  }
}

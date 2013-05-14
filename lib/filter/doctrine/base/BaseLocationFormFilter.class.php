<?php

/**
 * Location filter form base class.
 *
 * @package    nokia.lumia.v2
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseLocationFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'location_name' => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'location_name' => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('location_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Location';
  }

  public function getFields()
  {
    return array(
      'location_id'   => 'Text',
      'location_name' => 'Text',
    );
  }
}

<?php

/**
 * Location form base class.
 *
 * @method Location getObject() Returns the current form's model object
 *
 * @package    nokia.lumia.v2
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseLocationForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'location_id'   => new sfWidgetFormInputHidden(),
      'location_name' => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'location_id'   => new sfValidatorChoice(array('choices' => array($this->getObject()->get('location_id')), 'empty_value' => $this->getObject()->get('location_id'), 'required' => false)),
      'location_name' => new sfValidatorString(array('max_length' => 255, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('location[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Location';
  }

}

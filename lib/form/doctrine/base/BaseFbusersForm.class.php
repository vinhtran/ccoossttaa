<?php

/**
 * Fbusers form base class.
 *
 * @method Fbusers getObject() Returns the current form's model object
 *
 * @package    nokia.lumia.v2
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseFbusersForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'user_id'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Image_Fbuser'), 'add_empty' => true)),
      'fbuser_id'         => new sfWidgetFormInputHidden(),
      'fbuser_email'      => new sfWidgetFormInputText(),
      'fbuser_first_name' => new sfWidgetFormInputText(),
      'fbuser_last_name'  => new sfWidgetFormInputText(),
      'fbuser_data'       => new sfWidgetFormTextarea(),
      'created_date'      => new sfWidgetFormDateTime(),
      'modified_date'     => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'user_id'           => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Image_Fbuser'), 'required' => false)),
      'fbuser_id'         => new sfValidatorChoice(array('choices' => array($this->getObject()->get('fbuser_id')), 'empty_value' => $this->getObject()->get('fbuser_id'), 'required' => false)),
      'fbuser_email'      => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'fbuser_first_name' => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'fbuser_last_name'  => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'fbuser_data'       => new sfValidatorString(array('required' => false)),
      'created_date'      => new sfValidatorDateTime(array('required' => false)),
      'modified_date'     => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('fbusers[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Fbusers';
  }

}

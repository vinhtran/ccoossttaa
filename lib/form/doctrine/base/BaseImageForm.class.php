<?php

/**
 * Image form base class.
 *
 * @method Image getObject() Returns the current form's model object
 *
 * @package    nokia.lumia.v2
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseImageForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'image_id'          => new sfWidgetFormInputHidden(),
      'image_name'        => new sfWidgetFormInputText(),
      'image_location'    => new sfWidgetFormInputHidden(),
      'image_description' => new sfWidgetFormInputText(),
      'image_like'        => new sfWidgetFormInputText(),
      'image_comment'     => new sfWidgetFormInputText(),
      'image_uploaded'    => new sfWidgetFormDateTime(),
      'image_fbuser_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Fbusers'), 'add_empty' => false)),
    ));

    $this->setValidators(array(
      'image_id'          => new sfValidatorChoice(array('choices' => array($this->getObject()->get('image_id')), 'empty_value' => $this->getObject()->get('image_id'), 'required' => false)),
      'image_name'        => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'image_location'    => new sfValidatorChoice(array('choices' => array($this->getObject()->get('image_location')), 'empty_value' => $this->getObject()->get('image_location'), 'required' => false)),
      'image_description' => new sfValidatorString(array('max_length' => 255)),
      'image_like'        => new sfValidatorPass(array('required' => false)),
      'image_comment'     => new sfValidatorPass(array('required' => false)),
      'image_uploaded'    => new sfValidatorDateTime(array('required' => false)),
      'image_fbuser_id'   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Fbusers'))),
    ));

    $this->widgetSchema->setNameFormat('image[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Image';
  }

}

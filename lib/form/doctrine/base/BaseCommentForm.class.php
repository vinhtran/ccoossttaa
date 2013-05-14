<?php

/**
 * Comment form base class.
 *
 * @method Comment getObject() Returns the current form's model object
 *
 * @package    nokia.lumia.v2
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseCommentForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'comment_id'     => new sfWidgetFormInputHidden(),
      'comment_status' => new sfWidgetFormInputCheckbox(),
      'comment_date'   => new sfWidgetFormDateTime(),
      'comment_image'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Image'), 'add_empty' => false)),
      'comment_fbuser' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Fbusers'), 'add_empty' => false)),
    ));

    $this->setValidators(array(
      'comment_id'     => new sfValidatorChoice(array('choices' => array($this->getObject()->get('comment_id')), 'empty_value' => $this->getObject()->get('comment_id'), 'required' => false)),
      'comment_status' => new sfValidatorBoolean(array('required' => false)),
      'comment_date'   => new sfValidatorDateTime(array('required' => false)),
      'comment_image'  => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Image'))),
      'comment_fbuser' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Fbusers'))),
    ));

    $this->widgetSchema->setNameFormat('comment[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Comment';
  }

}

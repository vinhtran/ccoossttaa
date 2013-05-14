<?php

/**
 * Comment filter form base class.
 *
 * @package    nokia.lumia.v2
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseCommentFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'comment_status' => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'comment_date'   => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'comment_image'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Image'), 'add_empty' => true)),
      'comment_fbuser' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Fbusers'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'comment_status' => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'comment_date'   => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'comment_image'  => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Image'), 'column' => 'image_id')),
      'comment_fbuser' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Fbusers'), 'column' => 'fbuser_id')),
    ));

    $this->widgetSchema->setNameFormat('comment_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Comment';
  }

  public function getFields()
  {
    return array(
      'comment_id'     => 'Text',
      'comment_status' => 'Boolean',
      'comment_date'   => 'Date',
      'comment_image'  => 'ForeignKey',
      'comment_fbuser' => 'ForeignKey',
    );
  }
}

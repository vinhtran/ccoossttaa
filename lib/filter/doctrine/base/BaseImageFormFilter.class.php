<?php

/**
 * Image filter form base class.
 *
 * @package    nokia.lumia.v2
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseImageFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'image_name'        => new sfWidgetFormFilterInput(),
      'image_description' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'image_like'        => new sfWidgetFormFilterInput(),
      'image_comment'     => new sfWidgetFormFilterInput(),
      'image_uploaded'    => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'image_fbuser_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Fbusers'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'image_name'        => new sfValidatorPass(array('required' => false)),
      'image_description' => new sfValidatorPass(array('required' => false)),
      'image_like'        => new sfValidatorPass(array('required' => false)),
      'image_comment'     => new sfValidatorPass(array('required' => false)),
      'image_uploaded'    => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'image_fbuser_id'   => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Fbusers'), 'column' => 'fbuser_id')),
    ));

    $this->widgetSchema->setNameFormat('image_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Image';
  }

  public function getFields()
  {
    return array(
      'image_id'          => 'Text',
      'image_name'        => 'Text',
      'image_location'    => 'Text',
      'image_description' => 'Text',
      'image_like'        => 'Text',
      'image_comment'     => 'Text',
      'image_uploaded'    => 'Date',
      'image_fbuser_id'   => 'ForeignKey',
    );
  }
}

<?php

/**
 * Fbusers filter form base class.
 *
 * @package    nokia.lumia.v2
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseFbusersFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'user_id'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Image_Fbuser'), 'add_empty' => true)),
      'fbuser_email'      => new sfWidgetFormFilterInput(),
      'fbuser_first_name' => new sfWidgetFormFilterInput(),
      'fbuser_last_name'  => new sfWidgetFormFilterInput(),
      'fbuser_data'       => new sfWidgetFormFilterInput(),
      'created_date'      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'modified_date'     => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
    ));

    $this->setValidators(array(
      'user_id'           => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Image_Fbuser'), 'column' => 'image_id')),
      'fbuser_email'      => new sfValidatorPass(array('required' => false)),
      'fbuser_first_name' => new sfValidatorPass(array('required' => false)),
      'fbuser_last_name'  => new sfValidatorPass(array('required' => false)),
      'fbuser_data'       => new sfValidatorPass(array('required' => false)),
      'created_date'      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'modified_date'     => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('fbusers_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Fbusers';
  }

  public function getFields()
  {
    return array(
      'user_id'           => 'ForeignKey',
      'fbuser_id'         => 'Text',
      'fbuser_email'      => 'Text',
      'fbuser_first_name' => 'Text',
      'fbuser_last_name'  => 'Text',
      'fbuser_data'       => 'Text',
      'created_date'      => 'Date',
      'modified_date'     => 'Date',
    );
  }
}

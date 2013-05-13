<?php

/**
 * Base project form.
 *
 * @package    frontend
 * @subpackage form
 * @author     thong.duong
 * @version    SVN: $Id: BaseForm.class.php 20147 2010-12-07 11:46:57Z FabianLange $
 */
class nfWinnerContactForm extends sfFormSymfony
{
  public function configure()
  {
    $this->setWidgets(array(
      "first_name" => new sfWidgetFormInputText(),
      "last_name" => new sfWidgetFormInputText(),
      "email_address" => new sfWidgetFormInputText(),
      "mailing_address" => new sfWidgetFormInputText(),
      "zip_code" => new sfWidgetFormInputText()
    ));

//    $this->widgetSchema->setNameFormat('winner_contact[%s]');

    $this->setValidators(array(
      "first_name" => new sfValidatorString(
        array('required' => true),
        array('required' => 'Please input your first name')
      ),
      "last_name" => new sfValidatorString(
        array('required' => true),
        array('required' => 'Please input your last name')
      ),
      "email_address" => new sfValidatorEmail(
        array('required' => true),
        array(
          'required' => 'Please input Email',
          'invalid' => 'The email address is invalid.'
        )
      ),
      "mailing_address" => new sfValidatorString(
        array('required' => true),
        array('required' => 'Please input your mailing address')
      ),
      "zip_code" => new sfValidatorAnd(array(
        new sfValidatorString(array('required' => true)),
        new sfValidatorRegex(array('pattern' => '/[0-9]{5}/')),
      ))
      /*"zip_code" => new sfValidatorString(
        array('required' => true,
              'min_length' => 5,
              'max_length' => 5
        ),
        array('required' => 'Please input your zip code',
              'min_length' => 'Please input your zip code 5 digits',
              'max_length' => 'Please input your zip code 5 digits'
        )
      )*/
    ));
  }
}

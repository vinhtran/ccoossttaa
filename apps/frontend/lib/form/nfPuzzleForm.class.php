<?php
class nfPuzzleForm extends sfFormSymfony
{
  public function configure()
  {
    $this->setWidgets(array(''));
    
    $this->widgetSchema->setNameFormat('puzzle[%s]');
    
    $this->setValidators(array('email' => new sfValidatorEmail(array('required' => true, 'trim' => true), array('required' => 'forgotpass.email.required', 'invalid' => 'forgotpass.email.invalid'))));
  }
}
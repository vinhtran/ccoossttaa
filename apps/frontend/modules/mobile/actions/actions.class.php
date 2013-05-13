<?php

/**
 * mobile actions.
 *
 * @package    nokia_facebook
 * @subpackage mobile
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class mobileActions extends sfActions
{
  const MOBILE_STEP_VALIDATED = 'validated';
  const MOBILE_STEP_WON = 'won';
  const MOBILE_STEP_CONTACTED = 'contacted';
  /**
   * (non-PHPdoc)
   * @see sfAction::preExecute()
   */
  public function preExecute()
  {
    $configuration = $this->getContext()->getConfiguration();

  	$folders = array('xml', 'swf', 'js', 'css', 'images', 'fonts');
  	$minFolder = $configuration->getEnvironment() != 'dev' ? /* 'min' */'' : '';

  	$assets = array();
  	foreach ($folders as $folder)
  	{
  		$assets['sf_web_'.$folder.'_dir_name'] = $configuration->getApplication().'/mobile/'.$folder.$minFolder;
  	}

  	sfConfig::add($assets);
  }

  public function executeValidate(sfWebRequest $request)
  {
    $today = date('Y-m-d H:i:s');
    $dateToday = date('Y-m-d');
//    $codeStr = AESHelper::safeB64decode($request->getParameter('codestr', NULL));
    $codeStr = $request->getParameter('codestr', NULL);

    //tracking validation
    $tracking = new TrackingValidation();
    $tracking->setCode($codeStr);
    $tracking->setCreatedDate(date('Y-m-d H:i:s'));
    $tracking->save();

    if ( $codeStr ) {

      //check into code table
      $code = CodesTable::checkCode($codeStr, $today);

      if ( $code ) {
        $fbuser_id = $code->getFbuserId();
        //check award available
        $award = AwardsTable::getAvailableAwards($today);

        //if there is award available
        if ( $award ){

          //check user already win
          if ( ! WinnersTable::checkAlreadyWin($fbuser_id) ) {

            $award_id = $award->getId();

            try {
              $winner = new Winners();
              $winner->setFbuserId($fbuser_id);
              $winner->setAwardId($award_id);
              $winner->setWinningDate(date('Y-m-d H:i:s'));
              $winner->save();

              //save to award table
              $award->setIsAvailable(0);
              $award->save();

              //set to session
              $this->getUser()->setAttribute( 'award', array( 'fbuser_id'=>$fbuser_id, 'award_id'=>$award_id ) );

            } catch (Exception $e) {
              $this->redirect('@mobile_lose?fbuser_id='.$fbuser_id);
            }

            $this->getUser()->setAttribute( 'step', array( self::MOBILE_STEP_VALIDATED ) );
            $this->redirect('@mobile_win');

          } else { //redirect already win
            $this->redirect('@mobile_already_win');
          }

        } else { //has no award
          $this->redirect('@mobile_lose?fbuser_id='.$fbuser_id);
        }

      }

    } //code invalid
    $this->redirect('@mobile_invalid');
  }



  public function executeLose(sfWebRequest $request)
  {
    //@todo how to get $fbuserId
    $fbuserId = $request->getParameter('fbuser_id', NULL);

    if ( !$fbuserId ) //code invalid
      $this->redirect('@mobile_invalid');

    $this->yourScore = CodesTable::getUserScore($fbuserId);

    $this->topPlayers = CodesTable::getTopPlayers();
  }

  public function executeInvalid(sfWebRequest $request)
  {

  }

  public function executeWin(sfWebRequest $request)
  {
    //check user go from validate function
    $step = $this->getUser()->getAttribute( 'step' );
    if ( ! is_array( $step ) || ! in_array( self::MOBILE_STEP_VALIDATED, $step ) )
      $this->redirect('@mobile_invalid');

    $award = $this->getUser()->getAttribute( 'award' );

    $fbuser_id = isset($award['fbuser_id']) ? $award['fbuser_id'] : 0;

    //check user already submited contact form
    if ( WinnersInformationTable::checkAlreadySubmitedContact($fbuser_id) ) {
      $this->redirect('@mobile_already_win');
    }


    array_push( $step, self::MOBILE_STEP_WON );
    $this->getUser()->setAttribute( 'step', $step );
  }

  public function executeWinnerContact(sfWebRequest $request)
  {
    //check user go from validate function
    $step = $this->getUser()->getAttribute( 'step' );
    if ( ! is_array( $step ) || ! in_array( self::MOBILE_STEP_VALIDATED, $step ) || ! in_array( self::MOBILE_STEP_WON, $step ) )
      $this->redirect('@mobile_invalid');

    $form = new nfWinnerContactForm();

    $award = $this->getUser()->getAttribute( 'award' );

    $fbuser_id = isset($award['fbuser_id']) ? $award['fbuser_id'] : 0;

    if ( $fbuser_id ){
      $user = FbusersTable::getInstance()->find( $fbuser_id );

      if ( $user ) {
        $form->setDefault('first_name', $user->getFbuserFirstName());
        $form->setDefault('last_name', $user->getFbuserLastName());
        $form->setDefault('email_address', $user->getFbuserEmail());
      }
    }

    //check user already submited contact form
    if ( WinnersInformationTable::checkAlreadySubmitedContact($fbuser_id) ) {
      $this->redirect('@mobile_already_win');
    }

    if($request->isMethod('post')) {
    	$form->bind($request->getPostParameters());
    	$formParameter = $request->getPostParameters();


    	if ( $form->isValid() )
    	{
    		if ( $award ) {

                try {
        			$user1 = new WinnersInformation();
        			$user1->setFbuserId($fbuser_id);
        			$user1->setAwardId($award['award_id']);
        			$user1->setFirstName($formParameter['first_name']);
        			$user1->setLastName($formParameter['last_name']);
        			$user1->setEmailAddress($formParameter['email_address']);
        			$user1->setZipCode($formParameter['zip_code']);
        			$user1->setMailingAddress($formParameter['mailing_address']);
        			$user1->setCreatedDate(/*new Doctrine_Expression('NOW()')*/date('Y-m-d H:i:s'));
        			$user1->setModifiedDate(/*new Doctrine_Expression('NOW()')*/date('Y-m-d H:i:s'));
        			$user1->save();

        			array_push( $step, self::MOBILE_STEP_CONTACTED );
                    $this->getUser()->setAttribute( 'step', $step );

                    //send mail
                    $this->_sendMailWinner($formParameter['last_name'].' '.$formParameter['first_name'], $formParameter['email_address']);

                    //send mail to inviter
                    $inviter = InvitationsTable::getInviter( $fbuser_id );
                    if ( $inviter ) {
                      $inviterId = $inviter->getInviterId();
                      //check if inviter won
                      if ( ! WinnersTable::checkAlreadyWin($inviterId) ) { // inviter has not won

                        //get inviter info
                        $inviterInfo = FbusersTable::getInstance()->find($inviterId);
                        if ( $inviterInfo ) {
                          $winInviter = new Winners();
                          $winInviter->setAwardId($award['award_id']);
                          $winInviter->setFbuserId($inviterId);
                          $winInviter->setWinningDate(date('Y-m-d H:i:s'));
                          $winInviter->save();
                          
                          //send mail
                          $name = $user->getFbuserLastName() . ' ' . $user->getFbuserFirstName();
                          $this->_sendMailInviter($name, $inviterInfo->getFbuserEmail());
                        }

                      }

                    }

        			$this->redirect('@mobile_thank_you');

                } catch ( Exception $e ) {
                  $this->redirect('@mobile_already_win');
                }


    		} else {
    		    $this->redirect('@mobile_validate_code?codestr='.base64_encode('fail'));
    		}
    	}

    }
    $this->form = $form;
  }

  public function executeAlreadyWin(sfWebRequest $request)
  {

  }

  public function executeThankYou(sfWebRequest $request)
  {
    //check user go from validate function
    $step = $this->getUser()->getAttribute( 'step' );
    if ( ! is_array( $step ) || ! in_array( self::MOBILE_STEP_VALIDATED, $step ) || ! in_array( self::MOBILE_STEP_WON, $step ) || ! in_array( self::MOBILE_STEP_CONTACTED, $step ) )
      $this->redirect('@mobile_invalid');
  }

  private function _sendMailWinner($name, $email)
  {
    //send mail
    try {
      $content = $this->getPartial('mobile/mailwinner');
      $subject = 'Bien joué ! Le dernier Nokia Lumia 800 est à vous !';

      $fromAddress = sfConfig::get('app_administrator_email');
      $fromName = sfConfig::get('app_administrator_name');

      $mailMsg = Swift_Message::newInstance();

      $mailMsg->setFrom($fromAddress, $fromName);
      $mailMsg->setSender($fromAddress, $fromName);
      $mailMsg->setTo($email, $name);
      $mailMsg->setSubject($subject);
      $mailMsg->setBody($content, 'text/html', 'UTF-8');

      $this->getMailer()->send($mailMsg);
    } catch (Exception $e) {
      $errorMessage = 'Send mail error: ' . $e->getMessage();
      $this->getLogger()->err($errorMessage);
    }

  }

  private function _sendMailInviter($name, $email)
  {
    //send mail
    try {
      $content = $this->getPartial('mobile/mailinviter');
      $content = str_replace('[#name]', $name, $content);
      $subject = 'Bien joué ! Le dernier Nokia Lumia 800 est à vous !';

      $fromAddress = sfConfig::get('app_administrator_email');
      $fromName = sfConfig::get('app_administrator_name');

      $mailMsg = Swift_Message::newInstance();

      $mailMsg->setFrom($fromAddress, $fromName);
      $mailMsg->setSender($fromAddress, $fromName);
      $mailMsg->setTo($email, $name);
      $mailMsg->setSubject($subject);
      $mailMsg->setBody($content, 'text/html', 'UTF-8');

      $this->getMailer()->send($mailMsg);
    } catch (Exception $e) {
      $errorMessage = 'Send mail error: ' . $e->getMessage();
      $this->getLogger()->err($errorMessage);
    }

  }
}

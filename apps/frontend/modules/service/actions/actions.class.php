<?php

/**
 * service actions.
 *
 * @package    nokia_facebook
 * @subpackage service
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class serviceActions extends sfActions
{
  /**
   * (non-PHPdoc)
   * @see sfAction::preExecute()
   */
  public function preExecute()
  {
    $this->getResponse()->setHttpHeader('Content-Type', 'application/json; charset=utf-8');
    $this->setLayout(false);
  }
  /**
   * Execute share Facebook action
   * @param sfWebRequest $request
   */
  /* public function executeShareFacebook(sfWebRequest $request)
  {
    $partialVars = array(
      'appID' => sfFacebookSDKWrapper::getInstance()->getAppId(),
      'title' => 'Title to sharing on Facebook',
      'description' => 'Description to sharing on Facebook',
      'image' => image_path('', true),
      'url' => public_path('', true),
      'callbackUrl' => sfFacebookSDKWrapper::getInstance()->getPageLink()
    );

    $this->setLayout(false);

    return $this->renderPartial('shareFacebook', $partialVars);
  } */

  /**
   * Execute share Twitter action
   * @param sfWebRequest $request
   */
  /* public function executeShareTwitter(sfWebRequest $request)
  {
    $partialVars = array(
      'title' => 'Title to sharing on Twitter',
      'callbackUrl' => sfFacebookSDKWrapper::getInstance()->getPageLink()
    );

    $this->setLayout(false);

    return $this->renderPartial('shareTwitter', $partialVars);
  } */

  /**
   * Execute save Facebook user information
   *
   * @param sfWebRequest $request
   */
  public function executeSaveUserInfo(sfWebRequest $request)
  {
//    sleep(30);
    try
    {
      $profile = sfFacebookSDKWrapper::execute('getUserProfile', $throwException = true);

      /*if ($profile['locale'] != sfConfig::get('app_facebookApp_userLocale'))
      {
        throw new Exception('Only French is used this app', 403);
      }*/

      $fbUser = FbusersTable::getInstance()->findOneByFbuserId($profile['id']);
//       var_dump($fbUser);die;
      $date = date('Y-m-d H:i:s');
      $dateToday = date('Y-m-d');

      if (!$fbUser)
      {
        $fbUser = new Fbusers();
        $fbUser->setCreatedDate($date);
        $fbUser->setFbuserId($profile['id']);
      }

      $fbUser->setFbuserEmail($profile['email']);
      $fbUser->setFbuserFirstName($profile['first_name']);
      $fbUser->setFbuserLastName($profile['last_name']);
      $fbUser->setFbuserData(serialize($profile));
      $fbUser->setModifiedDate($date);
      $fbUser->save();

      //tracking invitation
      $inviter_id = $this->getUser()->getAttribute('inviter_id');

      if ( $inviter_id ) {
        $inviterUser = FbusersTable::getInstance()->find($inviter_id);

        if ($inviterUser)
        {

          try {

            $invitation = new Invitations();
    		$invitation->setInviterId($inviter_id);
    		$invitation->setInviteeId($profile['id']);
    		$invitation->setAcceptedDate($date);
    		$invitation->save();

          } catch ( Exception $e ) { //exist in table invitation

          }
        }
      }

      return $this->renderText(json_encode(array(
        'status' => 1,
        'redirect_url' => CodesTable::isPlayed($profile['id'], $dateToday) ?
          $this->getController()->genUrl('@fb_puzzle_played', true) : $this->getController()->genUrl('@fb_puzzle_game', true)
      )));
    }
    catch (Exception $e)
    {
      return $this->renderText(json_encode(array('status' => 0, 'message' => $e->getMessage())));
    }
  }

  /**
   * Tracking invitation
   * @param sfWebRequest $request
   */
  public function executeInvitationTracking(sfWebRequest $request)
  {
  	$isAjax = $request->isXmlHttpRequest();
  	$userProfile = sfFacebookSDKWrapper::execute('getUserProfile');
  	if ($isAjax && $userProfile)
  	{
  		$request_id = $request->getPostParameter('request_id');
  		$to = $request->getPostParameter('to');
  		$user_id = $userProfile['id'];

  		$fbUserCurrent = FbusersTable::getInstance()->find($user_id);

		$date = date('Y-m-d H:i:s');

  		//check user login is exists in table fbuser
  		if (!$fbUserCurrent)
  		{
  			$fbUser = new Fbusers();
  			$fbUser->setFbuserId($user_id);
  			$fbUser->setCreatedDate($date);
  			$fbUser->setModifiedDate($date);
  			$fbUser->save();
  		}

  		foreach ( $to as $r )
  		{
  			$fbUser = FbusersTable::getInstance()->find($r);

  			//if there is not user in user table, insert it
  			if (!$fbUser)
  			{
  				$fbUser = new Fbusers();
  				$fbUser->setFbuserId($r);
  				$fbUser->setCreatedDate($date);
  				$fbUser->setModifiedDate($date);
  				$fbUser->save();
  			}

  			$invitation = new Invitations();
  			$invitation->setFbrequestId($request_id);
  			$invitation->setInviterId($user_id);
  			$invitation->setInviteeId($r);
  			$invitation->setRequestedDate(/*new Doctrine_Expression('NOW()')*/$date);
  			$invitation->save();
  		}
  	}
  	$this->setLayout(false);
  	$returnText = '';
  	return $this->renderText($returnText);
  }

  public function executeValidatePuzzle(sfWebRequest $request)
  {
    try
    {
      $today = date('Y-m-d H:i:s');
      $dateToday = date('Y-m-d');

      $user = $this->getUser();
      $fbuserId = $user->getAttribute('fb_user_id', null, nfPuzzleQRCodeWrapper::PUZZLE_GAME_NAMESPACE);

      if ($fbuserId != sfFacebookSDKWrapper::getInstance()->getUser())
      {
        throw new Exception('Invalid user', 500);
      }

      $steps = $request->getPostParameter('s', NULL);
      $numberOfSecond = $request->getPostParameter('t', NULL);
      $userPuzzleStr = $request->getPostParameter('up', NULL);

      $initPuzzleStr = $user->getAttribute('init_puzzle_string', null, nfPuzzleQRCodeWrapper::PUZZLE_GAME_NAMESPACE);

      if (empty($steps) || empty($numberOfSecond) || empty($userPuzzleStr) || empty($initPuzzleStr))
      {
        throw new Exception('Missing params.', 500);
      }

      $resultPuzzle = sfConfig::get('app_puzzleGame_piecesName');
      $resultPuzzleStr = nfPuzzleQRCodeWrapper::puzzleToString($resultPuzzle);
//      var_dump($resultPuzzle);
      if ($userPuzzleStr != $resultPuzzleStr)
      {
        throw new Exception('Wrong result.', 500);
      }
//      echo '<pre>';
//      var_dump($steps);
//      var_dump($initPuzzleStr);
/*
      $simulatePuzzle = nfPuzzleQRCodeWrapper::doMove($resultPuzzle, $steps, array('x' => 2, 'y' => 2), true);
      $simulatePuzzleStr = nfPuzzleQRCodeWrapper::puzzleToString($simulatePuzzle['puzzle']);

      if ($simulatePuzzleStr != $initPuzzleStr)
      {
        throw new Exception('Wrong number of second.', 500);
      }
*/
      $codeRecord = CodesTable::getCodeRecord($fbuserId, $dateToday);

      if (empty($codeRecord) || (!empty($codeRecord) && $codeRecord->getFinished()))
      {
        throw new Exception('Wrong data', 500);
      }

      $codeRecord->setFinished(1);
      $codeRecord->setFinishedDate($today);
      $codeRecord->setNumberOfSecond($numberOfSecond);
      $codeRecord->save();

      $user->getAttributeHolder()->removeNamespace(nfPuzzleQRCodeWrapper::PUZZLE_GAME_NAMESPACE);

      $user->setAttribute('finished', true, nfPuzzleQRCodeWrapper::PUZZLE_END_NAMESPACE);
      $user->setAttribute('fb_user_id', $fbuserId, nfPuzzleQRCodeWrapper::PUZZLE_END_NAMESPACE);
      $user->setAttribute('finished_date', $dateToday, nfPuzzleQRCodeWrapper::PUZZLE_END_NAMESPACE);

      return $this->renderText(json_encode(array(
      	'status' => 1,
      	'redirect_url' => $this->getController()->genUrl('@fb_puzzle_end', true)
      )));
    }
    catch (Exception $e)
    {
      $this->getLogger()->err('Puzzle Validate Error: '.$e->getMessage());

      $user->getAttributeHolder()->removeNamespace(nfPuzzleQRCodeWrapper::PUZZLE_GAME_NAMESPACE);

      return $this->renderText(json_encode(array(
      	'status' => 0,
      	'error_404_url' => $this->getController()->genUrl(sfConfig::get('sf_error_404_module').'/'.sfConfig::get('sf_error_404_action'), true)
      )));
    }
  }

  public function executeInvitation(sfWebRequest $request)
  {
    $this->getResponse()->setHttpHeader('Content-Type', 'text/html; charset=utf-8', TRUE);

    $this->getContext()->getConfiguration()->loadHelpers('Url');

    $inviter_id = $request->getParameter('inviter_id');

    $callbackUrl = sfFacebookSDKWrapper::getInstance()->getPageLink();

    if ( ! $inviter_id )
      $this->redirect( $callbackUrl );

    $user = $this->getUser();
    $user->setAttribute('inviter_id', $inviter_id);

    $this->partialVars = array(
      'appID' => sfFacebookSDKWrapper::getInstance()->getAppId(),
      'title' => '6 Nokia Lumia 800 à gagner !',
      'description' => "Tentez de gagner un Nokia Lumia 800 en reconstituant le plus rapidement possible le QR code et flashez-le ! Augmentez vos chances de gagner en invitant vos amis : s'ils gagnent, vous gagnez aussi !",
      'image' => public_path('frontend/fbapp/images/icon.jpg', true),
      'url' => $this->getController()->genUrl('@service_invitation?inviter_id='.$inviter_id, TRUE),
      'callbackUrl' => $callbackUrl
    );
    $this->setLayout(FALSE);
  }
  
  public function executePlayedPuzzle(sfWebRequest $request)
  {
    try 
    {
      $date = date('Y-m-d H:i:s');
      $dateToday = date('Y-m-d');
      $codeRecord = CodesTable::getCodeRecord($this->getUser()->getFbUserId(), $dateToday);
      
      if (!$codeRecord)
      {
        throw new Exception('Marked played fail.', 500);
      }
      
      $codeRecord->setPlayedDate($date);
      $codeRecord->save();
      return $this->renderText(json_encode(array('status' => 1)));
    }
    catch (Exception $e)
    {
      $this->getLogger()->err($e->getMessage());
      return $this->renderText(json_encode(array('status' => 0)));
    }
  }
}

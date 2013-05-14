<?php

/**
 * fbapp actions.
 *
 * @package    nokia_facebook
 * @subpackage fbapp
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class fbappActions extends sfActions
{
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
  		$assets['sf_web_'.$folder.'_dir_name'] = $configuration->getApplication().'/fbapp/'.$folder.$minFolder;
  	}

  	sfConfig::add($assets);
  }

  /**
   * Execute page on Facebook
   * @param sfWebRequest $request
   */
  public function executePage(sfWebRequest $request)
  {
    $user_id = sfFacebookSDKWrapper::getInstance()->getUser();

    /*if ( $request->getGetParameter('request_ids') && $user_id )
    {
      $request_ids = explode( ',', urldecode($request->getGetParameter('request_ids')) );

      //@todo
      if ( is_array( $request_ids ) ) {
        //delete request app
        sfFacebookSDKWrapper::getInstance()->delAppRequest($request_ids);
        //update accepted date
        InvitationsTable::updateByInviteeIdAndRequestIds( $user_id, $request_ids );
      }

    }*/

//    $this->numOfAvailableAwards = AwardsTable::numberOfAvailableAwards();

    if ($this->getUser()->likedPage())
    {
      $this->setTemplate('pageFan');
      $this->getResponse()->setSlot('fbFuncName', array('fb_resize_event', 'fb_login_event'));
    }
    else
    {
      $this->setTemplate('pageNonFan');
      $this->getResponse()->setSlot('fbFuncName', array('fb_resize_event'));
    }
    
    $this->getResponse()->setSlot('firstNote', true);
  }

  /**
   * Execute puzzle game page on Facebook
   * @param sfWebRequest $request
   */
  public function executePuzzleGame(sfWebRequest $request)
  {
    $response = $this->getResponse();
    $response->setSlot('shareBlock', TRUE);
    $response->setSlot('fbFuncName', array('fb_resize_event', 'fb_share'));

    $today = date('Y-m-d H:i:s');
    $dateToday = date('Y-m-d');
    $fbuserId = $this->getUser()->getFbUserId();

    if (CodesTable::isPlayed($fbuserId, $dateToday))
    {
      $this->forward('fbapp', 'puzzlePlayed');
    }

    $codeRecord = CodesTable::checkIfCodeCreated($fbuserId, $dateToday);
    if ($codeRecord)
    {
      $userFolder = $codeRecord->getUserFolder();
      $stringCode = $codeRecord->getStringCode();
    } 
    else 
    {
      $userFolder = md5($fbuserId);
      $stringCode = nfPuzzleQRCodeWrapper::generateStringCode($fbuserId, $today);
      
      $codeRecord = new Codes();
      $codeRecord->setFbuserId($fbuserId);
      $codeRecord->setStringCode($stringCode);
      $codeRecord->setUserFolder($userFolder);
      $codeRecord->setCreatedDate($today);
      $codeRecord->save();
//      var_dump($urlCode);die;
    }

//    if (!file_exists(nfPuzzleQRCodeWrapper::getInstance()->getCacheDir().DIRECTORY_SEPARATOR.$dateToday.DIRECTORY_SEPARATOR.$userFolder.'.png'))
//    {
      $urlCode = nfPuzzleQRCodeWrapper::generateURLCode($stringCode);
      
      //generate short url (add by quocviet.hoang 2012/10/04
      $this->getContext()->getConfiguration()->loadHelpers('Bitly');
      $urlCode = get_bitly_short_url($urlCode, sfConfig::get('app_bitly_loginName'), sfConfig::get('app_bitly_api_key'));
      
      nfPuzzleQRCodeWrapper::createPuzzleForUser($urlCode, $dateToday, $userFolder);
//    }
    
/*
    $randomResult = nfPuzzleQRCodeWrapper::randomPuzzle();

    $game = nfPuzzleQRCodeWrapper::moveTo9thPosition($randomResult['puzzle'], $randomResult['steps'], $randomResult['current_position']);

    $this->randomPuzzle = nfPuzzleQRCodeWrapper::puzzleToString($game['puzzle']);
*/
    $game = nfPuzzleQRCodeWrapper::randomBlocks();
    $this->randomPuzzle = nfPuzzleQRCodeWrapper::puzzleToString($game['puzzle']);
//    echo '<pre>';
//    var_dump($game);die;

    $this->getUser()->setAttribute('init_puzzle_string', $this->randomPuzzle, nfPuzzleQRCodeWrapper::PUZZLE_GAME_NAMESPACE);
    $this->getUser()->setAttribute('fb_user_id', $fbuserId, nfPuzzleQRCodeWrapper::PUZZLE_GAME_NAMESPACE);

    //@todo must remove these code lines
//    $this->steps = $game['steps'];
    
    $this->qrCodePath = $this->getContext()->getConfiguration()->getApplication().'/qrcode/'.$dateToday.'/'.$userFolder;
    
  }

  /**
   * Execute puzzle end page on Facebook
   * @param sfWebRequest $request
   */
  public function executePuzzleEnd(sfWebRequest $request)
  {
    try {
      $response = $this->getResponse();
      $response->setSlot('shareBlock', TRUE);
      $response->setSlot('fbFuncName', array('fb_resize_event', 'fb_share', 'fb_invite'));

      $user = $this->getUser();
      $finishedGame = $user->getAttribute('finished', null, nfPuzzleQRCodeWrapper::PUZZLE_END_NAMESPACE);
      $fbuserId = $user->getAttribute('fb_user_id', null, nfPuzzleQRCodeWrapper::PUZZLE_END_NAMESPACE);
      $finishedDate = $user->getAttribute('finished_date', null, nfPuzzleQRCodeWrapper::PUZZLE_END_NAMESPACE);

      if ($fbuserId != sfFacebookSDKWrapper::getInstance()->getUser() || !$finishedGame)
      {
        throw new Exception('Invalid user', 500);
      }

      $codeRecord = CodesTable::getCodeRecord($fbuserId, $finishedDate);
      if (empty($codeRecord) || (!empty($codeRecord) && !$codeRecord->getFinished()))
      {
        throw new Exception('Not finished game yet', 500);
      }

      $this->resultImageURL = $this->getContext()->getConfiguration()->getApplication().'/qrcode/'.$finishedDate.'/'.$codeRecord->getUserFolder().'.png';

      $user->getAttributeHolder()->removeNamespace(nfPuzzleQRCodeWrapper::PUZZLE_END_NAMESPACE);
    }
    catch (Exception $e)
    {
      $this->getLogger()->err('Puzzle End Error: '.$e->getMessage());
      $this->forward404();
    }
    
    $this->getResponse()->setSlot('secondNote', true);
  }

  /**
   * Execute puzzle game page on Facebook
   * @param sfWebRequest $request
   */
  public function executePuzzlePlayed(sfWebRequest $request)
  {
  	$response = $this->getResponse();
  	$response->setSlot('shareBlock', TRUE);
  	$response->setSlot('fbFuncName', array('fb_resize_event', 'fb_share', 'fb_invite'));

  	$this->yourScore = CodesTable::getUserScore($this->getUser()->getFbUserId());
  	
  	$response->setSlot('secondNote', true);
  }

  /**
   * Execute 404 page on Facebook
   * @param sfWebRequest $request
   */
  public function executeError404(sfWebRequest $request)
  {
    return $this->_redirectInIframe();
  }

  /**
   * Execute login page on Facebook
   * @param sfWebRequest $request
   */
  public function executeLogin(sfWebRequest $request)
  {
    return $this->_redirectInIframe();
  }

  /**
   * Execute secure page on Facebook
   * @param sfWebRequest $request
   */
  public function executeSecure(sfWebRequest $request)
  {
    return $this->_redirectInIframe();
  }

  /**
   * Util function for redirect in iframe
   */
  private function _redirectInIframe()
  {
    $this->setLayout(false);
    $this->getResponse()->setHttpHeader('Content-Type', 'text/html; charset=utf-8');
    return $this->renderPartial('redirect', array('url' => sfFacebookSDKWrapper::getInstance()->getPageLink()));
  }
}

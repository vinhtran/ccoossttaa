<?php

/**
 * test actions.
 *
 * @package    nokia_facebook
 * @subpackage test
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class testActions extends sfActions
{
  /**
   * (non-PHPdoc)
   * @see sfAction::preExecute()
   */
  public function preExecute()
  {
    if (!in_array($this->getContext()->getConfiguration()->getEnvironment(), array('dev', 'test')))
    {
      $this->forward404();
    }
    
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

  public function executeQr()
  {
    $this->getContext()->getConfiguration()->loadHelpers('Bitly');
    $today = date('Y-m-d');
    $fbID = '1270618601';
    $userFolder = md5($fbID);
    $url = nfPuzzleQRCodeWrapper::generateURLCode(nfPuzzleQRCodeWrapper::generateStringCode($fbID, $today));
//    nfPuzzleQRCodeWrapper::createPuzzleForUser($url, $today, $userFolder);
var_dump($url);
$short_url = get_bitly_short_url($url,'bali99','R_1513aec63b6154316793f36e692c225a');
var_dump($short_url);
var_dump(get_bitly_long_url($short_url,'bali99','R_1513aec63b6154316793f36e692c225a'));
    $this->setLayout(false);
    return sfView::NONE;
  }

  public function executeRand()
  {
    echo '<pre>';
    $puzzle = array(array('A', 'B', 'C'), array('D', 'E', 'F'), array('G', 'H', 'I'));

    $result = nfPuzzleQRCodeWrapper::randomPuzzle($puzzle);

    print_r($result);
    $result1 = nfPuzzleQRCodeWrapper::moveTo9thPosition($result['puzzle'], $result['steps'], $result['current_position']);


    print_r($result1);
    if ($result1 !== FALSE)
    {
      $result2 = nfPuzzleQRCodeWrapper::doMove($result1['puzzle'], $result1['steps'], $result1['current_position'], true);
      print_r($result2);
    }

    die;
  }

  public function executeGen()
  {
    $fbID = '1193435953';
    $date = date('Y-m-d');
    $url = nfPuzzleQRCodeWrapper::generateURLCode(nfPuzzleQRCodeWrapper::generateStringCode($fbID, $date));
    var_dump($url);die;
  }

  public function executePostWall(sfWebRequest $request)
  {
    $this->getResponse()->setSlot('fbFuncName', array('fb_resize_event', 'fb_post_wall'));
  }

  public function executeInvite(sfWebRequest $request)
  {
//    $this->setLayout(false);
    $this->getResponse()->setSlot('fbFuncName', array('fb_resize_event', 'fb_login_event', 'fb_invite'));
  }

  public function executeSendMail(sfWebRequest $request)
  {
    $name = $email = 'manlyboy85@yahoo.com';
    $this->_sendMailWinner($name, $email);
    exit;
  }

  private function _sendMailWinner($name, $email)
  {
    //send mail
    try {
      $content = $this->getPartial('mobile/mailwinner');
      $subject = 'Le dernier Nokia Lumia 800 est pour vous grâce à Orange Caraïbe!';

      $fromAddress = sfConfig::get('app_administrator_email');
      $fromName = sfConfig::get('app_administrator_name');

      $mailMsg = Swift_Message::newInstance();

      $mailMsg->setFrom($fromAddress, $fromName);
      $mailMsg->setSender($fromAddress, $fromName);
      $mailMsg->setTo($email, $name);
      $mailMsg->setSubject($subject);
      $mailMsg->setBody($content, 'text/html', 'UTF-8');

      $this->getMailer()->send($mailMsg);
      echo 'send mail ok';
    } catch (Exception $e) {
      $errorMessage = 'Send mail error: ' . $e->getMessage();
      var_dump($errorMessage);
      $this->getLogger()->err($errorMessage);
    }

  }
  
  public function executeNew()
  {
    echo '<pre>';
    $result = nfPuzzleQRCodeWrapper::randomBlocks();
    var_dump($result);
    
    
    
    
    die;
  }
}

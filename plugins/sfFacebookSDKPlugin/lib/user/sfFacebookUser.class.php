<?php
/**
 * 
 * Enter description here ...
 * @author Thang Pham <thang.pham@vn.pyramid-consulting.com>
 *
 */
class sfFacebookUser extends sfBasicSecurityUser
{
	/**
	 * All information of the Facebook profile 
	 * @var mixed
	 */
	private $fb_user_id;
	
	/**
	 * User namespace
	 * @var string
	 */
	const USER_NAMSPACE = 'sfFacebookUser';
	
	/**
	 * User credential
	 * @var string
	 */
	const USER_CREDENTIAL = 'FACEBOOK_CREDENTIAL';
	
	/**
	 * @see sfUser::__construct()
	 */
	public function __construct(sfEventDispatcher $dispatcher, sfStorage $storage, $options = array()) 
	{
		parent::__construct($dispatcher, $storage, $options);
		
		$this->fb_user_id = $this->getAttribute('fb_user_id', '0', self::USER_NAMSPACE);
	}
	
	/**
	 * Set Facebook user id
	 * @param string $fbUserId
	 */
	public function setFbUserId($fbUserId)
	{
		$this->setAttribute('fb_user_id', $fbUserId, self::USER_NAMSPACE);
		$this->fb_user_id = $fbUserId;
	}
	
	/**
	 * Get Facebook user id
	 * @return string
	 */
	public function getFbUserId()
	{
		return $this->fb_user_id;
	}
	
	/**
	 * Clear Facebook user id
	 */
	public function clearFbUserId()
	{
	  $this->fb_user_id = NULL;
	  $this->getAttributeHolder()->remove('fb_user_id', NULL, self::USER_NAMSPACE);
	}
	
	/**
	 * Do login for facebook user
	 * 
	 * @param string $fbUserId
	 */
	public function doLogin($fbUserId)
	{
		$this->setAuthenticated(true);
		$this->setFbUserId($fbUserId);
	}
	
	/**
	 * Do logout
	 */
	public function doLogout()
	{
		$this->setAuthenticated(false);
		$this->clearFbUserId();
		$this->removeCredential(self::USER_CREDENTIAL);
	}
	
	/**
	 * check if have to relogin
	 * 
	 * @param string $fbUserId
	 */
	public function haveToRelogin($fbUserId)
	{
		return $this->getFbUserId() != $fbUserId;
	}
	
	/**
	 * Check if the user liked the page
	 * 
	 * @param string $pageId
	 */
	public function likedPage($pageId = NULL)
	{
	  $fbIns = sfFacebookSDKWrapper::getInstance();
	  
	  $pageLiked = false;
	  if ($pageId === NULL) 
	  {
	    $pageLiked = $fbIns->checkIfPageLiked();
	  } 
	  else 
	  {
	  	//by pass checking if user already liked the page
	    /*$likePageInfo = sfFacebookSDKWrapper::execute('checkIfUserLikedPage', false, $pageId);

	    //in the case, user already accepted app but may be not liked the page yet
      	  if (count($likePageInfo['data'])
              && isset($likePageInfo['data'][0]['id'])
              && $likePageInfo['data'][0]['id'] == $fbIns->getPageId()) 
      	  {
            $pageLiked = true;
          } 
          //in the case, user not accept app
          elseif ($likePageInfo === FALSE)
          {
            $this->doLogout();
          }*/
          $pageLiked = true;
	  }

	  if ($pageLiked) 
	  {
	    $this->addCredentials(self::USER_CREDENTIAL);
      return true;
	  }
    
    $this->removeCredential(self::USER_CREDENTIAL);
	  return false;
	}
}

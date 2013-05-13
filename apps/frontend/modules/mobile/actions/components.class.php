<?php

class mobileComponents extends sfComponents
{
  public function executeHeader(sfWebRequest $request)
  {
    
  }
  
  public function executeFooter(sfWebRequest $request)
  {
  
  }
  
	/**
	 * Share Block 
	 * @param sfWebRequest $request
	 */
	public function executeShareBlock(sfWebRequest $request)
	{
	  $this->facebookVars = array(
  		'link' => /*$this->getController()->genUrl('@service_share_facebook', true)*/sfFacebookSDKWrapper::getInstance()->getPageLink(),
  		'picture' => image_path('icon.jpg', true),
  		'name' => '6 Nokia Lumia 800 à gagner !',
  		'caption' => '6 Nokia Lumia 800 à gagner !',
  		'description' => "Tentez de gagner un Nokia Lumia 800 en reconstituant le plus rapidement possible le QR code et flashez-le ! Augmentez vos chances de gagner en invitant vos amis : s'ils gagnent, vous gagnez aussi !",
	    /*
	     * ref must be a ","-separated list, consisting of at most 5 distinct items, 
	     * each of length at least 1 and at most 15 characters drawn 
	     * from the set "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz_" :((
	     */
   		'ref' => $this->getContext()->getActionName()
	  );
	  
	  /*$twitterVars = array(
  		'data-lang' => 'fr',
  		'data-url' => $this->getController()->genUrl('@service_share_twitter', true),
  		// 	    'data-via' => 'your_screen_name',
  		'data-text' => 'Sharing text',
  		// 	    'data-related' => 'fr',
  		'data-count' => 'none' //vertical or horizontal or none
	  );
	  
	  $this->twitterShareConfig = '';
	  foreach ($twitterVars as $attrName => $attrVal)
	  {
	    $this->twitterShareConfig .= "$attrName=$attrVal ";
	  }
	  */
	  $twitterVars = array(
  		'lang' => 'fr',
  		'url' => 'https://www.facebook.com/Orange.Caraibe',
  		// 	    'data-via' => 'your_screen_name',
  		'text' => 'Le dernier Nokia Lumia 800 ? A gagner sur la page Orange Caraïbe: '.sfConfig::get('app_facebookApp_userLocale'),
  		// 	    'data-related' => 'fr',
  		'count' => 'none' //vertical or horizontal or none
	  );
	  
	  $this->twitterShareConfig = http_build_query($twitterVars, '', '&');
	}
}
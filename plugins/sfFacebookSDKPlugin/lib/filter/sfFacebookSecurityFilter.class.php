<?php
/**
 * Facebook Security Filter
 *
 * @author Thang Pham <thang.pham@vn.pyramid-consulting.com>
 */

class sfFacebookSecurityFilter extends sfBasicSecurityFilter
{
  /**
   * Executes this filter.
   * @author thang.pham
   * @param sfFilterChain $filterChain A sfFilterChain instance
   */
  public function execute($filterChain)
  {
    /*
     * https://developers.facebook.com/docs/authentication/
     */
    $context = $this->getContext();
    $user = $context->getUser();
    $controller = $context->getController();
    $request = $context->getRequest();
    $fbIns = sfFacebookSDKWrapper::getInstance();
    
    /*
     * FB send aparam "error" when user denied the "Request for permission"
     *
     * Example:
     * 	http://YOUR_URL?error_reason=user_denied&error=access_denied&error_description=The+user+denied+your+request.
     * 
     * We will redirect to Page in this case
     */
    $error = $request->getGetParameter('error', null);
    if (!empty($error) && $error == 'access_denied') 
    {
      $controller->redirect($fbIns->getPageLink());
    }
    
    /*
     * FB send a param "code" when user agreed
     * 
     * http://YOUR_URL?code=A_CODE_GENERATED_BY_SERVER
     * 
     * We will redirect to App Page with current path in this case
     */
    $code = $request->getGetParameter('code', null);
    if (!empty($code)) 
    {
      $getParams = $request->getGetParameters();
      //unset 2 params as FB return for us
      unset($getParams['code'], $getParams['state']);
      
      $currentPath = $request->getUriPrefix().$request->getPathInfoPrefix().$request->getPathInfo();
      if (count($getParams)) 
      {
        $currentPath .= '?'.http_build_query($getParams, null, '&');
      }
      
      $pageLink = $fbIns->getPageLink();
      
      $redirectLink = $pageLink.(strpos($pageLink, '?') === FALSE ? '?' : '&').'app_data='.base64_encode($currentPath);
      $controller->redirect($redirectLink);
    }

    // Get User ID
    $fbUser = $fbIns->getUser();

    if (!empty($fbUser)) 
    {
      //do login the current user
      if (!$user->isAuthenticated() 
          || ($user->isAuthenticated() && $user->haveToRelogin($fbUser))) 
      {
        $user->doLogin($fbUser);
      }
      
      //try to check if user liked the page
      try 
      {
        $user->likedPage($fbIns->getPageId());
      } 
      catch (Exception $e) 
      {
        //any exeception in web service will cause to logout user and redirect to error404 page
  	    $user->doLogout();
  	    
  	    $controller->forward(sfConfig::get('sf_error_404_module'), sfConfig::get('sf_error_404_action'));
  	  }
    } 
    else 
    {
      $user->doLogout();
    }
    
    parent::execute($filterChain);
	}
}

<?php
/**
 *
 * Facebook Wrapper
 * @author Thang Pham <thang.pham@vn.pyramid-consulting.com>
 *
 */
class sfFacebookSDKWrapper extends Facebook
{
  /**
   * Flag for generate URL for App page
   * @var string
   */
  const LINK_TYPE = 'FACEBOOK_APP_LINK';

  /**
   * The Page id
   * @var string
   */
  private $page_id;

  /**
   * The Page link
   * @var string
   */
  private $page_link;

  /**
   * The Application link
   * @var string
   */
  private $app_link;

  /**
   * All required permission for the App
   * @var array
   */
  private $app_required_permission;

  /**
   * sfFacebookSDKWrapper instance
   * @var sfFacebookSDKWrapper
   */
  protected static $_instance;

  /**
   * @see Facebook::__constructor()
   *
   * Initialize more three property: $page_id, $app_link and $page_link
   */
  public function __construct()
  {
    $config = array(
      'appId' => sfConfig::get('app_facebookApp_appId'),
      'secret' => sfConfig::get('app_facebookApp_appSecret')
    );

    $this->page_id = sfConfig::get('app_facebookApp_pageId');
    $this->page_link = sfConfig::get('app_facebookApp_pageLink');
    $this->app_link = sfConfig::get('app_facebookApp_appLink');
    $this->app_required_permission = sfConfig::get('app_facebookApp_appRequiredPermission');

    parent::__construct($config);
  }

  /**
   * Get Application link in configuration
   * @return string
   */
  public function getAppLink()
  {
    return $this->app_link;
  }

  /**
   * Get Page Link in configuration
   * @return string
   */
  public function getPageLink()
  {
    return $this->page_link;
  }

  /**
   * Get Page Link in configuration
   * @return string
   */
  public function getPageId()
  {
    return $this->page_id;
  }

  /**
   * Get all required permission on the App
   * @return array
   */
  public function getAppRequiredPermission()
  {
    return $this->app_required_permission;
  }

  /**
   * Get instance
   * @return sfFacebookSDKWrapper
   */
  public static function getInstance()
  {
    if (!isset(self::$_instance))
    {
      self::$_instance = new self();
    }

    return self::$_instance;
  }

  /**
   * Check if the logged user liked this page
   *
   * @throws Exception
   * @return boolean
   */
  public function checkIfPageLiked()
  {
    $signedRequest = $this->getSignedRequest();

    if (!isset($signedRequest['page']))
    {
//       throw new Exception('Page information not found. You may be not in any page.', 500);
    }

    return isset($signedRequest['page']['liked']) ? $signedRequest['page']['liked'] : false;
  }

  /**
   * Prepare params for "get fb user profile" request
   * @return string
   */
  public function getUserProfile()
  {
    return '/me';
  }

  /**
   * Prepare params for "check if user already liked a fan page" request
   * @param string $pageId
   * @return string
   */
  public function checkIfUserLikedPage($pageId = NULL)
  {
    return '/me/likes/' . (!empty($pageId) ? $pageId : $this->getPageId());
  }

  /**
   * Prepare params for "get fb user profile" request
   * @return string
   */
  public function getAppData()
  {
    $signedRequest = $this->getSignedRequest();

    if (!isset($signedRequest['page']))
    {
      throw new Exception('Page information not found. You may be not in any page.', 500);
    }

    return isset($signedRequest['app_data']) ? $signedRequest['app_data'] : false;
  }

  /**
   * delete app request
   * @return string
   */
  public function delAppRequest($request_ids)
  {
    $user_id = $this->getUser();
    //for each request_id, build the full_request_id and delete request
    foreach ($request_ids as $request_id)
    {
      echo ("request_id=".$request_id."<br>");
      $full_request_id = $request_id . '_' . $user_id;
      echo ("full_request_id=".$full_request_id."<br>");

      try {
         $delete_success = $this->api("/$full_request_id",'DELETE');
         /*if ($delete_success) {
            echo "Successfully deleted " . $full_request_id;}
         else {
           echo "Delete failed".$full_request_id;}*/
        }
      catch (FacebookApiException $e) {
      /*echo "error";*/}
    }
  }

  /**
   * Execute the Facebook api call
   *
   * @param first param is the method name
   * @param second param is the way to throw an Exception: throw or not throw
   * @param all remaining params is for the called method
   * @throws Exception
   */
  public static function execute($serviceName, $throwException = false, $params = array())
  {
    try
    {
      $instance = self::getInstance();

      if (!method_exists($instance, $serviceName))
      {
        throw new Exception('service.undefined', 501); //Not Implemented
      }

      return $instance->api($instance->$serviceName($params));
    }
    catch ( Exception $e )
    {
      sfContext::getInstance()->getLogger()->err(get_class($e) . ': ' . $e->getCode() . ' - ' . $e->getMessage());

      if ($throwException)
      {
        throw $e;
      }

      return false;
    }
  }
}
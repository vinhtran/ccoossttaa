<?php

/**
 * Base actions for the sfFacebookSDKPlugin facebookBase module.
 * 
 * @package     sfFacebookSDKPlugin
 * @subpackage  facebookBase
 * @author      Thang Pham <thang.pham@vn.pyramid-consulting.com>
 * @version     SVN: $Id: BaseActions.class.php 12534 2008-11-01 13:38:27Z Kris.Wallsmith $
 */
abstract class BasefacebookBaseActions extends sfActions
{
  /**
   * Facebook channel file
   * 
   * @param sfWebRequest $request
   */
  public function executeChannelFile(sfWebRequest $request)
  {
    $cache_expire = 60 * 60 * 24 * 365;
    header("Pragma: public");
    header("Cache-Control: maxage=" . $cache_expire);
    header('Expires: ' . gmdate('D, d M Y H:i:s', time() + $cache_expire) . ' GMT');
    
    $this->setLayout(false);
  }
}

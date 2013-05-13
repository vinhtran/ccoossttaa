<?php
/**
 * 
 * @author Thang Pham <thang.pham@vn.pyramid-consulting.com>
 *
 */
class facebookBaseComponents extends sfComponents
{
  /**
   * Render Facebook initialize script
   * 
   * @param sfWebRequest $request
   */
  public function executeInitScript(sfWebRequest $request) 
  {
    $this->appId = sfFacebookSDKWrapper::getInstance()->getAppId();
    $this->channelFileUrl = $request->getHost()
      .$this->getContext()->getController()->genUrl('facebookBase/channelFile', false);
  }
}
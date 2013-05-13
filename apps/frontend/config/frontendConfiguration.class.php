<?php

class frontendConfiguration extends sfApplicationConfiguration
{
  public function configure()
  {
  	$this->setupAssets($this->getApplication(), $this->getEnvironment());
  }
  /**
   * (non-PHPdoc)
   * @see ProjectConfiguration::setup()
   */
  public function setup()
  {
    parent::setup();
  	$this->enablePlugins('sfFacebookSDKPlugin');
  }
  
  /**
   * Customize directories where template files are stored for a given module.
   * 
   * @author thang.pham
   * @param string $moduleName The module name
   * @return array An array of directories
   */
  public function getTemplateDirs($moduleName)
  {
  	$dirs = parent::getTemplateDirs($moduleName);
  	$appModuleTemplateDir = sfConfig::get('sf_app_module_dir').'/'.$moduleName.'/templates';
  
  	$dirs[] = $appModuleTemplateDir.'/partial';
  	$dirs[] = $appModuleTemplateDir.'/js';
  	
  	return $dirs;
  }
}

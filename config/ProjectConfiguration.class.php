<?php
/**
 * @author thang.pham
 */
require_once dirname(__FILE__).'/../lib/vendor/symfony/lib/autoload/sfCoreAutoload.class.php';
sfCoreAutoload::register();

class ProjectConfiguration extends sfProjectConfiguration
{
	/**
	 * (non-PHPdoc)
	 * @see sfProjectConfiguration::setup()
	 */
  public function setup()
  {
    $this->enablePlugins('sfDoctrinePlugin');
    ini_set('session.save_path', dirname(__FILE__).'/../tmp/');
    //var_dump(ini_get('session.save_path'));
  }
  
  /**
   * Config
   * @param string $app
   * @param string $evn
   */
  public function setupAssets($app, $evn)
  {
  	$folders = array('xml', 'swf', 'js', 'css', 'images');
  	$minFolder = $evn != 'dev' ? /* 'min' */'' : '';
  	
  	$assets = array();
  	foreach ($folders as $folder) {
  		$assets['sf_web_'.$folder.'_dir_name'] = $app.'/'.$folder.$minFolder;
  	}
  
  	sfConfig::add($assets);
  }
}

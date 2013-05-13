<?php
/**
 * 
 * Custom sfPatternRouting for Facebook App page URL
 * @author Thang Pham <thang.pham@vn.pyramid-consulting.com>
 *
 */
class sfFacebookPatternRouting extends sfPatternRouting
{
	/**
   * @see sfRouting
   */
  public function generate($name, $params = array(), $absolute = false)
  {
    if (isset($params['link_type']) && $params['link_type'] == sfFacebookSDKWrapper::LINK_TYPE) {
      unset($params['link_type']);
      return $this->generateFbAppPage($name, $params, $absolute);
    }
    
    return parent::generate($name, $params, $absolute);
  }
  
  /**
   * Generate Facebook App URL
   * 
   * @param string $name
   * @param array $params
   * @param boolean $absolute
   * @throws sfConfigurationException
   */
  public function generateFbAppPage($name, $params = array(), $absolute = false)
  {
    if (null !== $this->cache)
    {
      $cacheKey = 'generate_'.$name.'_'.md5(serialize(array_merge($this->defaultParameters, $params))).'_'.md5(serialize($this->options['context']));
      if ($this->options['lookup_cache_dedicated_keys'] && $url = $this->cache->get('symfony.routing.data.'.$cacheKey))
      {
        return $this->fixGeneratedFbAppUrl($url, $absolute);
      }
      elseif (isset($this->cacheData[$cacheKey]))
      {
        return $this->fixGeneratedFbAppUrl($this->cacheData[$cacheKey], $absolute);
      }
    }
    
    if ($name)
    {
      // named route
      if (!isset($this->routes[$name]))
      {
        throw new sfConfigurationException(sprintf('The route "%s" does not exist.', $name));
      }
      $route = $this->routes[$name];
      $this->ensureDefaultParametersAreSet();
    }
    else
    {
      // find a matching route
      if (false === $route = $this->getRouteThatMatchesParameters($params))
      {
        throw new sfConfigurationException(sprintf('Unable to find a matching route to generate url for params "%s".', is_object($params) ? 'Object('.get_class($params).')' : str_replace("\n", '', var_export($params, true))));
      }
    }

    $url = $route->generate($params, $this->options['context']);
    
    // store in cache
    if (null !== $this->cache)
    {
      if ($this->options['lookup_cache_dedicated_keys'])
      {
        $this->cache->set('symfony.routing.data.'.$cacheKey, $url);
      }
      else
      {
        $this->cacheChanged = true;
        $this->cacheData[$cacheKey] = $url;
      }
    }
    
    return $this->fixGeneratedFbAppUrl($url, $absolute);
  }
  
  /**
   * 
   * Generate full Facebook App page URL
   * @param string $url
   * @param boolean $absolute
   */
  protected function fixGeneratedFbAppUrl($url, $absolute = false)
  {
    return $absolute ? sfFacebookSDKWrapper::getInstance()->getAppLink().$url : $url;
  }
}
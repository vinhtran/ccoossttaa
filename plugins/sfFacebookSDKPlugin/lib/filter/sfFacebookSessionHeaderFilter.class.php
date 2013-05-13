<?php
class sfFacebookSessionHeaderFilter extends sfFilter
{
  public function execute($filterChain)
  {
    header('P3P:CP="IDC DSP COR ADM DEVi TAIi PSA PSD IVAi IVDi CONi HIS OUR IND CNT"');
    
    $filterChain->execute();
  }
}
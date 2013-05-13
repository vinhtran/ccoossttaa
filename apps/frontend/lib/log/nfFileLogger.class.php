<?php
/**
 * nfFileLogger custom the sfFileLogger
 *
 * @author     Thang Pham <thang.pham@vn.pyramid-consulting.com>
 */
class nfFileLogger extends sfFileLogger
{
  /**
   * (non-PHPdoc)
   * @see sfFileLogger::initialize()
   */
  public function initialize(sfEventDispatcher $dispatcher, $options = array())
  {
    $options['file'] = sfConfig::get('sf_log_dir').DIRECTORY_SEPARATOR
      .sfConfig::get('sf_app').DIRECTORY_SEPARATOR
      .sfConfig::get('sf_environment').DIRECTORY_SEPARATOR
      .date('Y').DIRECTORY_SEPARATOR
      .date('m').DIRECTORY_SEPARATOR
      .date('d').DIRECTORY_SEPARATOR
      .date('H').'.log';

    return parent::initialize($dispatcher, $options);
  }
}

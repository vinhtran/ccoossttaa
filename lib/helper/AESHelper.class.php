<?php
class AESHelper{
	private static $instance = null;
	private $a256Key = null;
	private $initializationVector = null;

	public function __construct($a256Key='', $initializationVector='') {
		if($a256Key == ''){
			$this->a256Key = sfConfig::get('app_aes_metaA256Key');
		}
		if($initializationVector == ''){
			$this->initializationVector = sfConfig::get('app_aes_metaInitializationVector');
		}
		
		$this->aes = new AES($this->a256Key, "CBC", $this->initializationVector);
	}

	/**
	 * @return AES
	 */
	public function getAES()
	{
	  return $this->aes;
	}
	static public function getInstance() {
		if (! self::$instance) {
			self::$instance = new AESHelper();
		}
		return self::$instance;
	}

	static function safeB64encode($string) {
		$data = base64_encode($string);
		$data = str_replace(array('+','/','='),array('-','_',''),$data);
		return $data;
	}

	static function safeB64decode($string) {
		$data = str_replace(array('-','_'),array('+','/'),$string);
		$mod4 = strlen($data) % 4;
		if ($mod4) {
			$data .= substr('====', $mod4);
		}
		return base64_decode($data);
	}

	public function encrypt($data=''){
    return self::safeB64encode($this->aes->encrypt($data));
	}

	public function decrypt($data=''){
    return $this->aes->decrypt(self::safeB64decode($data));
	}
}
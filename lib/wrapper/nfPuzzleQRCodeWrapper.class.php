<?php
require_once dirname(__FILE__)."/../sdk/phpqrcode/qrlib.php";

class nfPuzzleQRCodeWrapper
{
  const PUZZLE_GAME_NAMESPACE = 'puzzle/game/namespace';
  
  const PUZZLE_END_NAMESPACE = 'puzzle/end/namespace';
  
  private $level;

  private $size;

  private $margin;

  private $cache_dir;

  private $piece_width;

  private $piece_height;

  /**
   * nfQRCodeWrapper instance
   * @var nfQRCodeWrapper
   */
  protected static $_instance;

  /**
   * Get instance
   * @return nfPuzzleQRCodeWrapper
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
   * Constructor
   */
  public function __construct()
  {
    $this->level = sfConfig::get('app_qrCode_level');
    $this->size = sfConfig::get('app_qrCode_size');
    $this->margin = sfConfig::get('app_qrCode_margin');
    $this->piece_width = sfConfig::get('app_puzzleGame_pieceWidth');
    $this->piece_height = sfConfig::get('app_puzzleGame_pieceHeight');

/*     $this->cache_dir = sfConfig::get('sf_cache_dir').DIRECTORY_SEPARATOR.
      sfContext::getInstance()->getConfiguration()->getApplication().DIRECTORY_SEPARATOR.
      sfConfig::get('sf_environment').DIRECTORY_SEPARATOR.'qrcode';
 */
    $this->cache_dir = sfConfig::get('sf_web_dir').DIRECTORY_SEPARATOR.
        sfContext::getInstance()->getConfiguration()->getApplication().DIRECTORY_SEPARATOR.
        'qrcode';
    
    if (!file_exists($this->cache_dir))
    {
    	mkdir($this->cache_dir);
    }
  }

  /**
   * magic methods, it works for any call which has call name starting with 'get'
   *
   * @param string $method
   * @param mixed $arguments
   *
   * @return mixed
   */
  public function __call($method, $arguments)
  {
    if (substr($method, 0, 3) == 'get')
    {
      $attrName = sfInflector::underscore(substr($method, 3));
      return $this->$attrName;
    }
  }

  /**
   * create 9 pieces of QR code
   *
   * @param string $stringCode
   * @param datetime $date
   * @param string $userFolder
   * @return boolean
   */
  public static function createPuzzleForUser($code, $date, $userFolder)
  {
    if (empty($code))
    {
      return false;
    }
	
    //create QR code image
  	$ins = self::getInstance();
	$old = umask(0);
  	$fileDir = $ins->getCacheDir().DIRECTORY_SEPARATOR.$date;
  	!file_exists($fileDir) && mkdir($fileDir);

  	$fileName = $fileDir.DIRECTORY_SEPARATOR.$userFolder.'.png';
//  	var_dump($fileName);die;
  	QRcode::png($code, $fileName, $ins->getLevel(), $ins->getSize(), $ins->getMargin());

  	App_GDLibs::image_gd_resize_fixed_width($fileName, $fileName, sfConfig::get('app_puzzleGame_pieceWidth') * 3, sfConfig::get('app_puzzleGame_pieceHeight') * 3);
  	
  	//create 9 pieces for that QR code image
    $imageSrc = imagecreatefrompng($fileName);

    $pieceTodayDir = sfConfig::get('sf_web_dir').DIRECTORY_SEPARATOR.
        sfContext::getInstance()->getConfiguration()->getApplication().DIRECTORY_SEPARATOR.
        'qrcode'.DIRECTORY_SEPARATOR.
        $date;

    $pieceUserDir = $pieceTodayDir.DIRECTORY_SEPARATOR.$userFolder;

    !file_exists($pieceTodayDir) &&	mkdir($pieceTodayDir);
    !file_exists($pieceUserDir) && mkdir($pieceUserDir);

    $pieceWidth = $ins->getPieceWidth();
    $pieceHeight = $ins->getPieceHeight();

    $piecesName = sfConfig::get('app_puzzleGame_piecesName');
    $p = 0;
    for ($x = 0; $x < 3; $x++)
    {
    	for ($y = 0; $y < 3; $y++)
    	{
    		$pieceSrc = imagecreate($pieceWidth, $pieceHeight);
    		//print_r($pieceSrc);
    		imagecopy($pieceSrc, $imageSrc, 0, 0, $y * $pieceWidth, $x * $pieceHeight, $pieceWidth, $pieceHeight);

//     		$piece = $pieceUserDir.DIRECTORY_SEPARATOR.($x+1).'_'.($y+1).'.png';
    		$piece = $pieceUserDir.DIRECTORY_SEPARATOR.$piecesName[$x][$y].'.png';
    		imagepng($pieceSrc, $piece);
    		//chmod($pieceSrc, 0755);
    		
    		$p++;
      }
    }
	chmod($fileDir, 0755);
	umask($old);
    return true;
  }
  
	/**
   * 
   * Random blocks 
   * @return ArrayObject
   */
  public static function randomBlocks($size = 3)
  {
    $puzzle = sfConfig::get('app_puzzleGame_piecesName');
    
    $minMoves = sfConfig::get('app_puzzleGame_minMoves');
    $moves = $minMoves + rand(0, 10);
    
    $steps = array();
    
    $i = 0;
    do
    {
      $position1stX = rand(0, $size - 1);
      $position2ndX = rand(0, $size - 1);
      $position1stY = rand(0, $size - 1);
      $position2ndY = rand(0, $size - 1);
      
      if ($position1stX == $position2ndX && $position1stY == $position2ndY)
      {
        continue;
      }
      
      $steps[] = $puzzle[$position1stX][$position1stY].'_'.$puzzle[$position2ndX][$position2ndY];
      
      $tmp = $puzzle[$position1stX][$position1stY];
      $puzzle[$position1stX][$position1stY] = $puzzle[$position2ndX][$position2ndY];
      $puzzle[$position2ndX][$position2ndY] = $tmp;
      
      $i++;
    } while ($i < $moves);
    
    return array('puzzle' => $puzzle, 'steps' => $steps);
  }
  
	/**
   * 
   * Enter description here ...
   * @param unknown_type $puzzle
   * @param unknown_type $steps
   * @param unknown_type $reverse
   */
  /*public static function doSwapBlocks($puzzle, $steps, $reverse = FALSE)
  {
    $puzzleStr = self::puzzleToString(sfConfig::get('app_puzzleGame_piecesName'));
    
    $i = 0;
    foreach ($steps as $step)
    {
      if (strpos($step, '_') === FALSE) 
      {
        throw new Exception('Wrong step.', 500);
      }
      
      $position = explode('_', $step);
      
      if ($reverse)
      {
        $position1st = $position[1];
        $position2nd = $position[0];
      } 
      else 
      {
        $position1st = $position[0];
        $position2nd = $position[1];
      }
      
      if (strpos($puzzleStr, $position1st) === FALSE 
          || strpos($puzzleStr, $position2nd) === FALSE)
      {
        throw new Exception('Wrong step.', 500);
      }
      
      if ($position1st == $position2nd)
      {
        throw new Exception('Wrong step.', 500);
      }
      
      $tmp = $puzzle[$position1st];
      $puzzle[$position1st] = $puzzle[$position2nd];
      $puzzle[$position2nd] = $tmp;
      
      $i++;
    }
    
    return array('puzzle' => $puzzle, 'number_of_move' => $i);
  }*/
  
  
  /**
   * Random to create puzzle
   *
   */
  /*public static function randomPuzzle()
  {
    
    $puzzle = array(array('A', 'B', 'C'), array('D', 'E', 'F'), array('G', 'H', 'I'));
    
    $directions = sfConfig::get('app_puzzleGame_directions');
    $minMoves = sfConfig::get('app_puzzleGame_minMoves');

    $moves = $minMoves + rand(0, 10);

    $steps = '';
    $currPosition = array('x' => 2, 'y' => 2);
    for ($i = 0; $i < $moves; $i++)
    {
      do
      {
        $direction = $directions[rand(0, 3)];
        $newPosition = self::_getPositionAfterMove($currPosition, $direction);
      } while ($newPosition === FALSE);

      $tmp = $puzzle[$currPosition['y']][$currPosition['x']];
      $puzzle[$currPosition['y']][$currPosition['x']] = $puzzle[$newPosition['y']][$newPosition['x']];
      $puzzle[$newPosition['y']][$newPosition['x']] = $tmp;

      $steps .= $direction;
      $currPosition = $newPosition;
    }

    return array('puzzle' => $puzzle, 'steps' => $steps, 'current_position' => $currPosition);
  }*/
  
  /**
   * 
   * Enter description here ...
   * @param unknown_type $puzzle
   * @param unknown_type $steps
   * @param unknown_type $currPosition
   */
  /*public static function moveTo9thPosition($puzzle, $steps, $currPosition)
  {
    $backTo9thPosition = sfConfig::get('app_puzzleGame_goBackTo9thPosition');
    $pos = $currPosition['y'].'_'.$currPosition['x'];

    $goBackSteps = !isset($backTo9thPosition[$pos]) ? '' : $backTo9thPosition[$pos];
//     var_dump($goBackSteps);
//     print_r($currPosition);
    return array_merge(self::doMove($puzzle, $goBackSteps, $currPosition), array('steps' => $steps.$goBackSteps));
  }*/

  /**
   * 
   * Enter description here ...
   * @param unknown_type $position
   * @param unknown_type $direction
   */
  /*public static function _getPositionAfterMove($position, $direction)
  {
    $newPosition = $position;

    switch ($direction)
    {
    	case 'T':
    	  $newPosition['y'] = $newPosition['y'] - 1;
    		if ($newPosition['y'] >= 0 && $newPosition['y'] <= 2)
    		{
    			return $newPosition;
    		}
    		break;
    	case 'R':
    	  $newPosition['x'] = $newPosition['x'] + 1;
    		if ($newPosition['x'] >= 0 && $newPosition['x'] <= 2)
    		{
    			return $newPosition;
    		}
    		break;
    	case 'B':
    	  $newPosition['y'] = $newPosition['y'] + 1;
    		if ($newPosition['y'] >= 0 && $newPosition['y'] <= 2)
    		{
    			return $newPosition;
    		}
    		break;
    	case 'L':
    	  $newPosition['x'] = $newPosition['x'] - 1;
    		if ($newPosition['x'] >= 0 && $newPosition['x'] <= 2)
    		{
    			return $newPosition;
    		}
    		break;
    }

    return FALSE;
  }*/

  /**
   * 
   * Enter description here ...
   * @param unknown_type $puzzle
   * @param unknown_type $steps
   * @param unknown_type $currPosition
   * @param unknown_type $reverse
   * @throws Exception
   */
  /*public static function doMove($puzzle, $steps, $currPosition, $reverse = FALSE)
  {
    $reverseDirections = sfConfig::get('app_puzzleGame_reverseDirections');

    while (!empty($steps))
    {
      $len = strlen($steps);
      $direction = $reverse ? $reverseDirections[substr($steps, $len-1, 1)] : substr($steps, 0, 1);

      $newPosition = self::_getPositionAfterMove($currPosition, $direction);
//      var_dump($direction);
//      var_dump($steps);  
//      var_dump($reverse);
      if ($newPosition === false)
      {
        throw new Exception('Cannot move any more.', 500);
      }
      
      $tmp = $puzzle[$currPosition['y']][$currPosition['x']];
      $puzzle[$currPosition['y']][$currPosition['x']] = $puzzle[$newPosition['y']][$newPosition['x']];
      $puzzle[$newPosition['y']][$newPosition['x']] = $tmp;

      $steps = $reverse ? substr($steps, 0, $len-1) : substr($steps, 1, $len-1);

      $currPosition = $newPosition;

    }

    return array('puzzle' => $puzzle, 'current_position' => $currPosition);
  }*/

  
  /**
   * Generate string code
   *
   * @param string $fbID
   * @param datetime $date
   * @return string
   */
  public static function generateStringCode($fbID, $date)
  {
    return md5($fbID.'_'.$date);
  }

  /**
   * 
   * Enter description here ...
   * @param unknown_type $stringCode
   */
  public static function generateURLCode($stringCode)
  {
//    $salt = sfConfig::get('sf_csrf_secret');

//    $codeStr = AESHelper::safeB64encode($stringCode);
    $codeStr = $stringCode;
    
    return sfContext::getInstance()->getController()->genUrl('@mobile_validate_code?codestr='.$codeStr/*urlencode(base64_encode($stringCode.$salt))*/, TRUE);
  }
  
  /**
   * 
   * Enter description here ...
   * @param unknown_type $puzzle
   * @param unknown_type $size
   */
  public static function puzzleToString($puzzle, $size = 3)
  {
    $puzzleStr = '';
    for ($x = 0; $x < $size; $x++)
    {
    	for ($y = 0; $y < $size; $y++)
    	{
    	  $puzzleStr .= $puzzle[$x][$y];
    	}
    }
    
    return $puzzleStr;
  }
}
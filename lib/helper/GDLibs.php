<?php
/**
 * This class is edited from file image.gd.inc of drupal framework version 6.6
 * /drupal_dir/includes/image.gd.inc
 * /drupal_dir/includes/image.inc
 * Just using some needed functions, ==> change source code at least
 *
 */

class App_GDLibs{

	/**
	 * Get details about an image.
	 *
	 * Drupal only supports GIF, JPG and PNG file formats.
	 *
	 * @return
	 *   FALSE, if the file could not be found or is not an image. Otherwise, a
	 *   keyed array containing information about the image:
	 *    'width'     - Width in pixels.
	 *    'height'    - Height in pixels.
	 *    'extension' - Commonly used file extension for the image.
	 *    'mime_type' - MIME type ('image/jpeg', 'image/gif', 'image/png').
	 *    'file_size' - File size in bytes.
	 */
	static public function image_get_info($file) {
		if (!is_file($file)) {
			return FALSE;
		}

		$details = FALSE;
		$data = @getimagesize($file);
		$file_size = @filesize($file);

		if (isset($data) && is_array($data)) {
			$extensions = array('1' => 'gif', '2' => 'jpg', '3' => 'png');
			$extension = array_key_exists($data[2], $extensions) ?  $extensions[$data[2]] : '';
			$details = array('width'     => $data[0],
                         'height'    => $data[1],
                         'extension' => $extension,
                         'file_size' => $file_size,
                         'mime_type' => $data['mime']);
		}

		return $details;
	}

	/**
	 * Scale an image to the specified size using GD.
	 */
	static public function image_gd_resize($source, $destination, $width, $height) {
		if (!file_exists($source)) {
			return FALSE;
		}

		$info = self::image_get_info($source);
		if (!$info) {
			return FALSE;
		}

		$im = self::image_gd_open($source, $info['extension']);
		if (!$im) {
			return FALSE;
		}

		/**
		 * edit code for smooth imgae
		 */
		//If image dimension is smaller, do not resize
		if ($info['width'] <= $width && $info['height'] <= $height) {
			$nWidth = $info['width'];
			$nHeight = $info['height'];
		}else{
			//yeah, resize it, but keep it proportional
			if ($width/$info['width'] < $height/$info['height']) {
				$nWidth = $width;
				$nHeight = $info['height']*($width/$info['width']);
			}else{
				$nWidth = $info['width']*($height/$info['height']);
				$nHeight = $height;
			}
		}
		$width = round($nWidth);
		$height = round($nHeight);

		$res = imagecreatetruecolor($width, $height);
		if ($info['extension'] == 'png') {
			$transparency = imagecolorallocatealpha($res, 0, 0, 0, 127);
			imagealphablending($res, FALSE);
			imagefilledrectangle($res, 0, 0, $width, $height, $transparency);
			imagealphablending($res, TRUE);
			imagesavealpha($res, TRUE);
		}
		elseif ($info['extension'] == 'gif') {
			// If we have a specific transparent color.
			$transparency_index = imagecolortransparent($im);
			if ($transparency_index >= 0) {
				// Get the original image's transparent color's RGB values.
				$transparent_color = imagecolorsforindex($im, $transparency_index);
				// Allocate the same color in the new image resource.
				$transparency_index = imagecolorallocate($res, $transparent_color['red'], $transparent_color['green'], $transparent_color['blue']);
				// Completely fill the background of the new image with allocated color.
				imagefill($res, 0, 0, $transparency_index);
				// Set the background color for new image to transparent.
				imagecolortransparent($res, $transparency_index);
				// Find number of colors in the images palette.
				$number_colors = imagecolorstotal($im);
				// Convert from true color to palette to fix transparency issues.
				imagetruecolortopalette($res, TRUE, $number_colors);
			}
		}
		imagecopyresampled($res, $im, 0, 0, 0, 0, $width, $height, $info['width'], $info['height']);
		$result = self::image_gd_close($res, $destination, $info['extension']);

		imagedestroy($res);
		imagedestroy($im);

		return $result;
	}
	
	/**
	 * Scale an image to the specified size using GD.
	 * large image:  200x100
	 * small size: 47x47  
	 * => scale 100 down to 47 and 200 auto scale down follow 100
	 */
	static public function image_gd_resize_special($source, $width=0, $height=0) {
		if (!file_exists($source)) {
			return FALSE;
		}

		$info = self::image_get_info($source);
		if (!$info) {
			return FALSE;
		}

		$im = self::image_gd_open($source, $info['extension']);
		if (!$im) {
			return FALSE;
		}
		/**
		 * edit code for smooth imgae
		 */
		//If image dimension is smaller, do not resize
		if ($info['width'] <= $width && $info['height'] <= $height) {
			$nWidth = $info['width'];
			$nHeight = $info['height'];
		}else{
			//yeah, resize it, but keep it proportional
			if ($info['width']/$width < $info['height']/$height) {
				$nWidth = $width;
				$nHeight = $info['height']*($width/$info['width']);
			}else{
				$nWidth = $info['width']*($height/$info['height']);
				$nHeight = $height;
			}
		}
		$width = round($nWidth);
		$height = round($nHeight);
		$res = imagecreatetruecolor($width, $height);
		if ($info['extension'] == 'png') {
			$transparency = imagecolorallocatealpha($res, 0, 0, 0, 127);
			imagealphablending($res, FALSE);
			imagefilledrectangle($res, 0, 0, $width, $height, $transparency);
			imagealphablending($res, TRUE);
			imagesavealpha($res, TRUE);
		}
		elseif ($info['extension'] == 'gif') {
			// If we have a specific transparent color.
			$transparency_index = imagecolortransparent($im);
			if ($transparency_index >= 0) {
				// Get the original image's transparent color's RGB values.
				$transparent_color = imagecolorsforindex($im, $transparency_index);
				// Allocate the same color in the new image resource.
				$transparency_index = imagecolorallocate($res, $transparent_color['red'], $transparent_color['green'], $transparent_color['blue']);
				// Completely fill the background of the new image with allocated color.
				imagefill($res, 0, 0, $transparency_index);
				// Set the background color for new image to transparent.
				imagecolortransparent($res, $transparency_index);
				// Find number of colors in the images palette.
				$number_colors = imagecolorstotal($im);
				// Convert from true color to palette to fix transparency issues.
				imagetruecolortopalette($res, TRUE, $number_colors);
			}
		}
		imagecopyresampled($res, $im, 0, 0, 0, 0, $width, $height, $info['width'], $info['height']);
		
		//crop image
		$tmpFileName = 'tmp_'.time().'.'.$info['extension'];
		$result = self::image_gd_close($res, TMP_DIR.DS.$tmpFileName, $info['extension']);

		imagedestroy($res);
		imagedestroy($im);

		if (!file_exists(TMP_DIR.DS.$tmpFileName)) {
			//echo 'go here';
			return FALSE;
		}
		return TMP_DIR.DS.$tmpFileName;
	}
	
	/**
	 * Rotate an image the given number of degrees.
	 */
	static public function image_gd_rotate($source, $destination, $degrees, $background = 0x000000) {
		if (!function_exists('imageRotate')) {
			return FALSE;
		}

		$info = self::image_get_info($source);
		if (!$info) {
			return FALSE;
		}

		$im = self::image_gd_open($source, $info['extension']);
		if (!$im) {
			return FALSE;
		}

		$res = imageRotate($im, $degrees, $background);
		$result = self::image_gd_close($res, $destination, $info['extension']);

		return $result;
	}

	/**
	 * Crop an image using the GD toolkit.
	 */
	static public function image_gd_crop($source, $destination, $x, $y, $width, $height) {
		$info = self::image_get_info($source);
		if (!$info) {
			return FALSE;
		}

		$im = self::image_gd_open($source, $info['extension']);
		echo $width.' '.$height;
		$res = imagecreatetruecolor($width, $height);
		imagecopy($res, $im, 0, 0, $x, $y, $width, $height);
		$result = self::image_gd_close($res, $destination, $info['extension']);

		imageDestroy($res);
		imageDestroy($im);

		return $result;
	}

	/**
	 * GD helper function to create an image resource from a file.
	 *
	 * @param $file
	 *   A string file path where the iamge should be saved.
	 * @param $extension
	 *   A string containing one of the following extensions: gif, jpg, jpeg, png.
	 * @return
	 *   An image resource, or FALSE on error.
	 */
	static public function image_gd_open($file, $extension) {
		$extension = str_replace('jpg', 'jpeg', $extension);
		$open_func = 'imageCreateFrom'. $extension;
		if (!function_exists($open_func)) {
			return FALSE;
		}
		return $open_func($file);
	}

	/**
	 * GD helper to write an image resource to a destination file.
	 *
	 * @param $res
	 *   An image resource created with image_gd_open().
	 * @param $destination
	 *   A string file path where the iamge should be saved.
	 * @param $extension
	 *   A string containing one of the following extensions: gif, jpg, jpeg, png.
	 * @return
	 *   Boolean indicating success.
	 */
	static public function image_gd_close($res, $destination, $extension) {
		$extension = str_replace('jpg', 'jpeg', $extension);
		$close_func = 'image'. $extension;
		if (!function_exists($close_func)) {
			return FALSE;
		}
		if ($extension == 'jpeg') {
			return $close_func($res, $destination, 100);
		}
		else {
			return $close_func($res, $destination);
		}
	}

	static public function image_gd_rounded($source_path="", $dest_path="", $radius = 20, $corner = array('topleft'=>true, 'bottomleft'=>true,'bottomright'=>true, 'topright'=>true), $angle=0){
		$image_file = $source_path;
		$corner_radius = $radius; // The default corner radius is set to 20px
		$angle = $angle; // The default angle is set to 0�
		$topleft = $corner['topleft']; // Top-left rounded corner is shown by default
		$bottomleft = $corner['bottomleft']; // Bottom-left rounded corner is shown by default
		$bottomright = $corner['bottomright']; // Bottom-right rounded corner is shown by default
		$topright = $corner['topright']; // Top-right rounded corner is shown by default
		//loading rounded corner image
		$corner_source = imagecreatefrompng(dirname(__FILE__).DIRECTORY_SEPARATOR.'gd_rounded_corner'.DIRECTORY_SEPARATOR.'rounded_corner_'.$radius.'px.png');

		$corner_width = imagesx($corner_source);
		$corner_height = imagesy($corner_source);
		$corner_resized = imagecreatetruecolor($corner_radius, $corner_radius);
		imagecopyresampled($corner_resized, $corner_source, 0, 0, 0, 0, $corner_radius, $corner_radius, $corner_width, $corner_height);

		$corner_width = imagesx($corner_resized);
		$corner_height = imagesy($corner_resized);
		$image = imagecreatetruecolor($corner_width, $corner_height);

		$info = self::image_get_info($image_file);
		if (!$info) {
			return FALSE;
		}
	  
		$image = self::image_gd_open($image_file, $info['extension']);
		if (!$image) {
			return FALSE;
		}
		$size = getimagesize($image_file); // replace filename with $_GET['src']
		$white = imagecolorallocate($image,255,255,255);
		$black = imagecolorallocate($image,0,0,0);

		// Top-left corner
		if ($topleft == true) {
			$dest_x = 0;
			$dest_y = 0;
			imagecolortransparent($corner_resized, $black);
			imagecopymerge($image, $corner_resized, $dest_x, $dest_y, 0, 0, $corner_width, $corner_height, 100);
		}

		// Bottom-left corner
		if ($bottomleft == true) {
			$dest_x = 0;
			$dest_y = $size[1] - $corner_height;
			$rotated = imagerotate($corner_resized, 90, 0);
			imagecolortransparent($rotated, $black);
			imagecopymerge($image, $rotated, $dest_x, $dest_y, 0, 0, $corner_width, $corner_height, 100);
		}

		// Bottom-right corner
		if ($bottomright == true) {
			$dest_x = $size[0] - $corner_width;
			$dest_y = $size[1] - $corner_height;
			$rotated = imagerotate($corner_resized, 180, 0);
			imagecolortransparent($rotated, $black);
			imagecopymerge($image, $rotated, $dest_x, $dest_y, 0, 0, $corner_width, $corner_height, 100);
		}

		// Top-right corner
		if ($topright == true) {
			$dest_x = $size[0] - $corner_width;
			$dest_y = 0;
			$rotated = imagerotate($corner_resized, 270, 0);
			imagecolortransparent($rotated, $black);
			imagecopymerge($image, $rotated, $dest_x, $dest_y, 0, 0, $corner_width, $corner_height, 100);
		}

		// Rotate image
		$image = imagerotate($image, $angle, $white);

		// Output final image
		$result = self::image_gd_close($image, $dest_path, 'png');

		imagedestroy($image);
		imagedestroy($corner_source);

		return $result;
	}
	/**
	 * Crop Image with new width height (support transparent image)
	 * @param string $pathToImages
	 * @param int $width
	 * @param int $height
	 * @return String path to new crop file
	 */
	static public function image_gd_crop_transparent_image($pathToImages, $width, $height){
		if (!file_exists($pathToImages)) {
			return FALSE;
		}

		$info = self::image_get_info($pathToImages);
		if (!$info) {
			return FALSE;
		}

		$im = self::image_gd_open($pathToImages, $info['extension']);
		if (!$im) {
			return FALSE;
		}

		//calculate to crop image
		/**
		 * edit code for smooth imgae
		 */
		//If image dimension is smaller, do not resize
		if ($info['width'] <= $width && $info['height'] <= $height) {
			$nWidth = $info['width'];
			$nHeight = $info['height'];
		}else{
			//yeah, resize it, but keep it proportional
			//Width > Height
			if ($width/$info['width'] < $height/$info['height']) {
				$nHeight = $info['height'];
				$nWidth = ($info['height']/$width)*$height;

			}else{
				//Width < Height
				$nWidth = $info['width'];
				$nHeight = ($info['width']/$height)*$width;
			}
		}
		$width = round($nWidth);
		$height = round($nHeight);
		//end calculate to crop image
		//crop image
		$tmpFileName = 'tmp_'.time().'.'.$info['extension'];

		$res = imagecreatetruecolor($width, $height);
		if ($info['extension'] == 'png') {
			$transparency = imagecolorallocatealpha($res, 0, 0, 0, 127);
			imagealphablending($res, FALSE);
			imagefilledrectangle($res, 0, 0, $width, $height, $transparency);
			imagealphablending($res, TRUE);
			imagesavealpha($res, TRUE);
		}
		elseif ($info['extension'] == 'gif') {
			// If we have a specific transparent color.
			$transparency_index = imagecolortransparent($im);
			if ($transparency_index >= 0) {
				// Get the original image's transparent color's RGB values.
				$transparent_color = imagecolorsforindex($im, $transparency_index);
				// Allocate the same color in the new image resource.
				$transparency_index = imagecolorallocate($res, $transparent_color['red'], $transparent_color['green'], $transparent_color['blue']);
				// Completely fill the background of the new image with allocated color.
				imagefill($res, 0, 0, $transparency_index);
				// Set the background color for new image to transparent.
				imagecolortransparent($res, $transparency_index);
				// Find number of colors in the images palette.
				$number_colors = imagecolorstotal($im);
				// Convert from true color to palette to fix transparency issues.
				imagetruecolortopalette($res, TRUE, $number_colors);
			}
		}
		imagecopyresampled($res, $im, 0, 0, 0, 0, $width, $height, $info['width'], $info['height']);
		$result = self::image_gd_close($res, TMP_DIR.DS.$tmpFileName, $info['extension']);
		imagedestroy($res);
		imagedestroy($im);
		if (!file_exists(TMP_DIR.DS.$tmpFileName)) {
			//echo 'go here';
			return FALSE;
		}
		return TMP_DIR.DS.$tmpFileName;
	}
	static public function crop_image($old_image,$new_image,$width,$height,$type="")
	{
		$dimensions = getimagesize($old_image);
		$old_x=$dimensions[0];
		$old_y=$dimensions[1];
		 
		if ($old_x < $width)
		{
			$width=$old_x;
		}
		if ($old_y < $height)
		{
			$height=$old_y;
		}
		$canvas = imagecreatetruecolor($width,$height);
		$system= substr(strrchr($old_image, "."), 1 );
		if (preg_match('/png/',$system))
		{
			$piece = imagecreatefrompng($old_image);
		}
		else if (preg_match('/gif/',$system))
		{
			$piece = imagecreatefromgif($old_image);
		}
		else $piece = imagecreatefromjpeg($old_image);

		$newwidth = $dimensions[0] ;/// 2;
		$newheight = $dimensions[1];// / 2;
		if ($newwidth>$width)
		{
			$cropLeft = ($newwidth/2) - ($width/2);
			$newwidth=$width;
		}
		else     $cropLeft = 0;
		if ($newheight > $height)
		{
			$cropHeight = ($newheight/2) - ($height/2);
			$newheight=$height;
		}
		else     $cropHeight = 0;//($newheight);

		if($system=="gif" || $system=="png")
		{
			$transparent = imagecolorallocate($canvas, "255", "255", "255");
			imagefill($canvas, 0, 0, $transparent);
		}
		//$cropLeft = $cropHeight = 0;
		// Generate the cropped image
		@imagecopyresized($canvas, $piece, 0,0, $cropLeft, $cropHeight,$newwidth, $newheight, $width, $height);
		
		if (preg_match('/png/',$system))
		{
			imagepng($canvas,$new_image);
		}
		else if (preg_match('/gif/',$system))
		{
			imagegif($canvas,$new_image,90);
		}
		else imagejpeg($canvas,$new_image,90);
		@imagedestroy($canvas);
		@imagedestroy($piece);
		 
	}
	
	/**
	 * Scale an image to the specified size in fixed-width using GD.
	 */
	static public function image_gd_resize_fixed_width($source, $destination, $width, $height) {
		if (!file_exists($source)) {
			return FALSE;
		}

		$info = self::image_get_info($source);
		if (!$info) {
			return FALSE;
		}

		$im = self::image_gd_open($source, $info['extension']);
		if (!$im) {
			return FALSE;
		}

		/**
		 * edit code for smooth imgae
		 */
		//If image dimension is smaller, do not resize
		$nWidth = $width;
		$nHeight = $info['height']*($width/$info['width']);		
		
		$width = round($nWidth);
		$height = round($nHeight);

		$res = imagecreatetruecolor($width, $height);
		if ($info['extension'] == 'png') {
			$transparency = imagecolorallocatealpha($res, 0, 0, 0, 127);
			imagealphablending($res, FALSE);
			imagefilledrectangle($res, 0, 0, $width, $height, $transparency);
			imagealphablending($res, TRUE);
			imagesavealpha($res, TRUE);
		}
		elseif ($info['extension'] == 'gif') {
			// If we have a specific transparent color.
			$transparency_index = imagecolortransparent($im);
			if ($transparency_index >= 0) {
				// Get the original image's transparent color's RGB values.
				$transparent_color = imagecolorsforindex($im, $transparency_index);
				// Allocate the same color in the new image resource.
				$transparency_index = imagecolorallocate($res, $transparent_color['red'], $transparent_color['green'], $transparent_color['blue']);
				// Completely fill the background of the new image with allocated color.
				imagefill($res, 0, 0, $transparency_index);
				// Set the background color for new image to transparent.
				imagecolortransparent($res, $transparency_index);
				// Find number of colors in the images palette.
				$number_colors = imagecolorstotal($im);
				// Convert from true color to palette to fix transparency issues.
				imagetruecolortopalette($res, TRUE, $number_colors);
			}
		}
		imagecopyresampled($res, $im, 0, 0, 0, 0, $width, $height, $info['width'], $info['height']);
		$result = self::image_gd_close($res, $destination, $info['extension']);

		imagedestroy($res);
		imagedestroy($im);

		return $result;
	}
}
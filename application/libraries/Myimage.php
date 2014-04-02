<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 4.3.2 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2010, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.3.1
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * HTML Table Generating Class
 *
 * Lets you create tables manually or from database result objects, or arrays.
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	HTML Tables
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/libraries/uri.html
 */
 
 
 
class Myimage {	   
	   var $image;
	   var $image_type;
	 
	   function load($filename) {
	      $image_info = getimagesize($filename);
	      $this->image_type = $image_info[2];
	      if( $this->image_type == IMAGETYPE_JPEG ) {
	         $this->image = imagecreatefromjpeg($filename);
	      } elseif( $this->image_type == IMAGETYPE_GIF ) {
	         $this->image = imagecreatefromgif($filename);
	      } elseif( $this->image_type == IMAGETYPE_PNG ) {
	         $this->image = imagecreatefrompng($filename);
	      }
	   }
	   function save($filename, $image_type=IMAGETYPE_JPEG, $compression=90, $permissions=null) {
	      if( $image_type == IMAGETYPE_JPEG ) {
	         imagejpeg($this->image,$filename,$compression);
	      } elseif( $image_type == IMAGETYPE_GIF ) {
	         imagegif($this->image,$filename);         
	      } elseif( $image_type == IMAGETYPE_PNG ) {
	         imagepng($this->image,$filename);
	      }   
	      if( $permissions != null) {
	         chmod($filename,$permissions);
	      }
	   }
	   	function output($image_type=IMAGETYPE_JPEG) {
	    	if( $image_type == IMAGETYPE_JPEG ) {
	        	imagejpeg($this->image);
	      	} elseif( $image_type == IMAGETYPE_GIF ) {
	        	imagegif($this->image);         
	      	} elseif( $image_type == IMAGETYPE_PNG ) {
	        	imagepng($this->image);
	      	}
	   }
	   	function getWidth() {
	    	return imagesx($this->image);
	   	}
		function getHeight() {
			return imagesy($this->image);
		}
		function resizeToHeight($height) {
			if($this->getHeight() > $height)
			{
				$ratio = $height / $this->getHeight();
				$width = $this->getWidth() * $ratio;
				$this->resize($width,$height);
			}
			else
			{
				$this->resize($this->getWidth(),$this->getHeight());
			}
		}
		function resizeToWidth($width) 
		{
			if($this->getWidth() > $width)
			{
				$ratio = $width / $this->getWidth();
				$height = $this->getheight() * $ratio;
				$this->resize($width,$height);
			}
			else
			{
				$this->resize($this->getWidth(),$this->getHeight());
			}
			
		}
	   function scale($scale) {
	      $width = $this->getWidth() * $scale/100;
	      $height = $this->getheight() * $scale/100; 
	      $this->resize($width,$height);
	   }
	   function resize($width,$height) {
	      $new_image = imagecreatetruecolor($width, $height);
	      imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
	      $this->image = $new_image;   
	   }
	   
	   
	   	function resizeFromWidthAndHeight($imgSourcePath, $width, $height, $newImagePath, $jpgQuality = 80)
	   	{
			/*
	   		$wratio = $this->getWidth() / $width;
			$hratio = $this->getHeight() / $height;
			
			if($hratio > $wratio)
			{
				if($this->getHeight() > $height)
				{
					$ratio = $height / $this->getHeight();
					$width = $this->getWidth() * $ratio;
					$this->resize($width,$height);
				}
				else
				{
					$this->resize($this->getWidth(),$this->getHeight());
				}
			}
			else
			{
				if($this->getWidth() > $width)
				{
					$ratio = $width / $this->getWidth();
					$height = $this->getheight() * $ratio;
					$this->resize($width,$height);
				}
				else
				{
					$this->resize($this->getWidth(),$this->getHeight());
				}
			}
			*/
			//Get Image size info
		 	$imgInfo = getimagesize($imgSourcePath);
			switch ($imgInfo[2]) {
				case 1: $im = imagecreatefromgif($imgSourcePath); break;
				case 2: $im = imagecreatefromjpeg($imgSourcePath);  break;
				case 3: $im = imagecreatefrompng($imgSourcePath); break;
				default:  return false;
		 	}
			//If image dimension is smaller, do not resize
			$nHeight = 0;
			$nWidth = 0;
			if ($imgInfo[0] <= $width && $imgInfo[1] <= $height) 
			{
				$nHeight = $imgInfo[1];
				$nWidth = $imgInfo[0];
			}
			else
			{
				$xscale=$imgInfo[0]/$width;
				$yscale=$imgInfo[1]/$height;
				
				// Recalculate new size with default ratio
				if ($yscale>$xscale){
				    $nWidth = $imgInfo[0] * (1/$yscale);
				    $nHeight = $imgInfo[1] * (1/$yscale);
				}
				else {
				    $nWidth = $imgInfo[0] * (1/$xscale);
				    $nHeight = $imgInfo[1] * (1/$xscale);
				}
			}
			
			$newImg = imagecreatetruecolor($nWidth, $nHeight);
			/* Check if this image is PNG or GIF, then set if Transparent*/  
			if(($imgInfo[2] == 1) OR ($imgInfo[2]==3))
			{
				$trnprt_indx = imagecolortransparent($im);
   
				// If we have a specific transparent color
				if ($trnprt_indx >= 0) 
				{
					// Get the original image's transparent color's RGB values
					$trnprt_color    = imagecolorsforindex($im, $trnprt_indx);
					// Allocate the same color in the new image resource
					$trnprt_indx    = imagecolorallocate($newImg, $trnprt_color['red'], $trnprt_color['green'], $trnprt_color['blue']);
					// Completely fill the background of the new image with allocated color.
					imagefill($newImg, 0, 0, $trnprt_indx);
					// Set the background color for new image to transparent
					imagecolortransparent($newImg, $trnprt_indx);
				}
				// Always make a transparent background color for PNGs that don't have one allocated already
				elseif ($imgInfo[2] == IMAGETYPE_PNG)
				{
					// Turn off transparency blending (temporarily)
					imagealphablending($newImg, false);
					// Create a new transparent color for image
					$color = imagecolorallocatealpha($newImg, 0, 0, 0, 127);
					// Completely fill the background of the new image with allocated color.
					imagefill($newImg, 0, 0, $color);
					// Restore transparency blending
					imagesavealpha($newImg, true);
				}
				/* Check if this image is PNG , then set if Transparent*/
				/*
				if($imgInfo[2] == 3){
					imagealphablending($newImg, false);
					imagesavealpha($newImg,true);
					$transparent = imagecolorallocatealpha($newImg, 255, 255, 255, 127);
					imagefilledrectangle($newImg, 0, 0, $nWidth, $nHeight, $transparent);
				}*/
				/* Check if this image is GIF , then DONT transparent */
				/*
				if($imgInfo[2] == 1){
					imagealphablending($newImg, true);
					imagesavealpha($newImg,false);
					$transparent = imagecolorallocatealpha($newImg, 255, 255, 255, 127);
					imagefilledrectangle($newImg, 0, 0, $nWidth, $nHeight, $transparent);
				}*/
				//imagealphablending($newImg, false);
				//imagesavealpha($newImg,true);
				//$transparent = imagecolorallocatealpha($newImg, 255, 255, 255, 127);
				//imagefilledrectangle($newImg, 0, 0, $nWidth, $nHeight, $transparent);
			}
			imagecopyresampled($newImg, $im, 0, 0, 0, 0, $nWidth, $nHeight, $imgInfo[0], $imgInfo[1]);
			//Generate the file, and rename it to $newfilename
			
			switch ($imgInfo[2]) 
			{
				case 1: imagegif($newImg,$newImagePath); break;
				case 2: imagejpeg($newImg,$newImagePath, $jpgQuality);  break;
				case 3: imagepng($newImg,$newImagePath); break;
				default:  return false;
			}
			imagedestroy($im);
			imagedestroy($newImg);
			return true;
		}
	   
		function reSizeAndCrop($imgSourcePath, $width, $height, $newImagePath, $jpgQuality = 80)
		{
			//Get Image size info
		 	$imgInfo = getimagesize($imgSourcePath);
			switch ($imgInfo[2]) {
				case 1: $im = imagecreatefromgif($imgSourcePath); break;
				case 2: $im = imagecreatefromjpeg($imgSourcePath);  break;
				case 3: $im = imagecreatefrompng($imgSourcePath); break;
				default:  return false;
		 	}
			//If image dimension is smaller, do not resize
			$nHeight = 0;
			$nWidth = 0;
			$top = 0;
			$left = 0;
			$cropW = 0;
			$cropH = 0;
			if ($imgInfo[0] <= $width && $imgInfo[1] <= $height) 
			{
				if($imgInfo[0] < $imgInfo[1])
				{
					$nWidth = $width;
					$nHeight = ($nWidth * $imgInfo[1]) / $imgInfo[0];
				}
				else
				{
					$nHeight = $height;
					$nWidth = ($nHeight * $imgInfo[0]) / $imgInfo[1];
				}
				
			}
			else if($imgInfo[0] <= $width || $imgInfo[1] <= $height)
			{
				if($imgInfo[0] <= $width)
				{
					$nWidth = $width;
					$nHeight = ($nWidth * $imgInfo[1]) / $imgInfo[0];
				}
				else if ($imgInfo[1] <= $height)
				{
					$nHeight = $height;
					$nWidth = ($nHeight * $imgInfo[0]) / $imgInfo[1];
				}
			}
			else
			{
				$xscale=$imgInfo[0]/$width;
				$yscale=$imgInfo[1]/$height;
				
				// Recalculate new size with default ratio
				if ($yscale>$xscale)
				{
				   	$nWidth = $width;
				   	$nHeight = ($nWidth * $imgInfo[1]) / $imgInfo[0];
				}
				else 
				{
				    $nHeight = $height;
				    $nWidth = ($nHeight * $imgInfo[0]) / $imgInfo[1];
				}
				
			}
			
			$newImg = imagecreatetruecolor($nWidth, $nHeight);
			
			/* Check if this image is PNG or GIF, then set if Transparent*/  
			if(($imgInfo[2] == 1) OR ($imgInfo[2]==3))
			{
				//$trnprt_indx = imagecolortransparent($im);
   				imagealphablending($newImg, false);
   				imagesavealpha($newImg,true);
   				$transparent = imagecolorallocatealpha($newImg, 255, 255, 255, 127);
   				imagefilledrectangle($newImg, 0, 0, $nWidth, $nHeight, $transparent);
			}
			
			imagecopyresampled ($newImg, $im, 0, 0, 0, 0, $nWidth, $nHeight, $imgInfo[0], $imgInfo[1]);
			
			$cropW = ($nWidth >= $width) ? $width : $nWidth;
			$cropH = ($nHeight >= $height) ? $height : $nHeight;
			$top = ceil(($nHeight - $cropH) / 2);
			$left = ceil(($nWidth - $cropW) /2);
			
			$cropImage = imagecreatetruecolor($cropW, $cropH);
			if(($imgInfo[2] == 1) OR ($imgInfo[2]==3))
			{
				imagealphablending($cropImage, false);
   				imagesavealpha($cropImage,true);
   				$transparent = imagecolorallocatealpha($cropImage, 255, 255, 255, 127);
   				imagefilledrectangle($cropImage, 0, 0, $cropW, $cropH, $transparent);
			}
			
			
			//imagecopyresampled ($cropImage, $newImg, 0, 0, 0, 0, $cropW, $cropH, $nWidth, $nHeight);
			imagecopy($cropImage, $newImg, 0, 0, $left, $top, $cropW, $cropH);
			//Generate the file, and rename it to $newfilename
			
			switch ($imgInfo[2]) 
			{
				case 1: imagegif($cropImage,$newImagePath); break;
				case 2: imagejpeg($cropImage,$newImagePath, $jpgQuality);  break;
				case 3: imagepng($cropImage,$newImagePath); break;
				default:  return false;
			}
			
			imagedestroy($im);
			imagedestroy($newImg);
			imagedestroy($cropImage);
		}
		
		function mergeImage($pathSource, $pathDes='', $newImagePath='', $jpgQuality = 100)
		{
			if($newImagePath=='')$newImagePath = $pathSource;
			if($pathDes=='')$pathDes = DT_ROOT.'/'.IMGPATH.'watermark.png';
			$imgSrcInfo = @getimagesize($pathSource);//img
			$imgDesInfo = @getimagesize($pathDes);//water
			
			switch ($imgSrcInfo[2]) {
				case 1: $imSrc = imagecreatefromgif($pathSource); break;
				case 2: $imSrc = imagecreatefromjpeg($pathSource);  break;
				case 3: $imSrc = imagecreatefrompng($pathSource); break;
				default:  return false;
		 	}
		 	
			switch ($imgDesInfo[2]) {
				case 1: $imDes = imagecreatefromgif($pathDes); break;
				case 2: $imDes = imagecreatefromjpeg($pathDes);  break;
				case 3: $imDes = imagecreatefrompng($pathDes); break;
				default:  return false;
		 	}
			if( $imgDesInfo[2] == 1)
			{
				$createImage = imagecreatetruecolor($imgSrcInfo[0], $imgSrcInfo[1]);
				imagecopy($createImage, $imSrc,  0, 0, 0, 0, $imgSrcInfo[0], $imgSrcInfo[1]);
				imagecopy($createImage, $imDes,$imgSrcInfo[0]-$imgDesInfo[0]- 10,$imgSrcInfo[1]-$imgDesInfo[1]- 10, 0, 0, $imgDesInfo[0], $imgDesInfo[1]);
				imagejpeg($createImage,$newImagePath, 100);
				imagedestroy($createImage);
			}else{
				imagecopymerge($imSrc, $imDes,$imgSrcInfo[0]-$imgDesInfo[0]- 10,$imgSrcInfo[1]-$imgDesInfo[1]- 10, 0, 0, $imgDesInfo[0], $imgDesInfo[1],$jpgQuality);
				switch($imgSrcInfo[2]) {
					case '1': imagegif($imSrc, $newImagePath); break;
					case '2': imagejpeg($imSrc, $newImagePath, $jpgQuality); break;
					case '3': imagepng($imSrc, $newImagePath); break;
					default : imagejpeg($imSrc, $newImagePath, $jpgQuality); break;
				}
			}
			imagedestroy($imSrc);
			imagedestroy($imDes);
		}
		
		function destroy()
		{
			imagedestroy($this->image);
		}
		
}


/* End of file Table.php */
/* Location: ./system/libraries/Table.php */
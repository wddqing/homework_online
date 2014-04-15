<?php
/*
 * Created on 2014-3-2 
 * Author:wddqing 
 * Mail:wddqing@gmail.com 
 * Function:生成图片验证码
*/
class identifyingCode {
	/**
	 *
	 * @var 图片宽度
	 */
	private $width;
	/**
	 *
	 * @var 图片高度
	 */
	private $height;
	/**
	 *
	 * @var 图片内容/验证码内容
	 */
	private $content;

	/**
	 *
	 * @var 图片验证码
	 */
	private $image;

	/**
	 *
	 * @var 图片背景颜色rgb值
	 */
	public $red = 255;
	/**
	 *
	 * @var 图片背景颜色rgb值
	 */
	public $blue = 255;
	/**
	 *
	 * @var 图片背景颜色rgb值
	 */
	public $green = 255;

	/**
	 *
	 * @var int 干扰线数量
	 */
	private $lineNum = 3;
	/**
	 *
	 * @var int 干扰点数量
	 */
	private $pointNum = 10;
	

	/**
	 * @var int 验证码长度
	 */
	private $length = 4;

	/**
	 * @param number $length
	 */
	public final function setLength($length) {
		$this->length = $length;
	}

	/**
	 *
	 * @return the $image
	 */
	public final function getImage() {
		return $this->image;
	}

	/**
	 *
	 * @param 图片验证码 $image
	 */
	public final function setImage($image) {
		$this->image = $image;
	}

	/**
	 *
	 * @return the $width
	 */
	public final function getWidth() {
		return $this->width;
	}

	/**
	 *
	 * @return the $height
	 */
	public final function getHeight() {
		return $this->height;
	}

	/**
	 *
	 * @return the $content
	 */
	public final function getContent() {
		return $this->content;
	}

	/**
	 *
	 * @param number $width
	 */
	public final function setWidth($width) {
		$this->width = $width;
	}

	/**
	 *
	 * @param field_type $height
	 */
	public final function setHeight($height) {
		$this->height = $height;
	}

	/**
	 *
	 * @param string $content
	 */
	public final function setContent($content) {
		$this->content = $content;
	}
	/**
	 *
	 * @param number $width
	 *        	图像宽度
	 * @param number $height
	 *        	图像高度
	 * @param string $content
	 *        	图像内容
	 * @param string $length
	 * 			验证码长度
	 * @param int $type
	 * 			验证码类型
	 * 
	 */
	function __construct($width = 60, $height = 30, $length = 4,$type = 3) {
		session_start();
		if ($width < 20 || $width > 100) {
			$width = 60;
		} elseif ($height < 10 || $height > 60) {
			$height = 30;
		} elseif ($length > 10 || $length < 1) {
			$length = 4;
		}
		$this->length = $length;
		
		switch ($type){
			case 1:$this->get_rand_num();break;
			case 2:$this->get_rand_letter();break;
			case 3:$this->get_num_letter();break;
			default:$this->get_num_letter();
		}
		
		
		$_SESSION['code'] = $this->content;
		$this->width = $width;
		$this->height = $height;
	}
	function __destruct() {
		
		//imagedestroy ( $this->image );
		$this->width = null;
		$this->height = null;
		$this->content = null;
		$this->red = null;
		$this->blue = null;
		$this->green = null;
	}

	//返回一定长度的纯数字
	function get_rand_num(){
		for($i=0;$i<$this->length;$i++){
			$this->content .= mt_rand(0,9);
		}
	}
	//返回一定长度的字母
	function get_rand_letter(){
		$letter = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
		for($i=0;$i<$this->length;$i++){
			$this->content .= $letter[mt_rand(0,51)];
		}
	}
	//返回一定长度的字母和数字
	function get_num_letter(){
		for($i=0;$i<$this->length;$i++){
			$this->content .= dechex(mt_rand(0,15));
		}
	}
	/**
	 *
	 * @param 图片背景RGB值 $red
	 * @param 图片背景RGB值 $green
	 * @param 图片背景RGB值 $blue
	 *        	设定图片背景值
	 */
	public function set_background($red, $green, $blue) {
		if ($red >= 0 && $red <= 255) {
			$this->red = $red;
		}
		if ($green >= 0 && $green <= 255) {
			$this->green = $green;
		}
		if ($blue >= 0 && $blue <= 255) {
			$this->blue = $blue;
		}
	}
	/**
	 *
	 * @param integer $lineNum
	 *        	干扰线数量
	 * @param integer $pointNum
	 *        	干扰点数量
	 */
	public function set_disturbance($lineNum, $pointNum) {
		if ($this->height / 10 < $lineNum) {
			$lineNum = floor ( $this->height / 10 );
		}
		if (($this->height * $this->width) / 30 < $pointNum) {
			$pointNum = floor ( $this->height * $this->width / 30 );
		}

		$this->lineNum = $lineNum;
		$this->pointNum = $pointNum;
	}
	/**
	 *
	 * @return boolean 判断gd扩展是否已经打开
	 */
	public function test_gd() {
		if (extension_loaded ( 'gd' )) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	/**
	 *
	 * @param integer $type
	 *        	验证码干扰类型 0 默认无干扰 1 加线干扰 2加雪花干扰 3加线和雪花 其他值等价于0
	 * @return string resource
	 */
	public function generate_img($type = 0) {
		// 每个字符至少有15像素宽
		if (strlen ( $this->content ) < $this->width / 15) {
			$this->width = strlen ( $this->content ) * 15;
		}
		if ($this->test_gd ()) {
			// 创建画布
			
			$this->image = imagecreatetruecolor ( $this->width, $this->height );
			// 填充背景色
			$backcolor = imagecolorallocate ( $this->image, $this->red, $this->green, $this->blue );
				
			imagefill ( $this->image, 0, 0, $backcolor );
			// 判断是否加干扰
			if ($type == 3 || $type == 1) {
				for($i = 0; $i < $this->lineNum; $i ++) {
					// 加线干扰
					$lineColor = imagecolorallocate ( $this->image, mt_rand ( 150, 255 ), mt_rand ( 150, 255 ), mt_rand ( 150, 255 ) );
						
					imageline ( $this->image, mt_rand ( 0, $this->width * 0.1 ), mt_rand ( 0, $this->height ), mt_rand ( $this->width * 0.9, $this->width ), mt_rand ( 0, $this->height ), $lineColor );
				}
			}
			if ($type == 3 || $type == 2) {
				for($i = 0; $i < $this->pointNum; $i ++) {
					// 加雪花干扰
					$snowColor = imagecolorallocate ( $this->image, mt_rand ( 200, 255 ), mt_rand ( 200, 255 ), mt_rand ( 200, 255 ) );
						
					imagechar ( $this->image, 1, mt_rand ( 0, $this->width ), mt_rand ( 0, $this->height ), '*', $snowColor );
				}
			}
			// 将内容写入验证码
			$num = strlen ( $this->content );
			for($i = 0; $i < $num; $i ++) {

				$fontColor = imagecolorallocate ( $this->image, mt_rand ( 10, 150 ), mt_rand ( 10, 150 ), mt_rand ( 10, 150 ) );

				imagechar ( $this->image, 5, $i * ($this->width - 5) / $num + mt_rand ( 5, 10 ), mt_rand ( 2, $this->height / 2 ), $this->content [$i], $fontColor );
			}
			return $this->image;
		} else {
			return 'the gd extension did not loaded!';
		}
	}
}


?>
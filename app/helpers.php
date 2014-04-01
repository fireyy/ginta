<?php

function __($line) {
	$args = array_slice(func_get_args(), 1);

	return Language::line($line, null, $args);
}

function is_admin() {
	return strpos(Uri::current(), 'admin') === 0;
}

function is_installed() {
	return Config::get('db') !== null or Config::get('database') !== null;
}

function slug($str, $separator = '-') {
	$str = normalize($str);

	// replace non letter or digits by separator
	$str = preg_replace('#^[^A-z0-9]+$#', $separator, $str);

	return trim(strtolower($str), $separator);
}

function parse($str, $markdown = true) {
	// process tags
	$pattern = '/[\{\{]{1}([a-z]+)[\}\}]{1}/i';

	if(preg_match_all($pattern, $str, $matches)) {
		list($search, $replace) = $matches;

		foreach($replace as $index => $key) {
			$replace[$index] = Config::meta($key);
		}

		$str = str_replace($search, $replace, $str);
	}

	$str = html_entity_decode($str, ENT_NOQUOTES, System\Config::app('encoding'));

	//  Parse Markdown as well?
	if($markdown === true) {
		$md = new Markdown;
		$str = $md->transform($str);
	}

	return $str;
}

function readable_size($size) {
	$unit = array('b','kb','mb','gb','tb','pb');

	return round($size / pow(1024, ($i = floor(log($size, 1024)))), 2) . ' ' . $unit[$i];
}

function getImageURL($file){
  return asset("content/".$file);
}

function getThumbURL($file){
  $ext = pathinfo($file, PATHINFO_EXTENSION);
  $file = str_replace(".".$ext, "_thumb.".$ext, $file);
  return asset("content/".$file);
}

function get_gravatar( $email, $s = 80, $d = 'mm', $r = 'g', $img = false, $atts = array() ) {
  $url = 'http://www.gravatar.com/avatar/';
  $url .= md5( strtolower( trim( $email ) ) );
  $url .= "?s=$s&d=$d&r=$r";
  if ( $img ) {
    $url = '<img src="' . $url . '"';
    foreach ( $atts as $key => $val )
      $url .= ' ' . $key . '="' . $val . '"';
    $url .= ' />';
  }
  return $url;
}

function convertIntToShortCode2($url='', $prefix='', $suffix='') {  
    $base = array (  
       'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h',  
       'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p',  
       'q', 'r', 's', 't', 'u', 'v', 'w', 'x',  
       'y', 'z', '0', '1', '2', '3', '4', '5');  
   
    $hex = md5($prefix.$url.$suffix);  
    $hexLen = strlen($hex);  
    $subHexLen = $hexLen / 8;  
    $output = array();  
   
    for ($i = 0; $i < $subHexLen; $i++) {  
        $subHex = substr ($hex, $i * 8, 8);  
        $int = 0x3FFFFFFF & (1 * ('0x'.$subHex));  
        $out = '';  
        for ($j = 0; $j < 6; $j++) {  
            $val = 0x0000001F & $int;  
            $out .= $base[$val];  
            $int = $int >> 5;  
        }  
        $output[] = $out;  
    }  
    return $output[0];  
}

function convertIntToShortCode( $long_url ){
  $key = 'gintame';
  $base32 = "abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";

  // 利用md5算法方式生成hash值
  $hex = hash('md5', $long_url.$key);
  $hexLen = strlen($hex);
  $subHexLen = $hexLen / 8;

  $output = array();
  for( $i = 0; $i < $subHexLen; $i++ ){
    // 将这32位分成四份，每一份8个字符，将其视作16进制串与0x3fffffff(30位1)与操作
    $subHex = substr($hex, $i*8, 8);
    $idx = 0x3FFFFFFF & (1 * ('0x' . $subHex));

    // 这30位分成6段, 每5个一组，算出其整数值，然后映射到我们准备的62个字符
    $out = '';
    for( $j = 0; $j < 6; $j++ ){
      $val = 0x0000003D & $idx;
      $out .= $base32[$val];
      $idx = $idx >> 5;
    }
    $output[$i] = $out;
  }

  return $output[0];
}
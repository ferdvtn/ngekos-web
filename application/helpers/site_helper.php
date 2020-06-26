<?php

defined('BASEPATH') OR exit('No direct script access allowed');


if (!function_exists('guid')) {
	function guid() {
		$CI =& get_instance();
		$CI->load->helper('string');
		return random_string('unique');
	}
}

if (!function_exists('go_back')) {
	function go_back() {
		return $_SERVER['HTTP_REFERER'];
	}
}

if (!function_exists('dashToSpace')) {
	function unLineToSpace($str) {
		$str = ucwords(str_replace('_', ' ', trim($str)));
		return $str;
	}
}
<?php

class Template {

	public static function create($path, $vars = array()) {
		return View::create($path, $vars)
			->partial('header', 'commons/header', $vars)
			->partial('footer', 'commons/footer', $vars);
	}

}
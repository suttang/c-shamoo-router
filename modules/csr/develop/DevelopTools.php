<?php
class DevelopTools extends CSR_Object {
	
	function __construct() {
		// CSR::set('developTools', array());
	}
	
	function &contents() {
		static $contents;
		return $contents;
	}
	
	function initialize() {
		CSR::addEvent(EVENT_APPLICATION_START, array('DevelopTools', 'applicationStartHandler'));
	}
	
	function applicationStartHandler($params) {
		$routes = &CSR::get('routes');
		$routes['/develop/'] = MODULES_DIR . 'csr/develop/public/index.php';
		
		// Create controller
		DevelopTools::setContent(array(
			'title' => 'Generate Controller',
			'message' => 'フォームからコントローラーとビューの作成を行います。',
			'contents' => MODULES_DIR . 'csr/develop/public/generate/index.html',
			'path' => 'generate'
		));
		
		$contents = &DevelopTools::contents();
		foreach ($contents as $content) {
			$routes['/develop/' . $content['path']] = $content['contents'];
		}
		// routesに追加
		$routes['/develop/(.*)'] = MODULES_DIR . 'csr/develop/public/$1';
		
	}
	/*
		DevelopTools::setContent(array(
			'title' => 'Generate Controller And View',
			'message' => 'コントローラとビューの作成を簡単に行います。',
			'contents' => MODULES_DIR . 'csr/architecture/vc/develop_tools/generate.html',
			'path' => 'generate'
		));
	*/
	// デベロッパコンテンツを増やす
	function setContent($content) {
		$contents = &DevelopTools::contents();
		$contents[$content['path']] = $content;
	}
}
if (CSR_DEVELOP_MODE) DevelopTools::initialize();
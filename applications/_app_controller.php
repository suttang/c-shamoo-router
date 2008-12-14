<?php
class ApplicationController extends CSR_Controller {
	
	var $pageTitle = '';
	var $js = array();
	var $css = array();
	
	function __construct() {
		parent::__construct();
	}
	
	function beforeAction() {}
	function afterAction() {
		$this->set('pageTitle', $this->pageTitle, 'pageTitle');
		$this->set('js', $this->js, 'js');
		$this->set('css', $this->css, 'css');
	}
	function beforeRender() {}
	function afterRender() {}
}
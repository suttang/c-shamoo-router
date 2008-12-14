<?php
class IndexController extends ApplicationController {
	
	function __construct() {
		parent::__construct();
	}
	
	function index() {
		$this->pageTitle = 'This is CSR default page.';
	}
}
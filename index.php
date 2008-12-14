<?php
/**
 * index.php
 * @package csr
 */
/**
 * require CSR classes
 */
require 'csr.php';

if (CSR_DEVELOP_MODE)
	CSR::import('csr.develop.DevelopTools');
	
CSR::execute(array(
	'/' => 'index/index'
));

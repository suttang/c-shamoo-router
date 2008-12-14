<?php

if (empty($_POST['controller'])) {
	echo "damedayo";
	exit();
}

$controllerName = ucwords(strtolower($_POST['controller'])) . 'Controller';

//// Controller
if (file_exists(CONTROLLERS_DIR . $controllerName . '.php')) {
	echo "mouaruyuo";
}

// create
if (!touch(CONTROLLERS_DIR . $controllerName . '.php')) {
	echo "damedattayo";
	exit();
}

// write
$fp = fopen(CONTROLLERS_DIR . $controllerName . '.php', 'w');
fwrite($fp, sprintf('<?php
class %s extends ApplicationController {
	
	function __construct() {
		parent::__construct();
	}
	
	function index() {
		$this->pageTitle = \'%s\';
	}
}
', $controllerName, $controllerName));
fclose($fp);

//// View
$viewDir = VIEWS_DIR . strtolower($_POST['controller']);
if (!mkdir($viewDir)) {
	echo "view dameyo";
	exit();
}
touch($viewDir . '/_layout.html');
touch($viewDir . '/index.html');
$fp = fopen($viewDir . '/_layout.html', 'w');
fwrite($fp, sprintf('<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
	"http://www.w3.org/TR/html4/strict.dtd">
<html lang="ja">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8">
	<title><?php echo $pageTitle; ?></title>
<?php foreach ($css as $cssfile) { ?>
	<link rel="stylesheet" href="<?php echo ROOT_PATH ?>css/<?php echo $cssfile; ?>" type="text/css" charset="utf-8">
<?php } ?>
<?php foreach ($js as $jsfile) { ?>
	<script type="text/javascript" src="<?php echo ROOT_PATH ?>js/<?php echo $jsfile; ?>"></script>
<?php } ?>
</head>
<body>
<?php $this->content(); ?>

</body>
</html>'));
fclose($fp);
$fp = fopen($viewDir . '/index.html', 'w');
fwrite($fp, sprintf('<h1>%s</h1>', $controllerName));
fclose($fp);
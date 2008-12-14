<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
	"http://www.w3.org/TR/html4/strict.dtd">
<html lang="ja">
	<head>
		<meta http-equiv="content-type" content="text/html;charset=utf-8">
		<meta http-equiv="content-style-type" content="text/css">
		<meta http-equiv="content-script-type" content="text/javascript">
		<title>CSR::DevelopTools</title>
		<link rel="stylesheet" href="<?php echo ROOT_PATH ?>modules/csr/develop/public/css/initialize.css" type="text/css" charset="utf-8">
		<link rel="stylesheet" href="<?php echo ROOT_PATH ?>modules/csr/develop/public/css/develop.css" type="text/css" charset="utf-8">
		<link rel="stylesheet" href="<?php echo ROOT_PATH ?>modules/csr/develop/public/css/develop_index.css" type="text/css" charset="utf-8">
	</head>
	<body>
		<div id="page">
			<div id="header_wrapper">
				<div class="header" id="header">
					<h1>CSR::DevelopTools</h1>
					<p class="url">http://<?= $_SERVER['HTTP_HOST'] ?><?= $_SERVER['REQUEST_URI'] ?></p>
					<!--
					<p class="description">
						c-shamoo router 開発ツール
					</p>
					-->
					<p class="breadcrumbs">
						<a href="<?= ROOT_PATH ?>">CSR Root</a> &raquo; DevelopTools
					</p>
				</div>
			</div>
			<div class="contents" id="contents">
<?php
	$modules = &DevelopTools::contents();
	foreach ($modules as $moduleName => $module) {
?>
				<div class="content">
					<h3><a href="<?= $module['path'] ?>"><?= $module['title']; ?></a></h3>
					<p><?= $module['message'] ?></p>
				</div>
<?php
	}
?>
			</div>
			<div class="footer" id="footer">
				CSR
			</div>
		</div>
	</body>
</html>
<?php
/**
 * 400 page
 * @package csr
 */
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
	"http://www.w3.org/TR/html4/strict.dtd">
<html lang="ja">
	<head>
		<meta http-equiv="content-type" content="text/html;charset=utf-8">
		<title>400 Bad Request.</title>
	</head>
	<body>
		<h1>400 Bad Request.</h1>
<?php
	if (CSR_DEVELOP_MODE && isset($debugMessage) && is_array($debugMessage)) {
		foreach ($debugMessage as $message) {
?>
	<?php echo $message; ?>
<?php
		}
	}
?>
<?php
	if (CSR_DEVELOP_MODE && isset($debugHelpFile) && file_exists($debugHelpFile)) require $debugHelpFile;
?>
	</body>
</html>
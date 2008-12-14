<?php
	$dispatcher = CSR::get('dispatcher');
	list($controller, $action) = explode('/', $dispatcher->getTarget());
	// var_dump($dispatcher);
?>
<p>
	指定されたアクションが見つかりませんでした。
</p>
<p>
	意図せずこの画面が表示された場合は、 <?php echo CONTROLLERS_DIR ?> ディレクトリの
	<?php echo ucwords($controller); ?>Controller.phpファイルを開き、
	以下のメソッドが存在することを確かめてください。
	無いとこの画面が出ます。
</p>
<pre>
&lt;?php
class <?php echo ucwords($controller); ?>Controller extends ApplicationController {
	function <?php echo $action ?> {
		
	}
}
</pre>
<p>
	存在するにも関わらず、この画面が表示される場合は、バグです。
	開発者にご連絡ください。
	http://dev.shamoo.org/
</p>
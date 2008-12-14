<?php
	$dispatcher = CSR::get('dispatcher');
	list($controller, $action) = explode('/', $dispatcher->getTarget());
	// var_dump($dispatcher);
?>
<p>指定されたコントローラーが見つかりませんでした。</p>
<p>
	意図せずこの画面が表示された場合は、 <?php echo CONTROLLERS_DIR ?> ディレクトリに
	<?php echo ucwords($controller); ?>Controller.phpという名前で、以下のような内容のファイルが存在することを確かめてください。
</p>
<pre>
&lt;?php
class <?php echo ucwords($controller); ?>Controller extends ApplicationController {
	
}
</pre>
<p>
	存在するにも関わらず、この画面が表示される場合は、バグです。
	開発者にご連絡ください。
	http://dev.shamoo.org/
</p>
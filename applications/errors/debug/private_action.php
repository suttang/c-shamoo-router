<?php
	$dispatcher = CSR::get('dispatcher');
	list($controller, $action) = explode('/', $dispatcher->getTarget());
	// var_dump($dispatcher);
?>
<p>
	プライベートアクションの呼び出しがされました。
</p>
<p>_"アンダースコア"で始まるアクションは、プライベートアクションとして定義されるため、外部から呼び出すことは出来ません。</p>

<p>
	_がついてないにも関わらず、この画面が表示される場合は、バグです。
	開発者にご連絡ください。
	http://dev.shamoo.org/
</p>
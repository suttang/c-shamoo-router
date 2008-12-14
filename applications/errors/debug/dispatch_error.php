<p>URI Dispatchに失敗しました。</p>
<p>意図せずこの画面が表示された場合、このアプリケーションに登録されたURIリストの中から、リクエストURIに該当する物が存在するかどうかを確認してください。存在しない場合に、このエラーが表示されます。</p>
<p>
	あるのに、このエラーが出る場合は、多分バグです。開発者に連絡してください。 http://dev.shamoo.org/
</p>
<?php
	$dispatcher = CSR::get('dispatcher');
	$routes = $dispatcher->getRoutes();
	$request = $dispatcher->request;
?>
<h2>Routes</h2>
<ul>
<?php
	foreach ($routes as $uri => $route) {
?>
	<li><?php echo $uri; ?> =&gt; <?php echo $route ?></li>
<?php
	}
?>
</ul>
<h2>RequestURI</h2>
<?php echo $request ?>
<h2>解決策</h2>
<p>リクエストをRoutesの左側のリストの中にあるような文字列にして下さい。</p>
<p>もしくは、index.php(デフォルト)に記述されたRoutesリストを編集し、 <?php echo $request ?> を受け付ける様にしてください。</p>
<style type="text/css">
.desk-item {
	display: block;
	text-align: center;
	background: #f0f0f0;
	padding:10px 0 5px;
}
.desk-item:hover {
	text-decoration: none;
	background: #faeecc;
}
.desk-item img {
	width: 40%;
}
.col-md-2 {
	margin-top: 20px;
}
.alert {
	margin-bottom: 10px;
}
</style>
<div class="container">
	<div class="alert alert-success">
		<small>
			<strong>拥有权限：</strong><?php echo \app\models\T_admin::printRole(\core\Autumn::app()->request->getSession('am_role'), false); ?> |
			<strong>最后登录时间：</strong><?php echo \core\Autumn::app()->request->getSession('am_time'); ?> |
			<strong>最后登录地址：</strong><?php echo \core\Autumn::app()->request->getSession('am_ip'); ?><br>
			<strong>服务器时间：</strong>(北京) <?php echo date('Y-m-d H:i:s'); ?> |
			<strong>时间戳：</strong><?php echo time(); ?>
		</small>
	</div>
	<div class="row">
		<div class="col-md-2">
			<a class="desk-item" href="/home/channel">
				<p><img src="/app/statics/home/images/png-0814.png"></p>
				<p><strong style="font-size:16px;">栏目和内容</strong> <br><small>[权限：内容]</small></p>
			</a>
		</div>
		<!--
		<div class="col-md-2">
			<a class="desk-item" href="/home/page">
				<p><img src="/app/statics/home/images/png-0071.png"></p>
				<p><strong style="font-size:16px;">移动设备</strong> <br><small>[权限：内容]</small></p>
			</a>
		</div>-->
		<!--
		<div class="col-md-2">
			<a class="desk-item" href="/home/struct">
				<p><img src="/app/statics/home/images/png-0011.png"></p>
				<p><strong style="font-size:16px;">配置项</strong> <br><small>[权限：内容]</small></p>
			</a>
		</div>-->
		<div class="col-md-2">
			<a class="desk-item" href="/home/file">
				<p><img src="/app/statics/home/images/png-0841.png"></p>
				<p><strong style="font-size:16px;">资源</strong> <br><small>[权限：内容]</small></p>
			</a>
		</div>
		<div class="col-md-2">
			<a class="desk-item" href="/home/keyword">
				<p><img src="/app/statics/home/images/png-0017.png"></p>
				<p><strong style="font-size:16px;">关键词模型</strong> <br><small>[权限：内容]</small></p>
			</a>
		</div>
		<!--
		<div class="col-md-2">
			<a class="desk-item" href="/home/contentNote">
				<p><img src="/app/statics/home/images/png-0517.png"></p>
				<p><strong style="font-size:16px;">评论</strong> <br><small>[权限：客服]</small></p>
			</a>
		</div>-->
		<!--
		<div class="col-md-2">
			<a class="desk-item" href="/home/product">
				<p><img src="/app/statics/home/images/png-0950.png"></p>
				<p><strong style="font-size:16px;">商品</strong> <br><small>[权限：商品]</small></p>
			</a>
		</div>-->
		<div class="col-md-2">
			<a class="desk-item" href="/home/user">
				<p><img src="/app/statics/home/images/png-0846.png"></p>
				<p><strong style="font-size:16px;">用户</strong> <br><small>[权限：用户]</small></p>
			</a>
		</div>
		<!--
		<div class="col-md-2">
			<a class="desk-item" href="/home/admin">
				<p><img src="/app/statics/home/images/png-0840.png"></p>
				<p><strong style="font-size:16px;">管理员</strong> <br><small>[权限：管理员]</small></p>
			</a>
		</div>-->
		<!--
		<div class="col-md-2">
			<a class="desk-item" href="javascript:;">
				<p><img src="/app/statics/home/images/png-0845.png"></p>
				<p><strong style="font-size:16px;">客服</strong> <br><small>[权限：客服]</small></p>
			</a>
		</div>
		<div class="col-md-2">
			<a class="desk-item" href="javascript:;">
				<p><img src="/app/statics/home/images/png-0630.png"></p>
				<p><strong style="font-size:16px;">通讯</strong> <br><small>[权限：客服]</small></p>
			</a>
		</div>-->
	</div>
</div>
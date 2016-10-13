<div class="container">
	<div class="col-md-4">
		<legend>订单详情</legend>
		<p>
			<label>订单号：</label>
			<strong><?php echo $order->od_id; ?></strong>
		</p>
		<p>
			<label>订单总额：</label>
			<strong class="text-success" style="font-size:18px;"><?php echo $order->od_total; ?></strong>
		</p>
		<p>
			<label>订单备注：</label>
			<textarea class="form-control" rows="4"></textarea>
		</p>
		<p>&nbsp;</p>
		<legend>客户信息</legend>
		<p>
			<label>用户姓名：</label>
			<strong><a href="/home/userDetail/id/<?php echo $user->user_id; ?>"><?php echo $user->user_name; ?></a></strong>
		</p>
		<p>
			<label>联系电话：</label>
			<strong><?php echo $user->user_phone; ?></strong>
		</p>
	</div>
	<div class="col-md-8">
		<legend>商品列表</legend>
		<table class="table table-bordered">
			<thead>
				<tr>
					<th>图片</th>
					<th>名称</th>
					<th>数量</th>
					<th>单价</th>
					<th>折扣</th>
					<th>操作</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($product_list as $v) { ?>
				<tr>
					<td><?php if($v->pd_image != '') echo '<img src="/nfs/image/',$v->pd_image,'" style="max-width:80px;">'; ?></td>
					<td><?php echo $v->pd_name; ?></td>
					<td><?php echo $v->cr_count; ?></td>
					<td><?php echo $v->cr_price; ?></td>
					<td><?php echo $v->cr_discount; ?></td>
					<td><a href="/home/stock/" class="btn btn-xs btn-default">查看库存</a></td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>
<div class="container">
	<div class="row">
		<div class="col-md-6">
			<span class="btn-group">
				<a href="/home/order/s/1" class="btn btn-sm <?php echo $status == 1 ? 'btn-info' : 'btn-default'; ?>">新订单</a>
				<a href="/home/order/s/2" class="btn btn-sm <?php echo $status == 2 ? 'btn-info' : 'btn-default'; ?>">已支付</a>
				<a href="/home/order/s/3" class="btn btn-sm <?php echo $status == 3 ? 'btn-info' : 'btn-default'; ?>">已接受</a>
				<a href="/home/order/s/4" class="btn btn-sm <?php echo $status == 4 ? 'btn-info' : 'btn-default'; ?>">已拒绝</a>
				<a href="/home/order/s/5" class="btn btn-sm <?php echo $status == 5 ? 'btn-info' : 'btn-default'; ?>">已发货</a>
				<a href="/home/order/s/6" class="btn btn-sm <?php echo $status == 6 ? 'btn-info' : 'btn-default'; ?>">已完成</a>
				<a href="/home/order/s/7" class="btn btn-sm <?php echo $status == 7 ? 'btn-info' : 'btn-default'; ?>">已评论</a>
				<a href="/home/order/s/0" class="btn btn-sm <?php echo $status == 0 ? 'btn-info' : 'btn-default'; ?>">已关闭</a>
			</span>
		</div>
		<div class="col-md-3">
			<div style="padding-top:4px;">订单总数：<strong><?php echo $count; ?></strong> 笔</div>
		</div>
		<div class="col-md-3">
			<form class="input-group" method="get" action="">
				<input type="text" class="form-control input-sm" name="k" value="<?php //echo $keyword; ?>">
				<span class="input-group-btn">
					<button type="submit" class="btn btn-info btn-sm">
						<span class="glyphicon glyphicon-search"></span> 搜索
					</button>
				</span>
			</form>
		</div>
	</div>
	<p>&nbsp;</p>
	<table class="table table-bordered">
		<thead>
			<tr>
				<th>订单号</th>
				<th>总额</th>
				<th>付款方式</th>
				<th>付款流水号</th>
				<th>创建时间</th>
				<th>付款时间</th>
				<th>更新时间</th>
				<th>备注</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($order_list as $v) { ?>
			<tr>
				<td><a href="/home/orderDetail/id/<?php echo $v->od_id; ?>" target="_blank"><?php echo $v->od_id; ?></a></td>
				<td><?php echo $v->od_total; ?></td>
				<td><?php echo $v->od_paytype; ?></td>
				<td><?php echo $v->od_flowid; ?></td>
				<td><?php echo date('m-d H:i', $v->od_ctime); ?></td>
				<td><?php if($v->od_ptime) echo date('m-d H:i', $v->od_ptime); ?></td>
				<td><?php if($v->od_utime) echo date('m-d H:i', $v->od_utime); ?></td>
				<td><?php echo $v->od_note; ?></td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
	<p><?php echo $pages; ?></p>
</div>
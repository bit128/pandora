<div class="container">
	<div class="row">
		<div class="col-md-4">
			<span class="btn-group">
				<a href="/home/user/s/1" class="btn btn-sm <?php echo $status == 1 ? 'btn-info' : 'btn-default'; ?>">正式用户</a>
				<a href="/home/user/s/2" class="btn btn-sm <?php echo $status == 2 ? 'btn-info' : 'btn-default'; ?>">开放平台用户</a>
				<a href="/home/user/s/0" class="btn btn-sm <?php echo $status == 0 ? 'btn-info' : 'btn-default'; ?>">冻结用户</a>
			</span>
		</div>
		<div class="col-md-4">
			<div style="padding-top:4px;">用户总数：<strong><?php echo $count; ?></strong> 人</div>
		</div>
		<div class="col-md-4">
			<form class="input-group" method="get" action="">
				<input type="text" class="form-control input-sm" name="k">
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
				<th>编号</th>
				<th>电话</th>
				<th>邮箱</th>
				<th>姓名</th>
				<th>注册时间</th>
				<th>登录时间</th>
				<th style="width:80px;">操作</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($user_list as $v) { ?>
			<tr>
				<td><?php echo $v->user_id; ?></td>
				<td><?php echo $v->user_phone; ?></td>
				<td><?php echo $v->user_email; ?></td>
				<td><?php echo $v->user_name; ?></td>
				<td><?php echo date('Y-m-d', $v->user_ctime); ?></td>
				<td><?php echo date('Y-m-d', $v->user_ltime); ?></td>
				<td>
					<a href="/home/userDetail/id/<?php echo $v->user_id; ?>" class="btn btn-info btn-xs">
						<span class="glyphicon glyphicon-user"></span> 详情
					</a>
				</td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
	<p><?php echo $pages; ?></p>
	<p>&nbsp;</p>
</div>
<div class="container">

	<ul class="nav nav-tabs" id="myTab">
		<li class="active"><a href="#list" data-toggle="tab">管理员列表</a></li>
		<li><a href="#add" data-toggle="tab">添加管理员</a></li>
	</ul>

	<div class="tab-content">
		<div class="tab-pane active" id="list">
			<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th style="width:20%">账号</th>
						<th>姓名</th>
						<th>部门</th>
						<th>权限</th>
						<th style="width:150px;">操作</th>
					</tr>
				</thead>
				<tbody id="am_list">
					<?php foreach($admin_list as $v) { ?>
					<tr>
						<td><?php echo $v->am_account; ?></td>
						<td><a href="javascript:;" class="set_name"><?php echo $v->am_name; ?></a></td>
						<td>
							<select class="set_group">
								<option>请选择</option>
								<option <?php if($v->am_group == '产品') echo 'selected'; ?>>产品</option>
								<option <?php if($v->am_group == '运营') echo 'selected'; ?>>运营</option>
								<option <?php if($v->am_group == '财务') echo 'selected'; ?>>财务</option>
							</select>
						</td>
						<td><?php echo \app\models\T_admin::printRole($v->am_role); ?></td>
						<td>
							<button type="button" class="btn btn-info btn-xs cp_box">重置</button>
							<?php if($v->am_status == 1) { ?>
							<button type="button" class="btn btn-warning btn-xs change_status" data-val="0">冻结</button>
							<?php } else { ?>
							<button type="button" class="btn btn-success btn-xs change_status" data-val="1">启用</button>
							<?php } ?>
							<button type="button" class="btn btn-xs delete_account">删除</button>
						</td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
			<p><?php echo $pages; ?></p>
		</div>
		<div class="tab-pane" id="add">
			<div class="row">
				<div class="col-md-3"></div>
				<div class="col-md-6">
					<p>&nbsp;</p>
					<form>
						<p>
							<label>账号：</label>
							<input type="text" class="form-control" id="am_account">
						</p>
						<p>
							<label>密码：</label>
							<input type="password" class="form-control" id="am_password">
						</p>
						<div class="row">
							<div class="col-md-6">
								<p>
									<label>姓名：</label>
									<input type="text" class="form-control" id="am_name" value="请填写">
								</p>
							</div>
							<div class="col-md-6">
								<p>
									<label>部门：</label>
									<select class="form-control" id="am_group">
										<option>请选择</option>
										<option>产品</option>
										<option>运营</option>
										<option>财务</option>
									</select>
								</p>
							</div>
						</div>
						<p>
							<label>权限：</label><br>
							<span id="form_role"><?php echo \app\models\T_admin::printRole(); ?></span>
						</p>
						<p>&nbsp;</p>
						<p>
							<button type="button" class="btn btn-info" id="add_admin">创建管理员</button>
						</p>
						<p>&nbsp;</p>
					</form>
				</div>
				<div class="col-md-3"></div>
			</div>
		</div>
	</div>

</div>
<!-- 变更密码框 -->
<div id="cp_box" class="popover left">
	<div class="arrow"></div>
	<div class="popover-content">
		<div class="input-group">
			<input type="text" class="form-control">
			<span class="input-group-btn">
				<button type="button" class="btn btn-info">变更</button>
				<button type="button" class="btn btn-default">取消</button>
			</span>
		</div>
	</div>
</div>
<!-- 变更密码框 -->
<script type="text/javascript">
$(document).ready(function(){
	//创建管理员
	$('#add_admin').on('click', function(){
		var am_account = $('#am_account').val();
		if(am_account == ''){alert('请填写账号');$('#am_account').focus();return;}
		var am_password = $('#am_password').val();
		if(am_password == ''){alert('请填写密码');$('#am_password').focus(); return;}
		var role = 0;
		$('#form_role input[name="am_role"]:checked').each(function(){
			role += parseInt($(this).val());
		});
		var am_name = $('#am_name').val();
		var am_group = $('#am_group').val();
		$.post(
			'/admin/add',
			{ am_account: am_account, am_password: am_password, am_role: role, am_name: am_name, am_group: am_group},
			function(data){
				if(data.code == 1){
					location.reload();
				}else{
					alert(data.error);
				}
			},
			'json'
		);
	});
	//变更管理员权限
	$('#am_list').on('click', 'input[name="am_role"]', function(){
		if($(this)[0].checked){
			var op = 1;
		}else{
			var op = 0;
		}
		var account = $(this).parents('tr').find('td:eq(0)').text();
		var role = $(this).val();
		$.post(
			'/admin/changeRole',
			{am_account: account, role: role, op: op},
			function(data){
				if(data.code == 1){
					location.reload();
				}else{
					alert(data.error);
				}
			},
			'json'
		);
	});
	/*重置密码框*/
	$('#am_list').on('click', '.cp_box', function(e){
		$('#cp_box').css('top', e.pageY-28).css('left', e.pageX-280).show();
		var account = $(this).parents('tr').find('td:eq(0)').text();
		$('#cp_box').on('click', 'button', function(){
			var indexNum = $('#cp_box button').index(this);
			var input = $('#cp_box').find('input');
			if(indexNum == 0){
				if(input.val() == ''){
					alert('请填写密码.');
					input.focus();
					return;
				}
				updateAdmin(account, 'am_password', input.val());
			}
			input.val('');
			$('#cp_box').off().hide();
		});
	});
	/*设置管理员状态*/
	$('#am_list').on('click', '.change_status', function(){
		var account = $(this).parents('tr').find('td:eq(0)').text();
		var status = $(this).attr('data-val');
		if(status == '0'){
			$(this).removeClass('btn-warning').addClass('btn-success').attr('data-val', '1').text('启用');
		}else{
			$(this).removeClass('btn-success').addClass('btn-warning').attr('data-val', '0').text('冻结');
		}
		updateAdmin(account, 'am_status', status);
	});
	//设置姓名
	$('#am_list').on('click', '.set_name', function(){
		var account = $(this).parents('tr').find('td:eq(0)').text();
		var td = $(this).parent();
		var ov = $(this).text();
		var input = td.html('<input type="text" value="'+ov+'" style="width:80px;">').find('input');
		input.focus();
		input.one('blur', function(){
			var nv = $(this).val();
			if(nv != '' && nv != ov){
				ov = nv;
				updateAdmin(account, 'am_name', nv);
			}
			td.html('<a href="javascript:;" class="set_name">'+ov+'</a>');
		});
	});
	//设置部门
	$('#am_list').on('change', '.set_group', function(){
		var account = $(this).parents('tr').find('td:eq(0)').text();
		updateAdmin(account, 'am_group', $(this).val());
	});
	/*删除管理员*/
	$('#am_list').on('click', '.delete_account', function(){
		if(confirm('确定要删除该管理员账号吗？')){
			var tr = $(this).parents('tr');
			var account = tr.find('td:eq(0)').text();
			$.post(
				'/admin/delete',
				{account: account},
				function(data){
					if(data.code == 1){
						tr.remove();
					}else{
						alert(data.error);
					}
				},
				'json'
			);
		}
	});
	//修改管理员信息
	function updateAdmin(account, field, value){
		$.post('/admin/update', {account: account, field: field, value: value}, function(data){
			if(data.code != 1){
				alert(data.error);
			}
		}, 'json');
	}
});
</script>
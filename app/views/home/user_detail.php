<div class="container">
	<div class="row">
		<div class="col-md-3">
			<legend>用户照片</legend>
			<label>用户头像：</label>
			<?php if ($user->user_avatar == '') { ?>
			<img src="/app/statics/files/images/default.jpg" class="img-responsive" id="user_avatar">
			<?php } else { ?>
			<img src="/nfs/image<?php echo $user->user_avatar; ?>" class="img-responsive" id="user_avatar">
			<?php } ?>
			<div id="upload_image" style="position:relative;margin-top:10px;">
				<input id="fileImage" type="file" style="position:absolute;left:0;filter:alpha(opacity=0);opacity:0;width:83px;height:30px;" name="file_name">
				<button type="button" class="btn btn-sm btn-grew">
					<span class="glyphicon glyphicon-picture"></span> 修改头像
				</button>
			</div>
		</div>
		<div class="col-md-5">
			<legend>身份信息</legend>
			<p>
				<label>电话：</label>
				<input type="text" class="form-control update_user" data-val="user_phone" value="<?php echo $user->user_phone; ?>">
			</p>
			<p>
				<label>邮箱：</label>
				<input type="text" class="form-control update_user" data-val="user_email" value="<?php echo $user->user_email; ?>">
			</p>
			<p>
				<label>密码：</label><small><a id="reset_password" href="javascript:;">修改密码</a></small>
				<input type="text" class="form-control" id="user_password">
			</p>
			<p>
				<label>姓名：</label>
				<input type="text" class="form-control update_user" data-val="user_name" value="<?php echo $user->user_name; ?>">
			</p>
			<p>
				<label>性别：</label><br>
				<input type="radio" name="user_gender" value="0" <?php if ($user->user_gender == 0) echo 'checked'; ?>> 未知
				<input type="radio" name="user_gender" value="1" <?php if ($user->user_gender == 1) echo 'checked'; ?>> 男
				<input type="radio" name="user_gender" value="2" <?php if ($user->user_gender == 2) echo 'checked'; ?>> 女
			</p>
			<p>
				<label>备注：</label>
				<textarea class="form-control update_user" data-val="user_note"><?php echo $user->user_note; ?></textarea>
			</p>
		</div>
		<div class="col-md-4">
			<legend>登录信息</legend>
			<p>
				<label>首次创建时间：</label><br><?php echo date('Y-m-d H:i', $user->user_ctime); ?>
			</p>
			<p>
				<label>最后登录时间：</label><br><?php echo date('Y-m-d H:i', $user->user_ltime); ?>
			</p>
			<p>
				<label>登录IP地址：</label><br><?php echo $user->user_ip; ?>
			</p>
			<p>
				<label>版本号：</label><br><?php echo $user->user_version; ?>
			</p>
			<p>
				<label>设备/终端：</label><br><?php echo $user->user_device; ?>
			</p>
			<p>
				<label>设备ID：</label>
				<textarea class="form-control" disabled><?php echo $user->user_devid; ?></textarea>
			</p>
		</div>
	</div>
</div>
<script type="text/javascript" src="/app/statics/home/js/ajaxfileupload.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	//插入图片
	$('#upload_image').on('change', '#fileImage', function(){
		$.ajaxFileUpload({
			url:'/nfs/upload',
			fileElementId:'fileImage',
			dataType: 'json',
			success: function (data, status){
				var path = data.src;
				if(path != ''){
					$('#user_avatar').attr('src', '/nfs/image/'+path);
					setInfo('user_avatar', path);
				}else{
					if(data.error != '')alert(data.error);
				}
			}
		});
	});
	//重置用户密码
	$('#reset_password').on('click', function(){
		var password = $('#user_password').val();
		if(password == '') {
			alert('请填写密码');$('#user_password').focus();return;
		}
		if(confirm('确定要重置用户密码吗？')) {
			setInfo('user_password', password);
		}
	});
	//修改性别
	$('input[name="user_gender"]').on('change', function(){
		var gender = $(this).val();
		setInfo('user_gender', gender);
	});
	//修改用户信息
	$('.update_user').on('focus', function(){
		var field = $(this).attr('data-val');
		var ov = $(this).val();
		$(this).one('blur', function(){
			var nv = $(this).val();
			if(nv != '' && nv != ov) {
				setInfo(field, nv);
				ov = nv;
			}
			$(this).val(ov);
		});
	});
	function setInfo(field, value) {
		$.post(
			'/user/setInfo',
			{user_id: '<?php echo $user->user_id; ?>', field: field, value: value},
			function(data) {
				if(data.code != 1)
					alert(data.error);
			},
			'json'
			);
	}
});
</script>
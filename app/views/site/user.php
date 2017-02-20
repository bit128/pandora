<div class="container">

    <div class="row">

        <div class="col-sm-3"><?php include '_nav.php'; ?></div>
        <div class="col-sm-1"></div>
        <div class="col-sm-4">
            <div style="padding:20px 0 20px;">
                <h2 class="blog-post-title">个人中心</h2>
                <p class="blog-post-meta">管理您的个人信息</p>

                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">形象管理</a></li>
                    <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">个人信息</a></li>
                    <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">密码安全</a></li>
                </ul>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="home">
                        <p>&nbsp;</p>
                        <h4>上传自定义个性头像</h4>
                        <p>
                            <?php if ($users->user_avatar == '') { ?>
                            <img src="/app/statics/files/default.jpg" class="img-responsive img-thumbnail" style="max-width:200px;" id="user_avatar_show">
                            <?php } else { ?>
                            <img src="/nfs/image<?php echo $users->user_avatar; ?>" class="img-responsive img-thumbnail" style="max-width:200px;" id="user_avatar_show">
                            <?php } ?>
                        </p>
                        <p id="accept_image" style="display:none;">
                            <button type="button" class="btn btn-success btn-sm">确认</button>
                            <button type="button" class="btn btn-warning btn-sm">取消</button>
                        </p>
                        <p id="upload_avatar">
                            <input id="fileAvatar" type="file" style="position: absolute;filter: alpha(opacity=0);opacity:0;width: 100px" name="file_name">
                            <button class="btn btn-info" type="button">
                                <span class="glyphicon glyphicon-camera"></span> 设置照片
                            </button>
                            <input id="user_avatar" type="hidden" value="">
                        </p>
                        <p>&nbsp;</p>
                        <h4>or 选择一个默认头像</h4>
                        <div id="default_avatar">
                            <a href="javascript:;"><img src="/app/statics/files/avatar1.jpg" style="max-width:80px;" class="img-thumbnail"></a>
                            <a href="javascript:;"><img src="/app/statics/files/avatar2.jpg" style="max-width:80px;" class="img-thumbnail"></a>
                            <a href="javascript:;"><img src="/app/statics/files/avatar3.jpg" style="max-width:80px;" class="img-thumbnail"></a>
                            <a href="javascript:;"><img src="/app/statics/files/avatar4.jpg" style="max-width:80px;" class="img-thumbnail"></a>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="profile">
                        <p>
                            <label>账号：</label><br>
                            <strong class="text-info"><?php echo $users->user_email;?></strong>
                        </p>
                        <p>
                            <label>姓名：</label>
                            <input type="text" class="form-control" value="<?php echo $users->user_name;?>" id="set_username">
                        </p>
                        <p>
                            <label>性别：</label>
                            <?php if ($users->user_gender == 0 ) { ?>
                            <input type="radio" value="1" name="user_gender"> 先生
                            <input type="radio" value="2" name="user_gender"> 女士
                            <?php } else { echo $users->user_gender == 1 ? '先生' : '女士';} ?>
                        </p>
                        <p>
                            <label>自我介绍：</label>
                            <textarea class="form-control" rows="4" id="set_usernote"><?php echo $users->user_note;?></textarea>
                        </p>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="messages">
                        <p>&nbsp;</p>
                        <p>
                            <label>输入原密码：</label>
                            <input type="password" class="form-control" id="old_password">
                        </p>
                        <p>
                            <label>输入要变更的新密码：</label>
                            <small><a href="javascript:;" id="op_password" data-val="1">显示密码</a></small>
                            <input type="password" class="form-control" id="new_password">
                        </p>
                        <p>
                            <button type="button" class="btn btn-info" id="change_password">
                                <span class=" glyphicon glyphicon-repeat"></span> 修改密码
                            </button>
                        </p>
                    </div>
                </div>
                
            </div>
        </div>

    </div>

</div>
<script type="text/javascript" src="/app/statics/home/js/ajaxfileupload.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    var user_id = '<?php echo \core\Autumn::app()->request->getSession('user_id')?>';
	var token = '<?php echo \core\Autumn::app()->request->getSession('token');?>';
    //修改姓名
	$('#set_username').on('focus', function(){
		var input = $(this);
		var ov = input.val();
		input.one('blur', function(){
			var nv = input.val();
			if(nv != '' && nv != ov) {
				$.post('/user/setName', {
					user_id: user_id, token: token, user_name: nv
				});
				ov = nv;
			}
			input.val(ov);
		});
	});
	//修改签名
	$('#set_usernote').on('blur', function(){
		$.post('/user/setNote', {
			user_id: user_id, token: token, user_note: $(this).val()
		});
	});
	//设置用户性别
	$('input[name="user_gender"]').on('click', function(){
		if(confirm('性别只能修改一次，确定要修改吗？')){
            $.post('/user/setGender', {
                user_id: user_id, token: token, user_gender: $(this).val()
            });
		}
	});
	//默认修改头像
	$('#default_avatar').on('click', 'a', function(){
		if(confirm('确定使用个性头像吗？')){
			var idx = $('#default_avatar a').index(this);
			var avatar = '/app/statics/files/avatar' + (idx+1) + '.jpg'
			$('#user_avatar_show').attr('src', '/nfs/image'+avatar+'@150');
			$.ajax({
				type: 'POST',
				url: '/user/setAvatar',
				data: {user_id: user_id, token: token, user_avatar: avatar}
			});
		}
	});
	//自定义修改头像
	$('#upload_avatar').on('change', '#fileAvatar', function(){
		$.ajaxFileUpload({
			url:'/nfs/upload',
			fileElementId:'fileAvatar',
			dataType: 'json',
			success: function (data, status){
				var path = data.uri;
				if(path != ''){
					$('#user_avatar_show').attr('src', '/nfs/image' + path);
					$('#user_avatar').val(path);
					$('#accept_image').show();
				}else{
					if(data.error != '')alert(data.error);
				}
			}
		});
	});
	//保存头像
	$('#accept_image').on('click', 'button', function(){
		var i = $('#accept_image button').index(this);
		if(i == 0) {
			$.ajax({
				type: 'POST',
				url: '/user/setAvatar',
				data: {user_id: user_id, token: token, user_avatar: $('#user_avatar').val()}
			});
			$('#user_avatar').val('');
		}
		$('#accept_image').hide();
	});
	//修改密码
	$('#change_password').on('click', function(){
		var old_password = $('#old_password').val();
		if(old_password == ''){alert('请填写原始密码.');$('#old_password').focus();return;}
		var new_password = $('#new_password').val();
		if(new_password == ''){alert('请填写新密码.');$('#new_password').focus();return;}
		$.ajax({
			type: 'POST',
			url: '/user/changePassword',
			data: {user_id: user_id, token: token, old_password: old_password, new_password: new_password},
			success: function(data){
				if(data.code == 1){
					alert('密码变更成功！');
                    location.reload();
				}else{
					alert(data.error);
				}
			}
		});
	});
    $('#op_password').on('click', function(){
        var op = $(this).attr('data-val');
        var pd = $('#new_password').val();
        $('#new_password').remove();
        if (op == '1'){
            $(this).attr('data-val', 0).text('隐藏密码');
            $(this).parent().append('<input type="text" class="form-control" id="new_password" value="'+pd+'">')
        }else{
            $(this).attr('data-val', 1).text('显示密码');
            $(this).parent().append('<input type="password" class="form-control" id="new_password" value="'+pd+'">')
        }
    });
});
</script>
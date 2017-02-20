<div class="container">

    <div class="row">

        <div class="col-sm-3"><?php include '_nav.php'; ?></div>
        <div class="col-sm-2"></div>
        <div class="col-sm-4">
            <div style="padding:60px 0 60px;">
                <h2 class="blog-post-title">注册1doc</h2>
                <p class="blog-post-meta">注册后，可以收藏课程和对课程提问</p>
                <form action="/site/userCache" method="POST" id="register_form">
                    <p>
                        <label>登录账号：</label>
                        <small class="text-danger" id="account_error"></small>
                        <input type="text" class="form-control" name="account" id="account">
                    </p>
                    <p>
                        <label>密码：</label>
                        <small class="text-danger" id="password_error"></small>
                        <small><a href="javascript:;" id="op_password" data-val="1">显示密码</a></small>
                        <input type="password" class="form-control" name="password" id="password">
                    </p>
                    <p>
                        <label>名字：</label>
                        <small class="text-danger" id="user_name_error"></small>
                        <input type="text" class="form-control" name="user_name" id="user_name">
                    </p>
                    <p>
                        <input type="checkbox" value="1" id="agree_protocol"> 我同意<a href="#">注册协议</a>
                        <small class="text-danger" id="agree_protocol_error"></small>
                    </p>
                    <p>
                        <input type="hidden" value="register" name="type">
                        <button type="submit" class="btn btn-info">立即注册</button> or
                        <a href="/site/loginPage" class="btn btn-sm btn-default"> 去登录</a>
                    </p>
                </form>
            </div>
        </div>

    </div>

</div>
<script type="text/javascript">
$(document).ready(function(){
    $('#register_form').on('submit', function(){
        if ($('#account').val().length < 5) {
            $('#account_error').text('账号至少需要5个以上的字符');
            $('#account').focus();
            return false;
        }else{
            $('#account_error').text('');
        }
        if ($('#password').val().length < 6) {
            $('#password_error').text('密码长度至少需要6位');
            $('#password').focus();
            return false;
        }else{
            $('#password_error').text('');
        }
        if ($('#user_name').val() == '') {
            $('#user_name_error').text('至少得让大家知道怎样称呼您');
            $('#user_name').focus();
            return false;
        }else{
            $('#user_name_error').text('');
        }
        if (! $('#agree_protocol').is(':checked')) {
            $('#agree_protocol_error').text('您得过目注册协议并愿意遵守');
            $('#agree_protocol').focus();
            return false;
        }else{
            $('#agree_protocol_error').text('');
        }
    });
    $('#op_password').on('click', function(){
        var op = $(this).attr('data-val');
        var pd = $('#password').val();
        $('#password').remove();
        if (op == '1'){
            $(this).attr('data-val', 0).text('隐藏密码');
            $(this).parent().append('<input type="text" class="form-control" name="password" id="password" value="'+pd+'">')
        }else{
            $(this).attr('data-val', 1).text('显示密码');
            $(this).parent().append('<input type="password" class="form-control" name="password" id="password" value="'+pd+'">')
        }
    });
});
</script>
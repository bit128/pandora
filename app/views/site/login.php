<div class="container">

    <div class="row">

        <div class="col-sm-3"><?php include '_nav.php'; ?></div>
        <div class="col-sm-2"></div>
        <div class="col-sm-4">
            <div style="padding:60px 0 60px;">
                <h2 class="blog-post-title">登录1doc</h2>
                <p class="blog-post-meta">登录后，可以收藏课程和对课程提问</p>
                <form action="/site/userCache" method="POST" id="login_form">
                    <p>
                        <label>登录账号：</label>
                        <small class="text-danger" id="account_error"></small>
                        <input type="text" class="form-control" name="account" id="account">
                    </p>
                    <p>
                        <label>密码：</label>
                        <small class="text-danger" id="password_error"></small>
                        <input type="password" class="form-control" name="password" id="password">
                    </p>
                    <p>
                        <input type="checkbox" value="1" name="long_login" checked> 记住登录状态15天
                    </p>
                    <p>
                        <input type="hidden" name="type" value="login">
                        <button type="submit" class="btn btn-info">立即登录</button> or
                        <a href="/site/registerPage" class="btn btn-sm btn-default"> 去注册</a>
                    </p>
                </form>
            </div>
        </div>

    </div>

</div>
<script type="text/javascript">
$(document).ready(function(){
    $('#login_form').on('submit', function(){
        if ($('#account').val().length < 5) {
            $('#account_error').text('请填写账号');
            $('#account').focus();
            return false;
        }else{
            $('#account_error').text('');
        }
        if ($('#password').val().length < 6) {
            $('#password_error').text('请填写密码');
            $('#password').focus();
            return false;
        }else{
            $('#password_error').text('');
        }
    });
});
</script>
<!--login-area-->
<div class="container">
  <div class="row">
    
    <div class="col-md-6  col-md-offset-3">
          <h1 class="f20"><i class="fa fa-user"></i> 新用户注册</h1>
          <p>请输入您注册时使用的手机号码登录</p>
      <form method="post" id="user_register">
          <div class="form-group"> 
            <label class="control-label" for="inputError1"></label>
            <label class="sr-only">手机号码</label>
            <input type="phone" class="form-control input-lg" placeholder="手机号码" name="user_phone" id="user_phone">
          </div>
          <div class="form-group"> 
            <label class="control-label" for="inputError1"></label>
            <label class="sr-only">手机号码</label>
            <input type="text" class="form-control input-lg" placeholder="姓名" name="user_name" id="user_name">
          </div>
          <div class="form-group">
            <label class="control-label" for="inputError1"></label>
            <label class="sr-only">密码</label>
            <input type="password" class="form-control input-lg" placeholder="密码" name="user_password" id="user_password">
          </div>
           <div class="form-group">
            <label class="control-label" for="inputError1"></label>
            <label class="sr-only">确认密码</label>
            <input type="password" class="form-control input-lg" placeholder="确认密码" id="confirm_password">
          </div>
          <div class="form-group"> 
            <label class="control-label" for="inputError1">请输入短信验证码</label>
            <div class="input-group">
              <input type="text" class="form-control input-lg" placeholder="手机短信验证码">
              <span class="input-group-addon"><a href="javascript;:">获取短信验证码</a></span> </div>
          </div>
          <div class="checkbox">
            <label>
              <input type="checkbox" name="agree_protocol">
              我已阅读并同意 <a href="help-agreement.html" class="text-warning">会员注册协议</a> 和 <a href="help-privacy.html" class="text-warning">隐私保护政策</a> </label>
          </div>
          <button type="submit" class="btn btn-default btn-block btn-lg">注册</button>
      </form>
        <p class="pt20 f14 text-center">已有账户<a href="/site/login" class="text-warning"><strong>立即登录</strong></a></p>
    </div>
    
  </div>
</div>
<!--login-area end-->
<script type="text/javascript">
$(document).ready(function(){
  $('#user_register').on('submit', function(){
    var user_phone = $('#user_phone');
    if(user_phone.val() == ''){
      user_phone.parent().addClass('has-error');
      user_phone.parent().find('.control-label').text('我们需要您的手机号码').show();
      return false;
    }else if (! /^[0-9\-]{11,14}$/.test(user_phone.val())){
      user_phone.parent().addClass('has-error');
      user_phone.parent().find('.control-label').text('手机号码格式不正确').show();
      return false;
    }else{
      user_phone.parent().removeClass('has-error');
      user_phone.parent().find('.control-label').hide();
    }

    var user_name = $('#user_name');
    if(user_name.val() == ''){
      user_name.parent().addClass('has-error');
      user_name.parent().find('.control-label').text('我们需要您的名字').show();
      return false;
    }else{
      user_name.parent().removeClass('has-error');
      user_name.parent().find('.control-label').hide();
    }

    var user_password = $('#user_password');
    if(user_password.val() == ''){
      user_password.parent().addClass('has-error');
      user_password.parent().find('.control-label').text('需要填写密码').show();
      return false;
    }else{
      user_password.parent().removeClass('has-error');
      user_password.parent().find('.control-label').hide();
    }

    var confirm_password = $('#confirm_password');
    if(confirm_password.val() != $('#user_password').val()){
      confirm_password.parent().addClass('has-error');
      confirm_password.parent().find('.control-label').text('两次密码输入不一致').show();
      return false;
    }else{
      confirm_password.parent().removeClass('has-error');
      confirm_password.parent().find('.control-label').hide();
    }
    return $('input[name="agree_protocol"]').is(':checked');
  });
});
</script>
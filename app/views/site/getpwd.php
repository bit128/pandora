<!--login-area-->
<div class="container">
  <div class="row">
    <div class="col-md-6  col-md-offset-3">
        <div class="pb10 pt10">
          <h1 class="f20"><i class="fa fa-lock"></i> 找回密码</h1>
          <p>请输入您注册时的手机号码，重置密码将会发到您的手机上，请尽快使用登陆，并修改密码！</p>
        </div>
        <form>
          <div class="form-group has-error"> 
            <label class="control-label" for="inputError1">请输入您的手机号</label>
            <label class="sr-only">手机号码</label>
            <input type="phone" class="form-control input-lg" placeholder="手机号码">
          </div>
          <div class="form-group  has-error"> 
            <label class="control-label" for="inputError1">请输入右图正确的验证码</label>
            <div class="input-group">
              <input type="text" class="form-control input-lg" placeholder="验证码">
              <span class="input-group-addon"><img src="img/vcode.png" /> <a href="javascript;:">换一张</a></span> </div>
          </div>
           <div class="form-group has-error"> 
            <label class="control-label" for="inputError1">请输入短信验证码</label>
            <div class="input-group">
              <input type="text" class="form-control input-lg" placeholder="手机短信验证码">
              <span class="input-group-addon"><a href="javascript;:">获取短信验证码 </a>  <!--已发送 60 秒后重新获取--></span> </div>
          </div>
          <button type="submit" class="btn btn-default btn-block btn-lg">找回密码</button>
        </form>
        <p class="pt20">想起来了，<a href="/site/login" class="text-warning"><strong>去登录</strong></a></p>
      </div>
  </div>
</div>
<!--login-area end-->
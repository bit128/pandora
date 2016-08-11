<!--login-area-->
<div class="container">
  <div class="row">
    
    <div class="col-md-6  col-md-offset-3">
       
          <h1 class="f20"><i class="fa fa-user"></i> 新用户注册</h1>
          <p>请输入您注册时使用的手机号码登录</p>
    <form>
          <div class="form-group has-error"> 
            <label class="control-label" for="inputError1">请输入您的手机号</label>
            <label class="sr-only">手机号码</label>
            <input type="phone" class="form-control input-lg" placeholder="手机号码">
          </div>
          <div class="form-group"> 
            <!--<label class="control-label" for="inputError1">请输入右图正确的验证码</label>-->
            <div class="input-group">
              <input type="text" class="form-control input-lg" placeholder="验证码">
              <span class="input-group-addon"><img src="img/vcode.png" /> <a href="javascript;:">换一张</a></span> </div>
          </div>
        <div class="form-group">
          <!--<label class="control-label" for="inputError1">请输入密码</label>-->
            <label class="sr-only">密码</label>
            <input type="password" class="form-control input-lg" placeholder="密码">
          </div>
           <div class="form-group">
            <!--<label class="control-label" for="inputError1">密码与确认密码不相符，请重新填写</label>-->
            <label class="sr-only">确认密码</label>
            <input type="password" class="form-control input-lg" placeholder="确认密码">
          </div>
        <div class="form-group"> 
            <!--<label class="control-label" for="inputError1">请输入短信验证码</label>-->
            <div class="input-group">
              <input type="text" class="form-control input-lg" placeholder="手机短信验证码">
              <span class="input-group-addon"><a href="javascript;:">获取短信验证码 已发送 60 秒后重新获取</a>  <!--已发送 60 秒后重新获取--></span> </div>
          </div>
          <div class="checkbox">
            <label>
              <input type="checkbox">
              我已阅读并同意 <a href="help-agreement.html" class="text-warning">会员注册协议</a> 和 <a href="help-privacy.html" class="text-warning">隐私保护政策</a> </label>
      </div>
          <button type="submit" class="btn btn-default btn-block btn-lg">注册</button>
        </form>
        <p class="pt20 f14 text-center">已有账户<a href="/site/login" class="text-warning"><strong>立即登录</strong></a></p>
        
    </div>
    
  </div>
</div>
<!--login-area end-->
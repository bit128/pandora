<!--login-area-->
<div class="container">
  <div class="row">
    <div class="col-md-6  col-md-offset-3">
       
          <h1 class="f20"><i class="fa fa-user"></i> 用户登录 </h1>
          <p>请输入您注册时使用的手机号码登录</p>
    
        <form>
          <div class="form-group">
            <label class="sr-only">手机号码</label>
            <input type="phone" class="form-control input-lg" placeholder="手机号码">
          </div>
          <div class="form-group">
            <label class="sr-only">密码</label>
            <input type="password" class="form-control input-lg" placeholder="密码">
          </div>
          <div class="input-group">
            <input type="text" class="form-control input-lg" placeholder="验证码">
            <span class="input-group-addon"><img src="img/vcode.png" /> <a href="javascript;:">换一张</a></span> </div>
          <div class="checkbox">
            <label>
              <input type="checkbox">
              记住账号 </label>
          </div>
          <div class="alert alert-danger" role="alert">手机号码或密码错误</div>
          <button type="submit" class="btn btn-default btn-block btn-lg">登录</button>
        </form>
        <p class="pt20">您还没注册有成为会员？<a href="/site/register" class="text-warning"><strong>立即注册</strong></a> 或 <a href="/site/getpwd" class="text-warning"><strong>忘记密码</strong></a>？</p>
    </div>
  </div>
</div>
<!--login-area end-->
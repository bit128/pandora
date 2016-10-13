<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>登录 Pandora</title>

    <!-- Bootstrap core CSS -->
    <link href="/app/statics/home/css/bootstrap.min.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy this line! -->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    <script type="text/javascript" src="/app/statics/home/js/jquery-1.10.2.min.js"></script>
    <style type="text/css">
    body {
      padding-top: 40px;
      padding-bottom: 40px;
      background-color: #eee;
    }
    .form-signin {
      max-width: 330px;
      padding: 15px;
      margin: 0 auto;
    }
    .form-signin .form-signin-heading,
    .form-signin .checkbox {
      margin-bottom: 10px;
    }
    .form-signin .checkbox {
      font-weight: normal;
    }
    .form-signin .form-control {
      position: relative;
      font-size: 16px;
      height: auto;
      padding: 10px;
      -webkit-box-sizing: border-box;
         -moz-box-sizing: border-box;
              box-sizing: border-box;
    }
    .form-signin .form-control:focus {
      z-index: 2;
    }
    </style>
  </head>

  <body>

    <div class="container">

      <form class="form-signin" role="form" id="login_form" method="post" action="/admin/login">
        <h2 class="form-signin-heading">登录 Pandora.</h2>
        <p>
          <label>账号：</label>
          <input type="text" class="form-control" placeholder="账号" id="user_account" name="account" required>
        </p>
        <p>
          <label>密码：</label>
          <input type="password" class="form-control" placeholder="密码" id="user_password" name="password" required>
        </p>
        <p>
          <a href="javascript:;"><span class="glyphicon glyphicon-send"></span> 忘记账号或密码？</a>
        </p>
        <!--
        <label class="checkbox">
          <input type="checkbox" value="remember-me"> Remember me
        </label>-->
        <button class="btn btn-lg btn-primary btn-block" type="submit">登录</button>
      </form>

    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
  </body>
  <script type="text/javascript">
  $(document).ready(function(){
    $('#login_form').on('submit', function(){
      var account = $('#user_account').val();
      if(account == ''){alert('请填写账号.');$('#user_account').focus();return false;}
      var password = $('#user_password').val();
      if(password == ''){alert('请填写密码.');$('#user_password').focus();return false;}
    });
  });
  </script>
</html>
<!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Pandora</title>

    <!-- Bootstrap core CSS -->
    <link href="/app/statics/home/css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="//cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="//cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style type="text/css">
    /* Sticky footer styles
  	-------------------------------------------------- */
  	html {
  	  position: relative;
  	  min-height: 100%;
  	}
  	body {
  	  /* Margin bottom by footer height */
  	  margin-bottom: 60px;
  	}
  	.footer {
  	  position: absolute;
  	  bottom: 0;
  	  width: 100%;
  	  /* Set the fixed height of the footer here */
  	  height: 60px;
  	  background-color: #f5f5f5;
  	}
  	/* Custom page CSS*/
  	body > .container {
  	  padding: 60px 15px 0;
  	}
  	.container .text-muted {
  	  margin: 20px 0;
  	}
  	.footer > .container {
  	  padding-right: 15px;
  	  padding-left: 15px;
  	}
  	code {
  	  font-size: 80%;
  	}
    </style>
    <script type="text/javascript" src="/app/statics/home/js/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="/app/statics/home/js/bootstrap.min.js"></script>
  </head>

  <body>

    <!-- Fixed navbar -->
    <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#"><?php echo \core\Autumn::app()->config('app_name'); ?></a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="/home">控制台</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">用户（<?php echo \core\Request::inst()->getSession('am_name', '未登录'); ?>） <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="/admin/logout">安全退出</a></li>
              </ul>
            </li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <?php echo $content; ?>

    <footer class="footer">
      <div class="container">
        <p class="text-muted">&copy <?php echo \core\Autumn::app()->config('app_name'); ?> 2013-2016 版权所有 
          <small>[ 当前版本：<?php echo \core\Autumn::app()->config('version'); ?> ]</small></p>
      </div>
    </footer>
  </body>
</html>
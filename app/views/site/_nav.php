<div class="sidebar-module sidebar-module-inset" style="text-align:center;">
    <a href="/"><img src="/app/statics/site/logo.png" style="max-width:200px;margin-bottom:26px;"></a>
    <h4>程序员手稿</h4>
    <p>十年铸剑百味尝，千篇码文万丝霜</p>
    <hr>
    <?php if (\core\Autumn::app()->request->getSession('user_id')) { ?>
    <p>
        欢迎您：<a href="/site/user"><?php echo \core\Autumn::app()->request->getSession('user_name'); ?></a>,
        <small><a href="/site/logout">安全退出</a></small>
        <br>
    </p>
    <p>
        <a href="/site/collect" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-heart"></span> 收藏</a>
        <a href="/site/question" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-comment"></span> 提问</a>
    </p>
    <?php } else { ?>
    <p>
        <a href="/site/registerPage" class="btn btn-sm btn-default">注册</a> or
        <a href="/site/loginPage" class="btn btn-sm btn-default">登录</a>
    </p>
    <?php } ?>
</div>
<!--
<div class="sidebar-module">
    <h4>热门</h4>
    <a href="#">Java开发</a>
    <a href="#">PHP开发</a>
    <a href="#">Android开发</a>
    <a href="#">Linux运维</a>
    <a href="#">Python开发</a>
    <a href="#">数据库</a>
</div>-->
<!--main-area-->
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <ol class="breadcrumb">
        <li><a href="index.html">首页</a></li>
        <li><a href="list.html">商品分类名</a></li>
        <li class="active">咕噜家秘制红辣羊排</li>
      </ol>
    </div>
    <div class="col-md-12">
      <h3 class="mt10">澳门玛嘉烈葡式蛋挞</h3>
    </div>
  </div>
  
  <!--图片秀和商品选择按钮-->
  <div class="row mt20">
    <div class="col-md-6"> 
      
      <!-- 图片秀开始 -->
      <div class="muv clearfix"> 
        <script src="/app/statics/site/js/jquery.etalage.min.js"></script> 
        <script type="text/javascript">
            $(document).ready(function($){
            $('#itembox').etalage({
            thumb_image_width: 380,
            thumb_image_height: 380,
            source_image_width: 800,
            source_image_height: 800,
            zoom_area_width: 380,
            zoom_area_height: 380,
            zoom_area_distance: 10,
            small_thumbs: 4,
            smallthumb_inactive_opacity: 0.5,
            smallthumbs_position: 'left',
            speed: 400,
            autoplay: true,
            keyboard: false,
            zoom_easing: false
            });

            });
        </script>
        <link type="text/css" rel="stylesheet" href="/app/statics/site/css/itembox.css">
        <ul id="itembox" class="list-unstyled ">
          <li> <img class="etalage_thumb_image" src="/app/statics/site/img/item/img01.jpg" /> <img class="etalage_source_image" src="/app/statics/site/img/item/img01.jpg" /> </li>
          <li> <img class="etalage_thumb_image" src="/app/statics/site/img/item/img02.jpg" /> <img class="etalage_source_image" src="/app/statics/site/img/item/img02.jpg" /> </li>
          <li> <img class="etalage_thumb_image" src="/app/statics/site/img/item/img03.jpg" /> <img class="etalage_source_image" src="/app/statics/site/img/item/img03.jpg" /> </li>
          <li> <img class="etalage_thumb_image" src="/app/statics/site/img/item/img02.jpg" /> <img class="etalage_source_image" src="/app/statics/site/img/item/img02.jpg" /> </li>
          <li> <img class="etalage_thumb_image" src="/app/statics/site/img/item/img02.jpg" /> <img class="etalage_source_image" src="/app/statics/site/img/item/img02.jpg" /> </li>
        </ul>
      </div>
      <!-- 图片秀结束 -->
      <!--手机版显示产品大预览图--><div class="m-item-pic"><img src="/app/statics/site/img/item/img01.jpg" alt="" class="img-responsive"/></div><!--结束-->
    </div>
    <div class="col-md-6">
      <dl class="dl-horizontal dl-001">
        <dt class="pt15 text-danger">单价：</dt>
        <dd><span class="pricef f30 text-danger">￥3.5</span></dd>
        <dt>口味：</dt>
        <dd>
          <ul class="list-unstyled chooseblock cb01 clearfix">
            <li><a href="javascript:;" class="active"><img src="img/item/img01.jpg" alt="" width="40" height="40" /> <span>原味</span></a> <span class="box-check"></span></li>
            <li><a href="javascript:;"><img src="img/item/img02.jpg" alt="" width="40" height="40"/> <span>黄桃味</span></a> </li>
            <li><a href="javascript:;"><img src="img/item/img03.jpg" alt="" width="40" height="40"/> <span>红豆味</span></a> </li>
          </ul>
        </dd>
        <dt>口味：</dt>
        <dd>
          <ul class="list-unstyled chooseblock cb02 clearfix">
            <li><a href="javascript:;" class="active">原味</a><span class="box-check"></span></li>
            <li><a href="javascript:;">黄桃味</a></li>
            <li><a href="javascript:;">红豆味</a></li>
            <li><a href="javascript:;">S</a></li>
            <li><a href="javascript:;">M</a></li>
            <li><a href="javascript:;">L</a></li>
            <li><a href="javascript:;">XL</a></li>
            <li><a href="javascript:;">黄桃味</a></li>
            <li><a href="javascript:;">红豆味</a></li>
            <li><a href="javascript:;">黄桃味</a></li>
            <li><a href="javascript:;">红豆味</a></li>
            <li><a href="javascript:;">黄桃味</a></li>
            <li><a href="javascript:;">红豆味</a></li>
          </ul>
        </dd>
        <dt>数量：</dt>
        <dd>
          <input type="text" class="spinnerExample"/>
          <script type="text/javascript" src="/app/statics/site/js/jquery.spinner.js"></script> 
          <script type="text/javascript">
              $('.spinnerExample').spinner({});
           </script> 
        </dd>
        <dd><a href="/site/cart" class="btn btn-primary btn-lg mr10">立即购买</a> <a href="/site/cart" class="btn btn-default btn-lg">加入购物车</a> </dd>
        <dd><a href="javascript:;"><i class="fa fa-heart"></i> 收藏商品</a></dd>
      </dl>
    </div>
  </div>
  
  <!--详情开始-->
  <div class="row mt25">
    <div class="col-md-12">
     <div class=" t-line01"><h5>产品描述</h5></div>
    </div>
  </div>
</div>
<!--main-area end-->
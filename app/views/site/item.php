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
      <h3 class="mt10"><?php echo $product->pd_name; ?></h3>
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
          <?php foreach ($image as $v) { ?>
          <li> <img class="etalage_thumb_image" src="/nfs/image/<?php echo $v; ?>" /> <img class="etalage_source_image" src="/nfs/image/<?php echo $v; ?>" /> </li>
          <?php } ?>
        </ul>
      </div>
      <!-- 图片秀结束 -->
      <!--手机版显示产品大预览图--><div class="m-item-pic"><img src="/nfs/image/<?php echo $product->pd_image; ?>" alt="" class="img-responsive"/></div><!--结束-->
    </div>
    <div class="col-md-6">
      <dl class="dl-horizontal dl-001">
        <dt class="pt15 text-danger">单价：</dt>
        <dd><span class="pricef f30 text-danger" id="price">￥<?php echo $stock->price; ?></span></dd>
        <dt>口味：</dt>
        <dd>
          <ul class="list-unstyled chooseblock cb01 clearfix">
            <?php foreach ($stock->item as $v ) { ?>
            <li>
              <a href="javascript:;" data-price="<?php echo $v->st_price; ?>" data-sizes="<?php echo implode(' ', $v->st_size); ?>" class="stock_item">
                <img src="/nfs/image/<?php echo $v->st_image; ?>" alt="" width="40" height="40" /> <strong><?php echo $v->st_name; ?></strong>
              </a><span class="box-check" style="display:none;"></span>
            </li>
            <?php } ?>
          </ul>
        </dd>
        <dt>规格：</dt>
        <dd>
          <ul class="list-unstyled chooseblock cb02 clearfix" id="stock_sizes">
            <?php foreach ($stock->size as $v) { ?>
            <li><a href="javascript:;"><?php echo $v; ?></a><!--<span class="box-check"></span>--></li>
            <?php } ?>
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
     <div class="t-line01"></div>
     <p>&nbsp;</p>
     <?php echo $detail; ?>
     <p>&nbsp;</p>
    </div>
  </div>
</div>
<!--main-area end-->
<script type="text/javascript">
$(document).ready(function(){
  //选择库存
  $('.stock_item').on('click', function(){
    //样式变化
    $('.stock_item').removeClass('active');
    $(this).addClass('active');
    $(this).parents('ul').find('span').hide();
    $(this).parents('li').find('span').show();
    //价格和规格
    $('#price').text('￥' + $(this).attr('data-price'));
    var html = '';
    $.each($(this).attr('data-sizes').split(' '), function(i, d){
      html += '<li><a href="javascript:;" class="stock_size">' + d + '</a><span class="box-check" style="display:none;"></span></li>'
    });
    $('#stock_sizes').html(html);
  });
  //选择规格
  $('#stock_sizes').on('click', '.stock_size', function(){
    $('.stock_size').removeClass('active');
    $(this).addClass('active');
    $(this).parents('ul').find('span').hide();
    $(this).parents('li').find('span').show();
  });
});
</script>
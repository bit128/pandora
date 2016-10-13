<!--slider-->
<div class="container">
  <div class="row">
    <div class="col-md-8">
      <link rel="stylesheet" href="/app/statics/site/css/slider.css">
      <script src="/app/statics/site/js/flexslider.js"></script>
      <div class="flexslider">
        <ul class="slides">
          <?php foreach ($banner as $v){ ?>
          <li><a href="/site/item/id/<?php echo $v->id; ?>"><img src="/nfs/image/<?php echo $v->src; ?>" alt="" /></a></li>
          <?php } ?>
        </ul>
      </div>
    </div>
    <!--promo01-->
    <div class="col-md-4" >
      <div class="cusbox">
        <?php foreach ($side as $v){ ?>
          <div><a href="/site/item/id/<?php echo $v->id; ?>"><img src="/nfs/image/<?php echo $v->src; ?>" alt="" class="img-responsive" /></a></div>
        <?php } ?>
      </div>
    </div>
    <!--promo01 end--> 
  </div>
</div>

<!--promo02-->
<div class="container">
  <div class="row mt15">
    <div class="col-md-12">
      <h4>今日特价 <small>PROMOTION</small></h4>
    </div>
  </div>
  <div class="row">
    <?php foreach ($promotion as $v) { ?>
    <div class="col-md-6  mt10">
      <div class="media cusbox">
        <div class="media-left"><a href="/site/item/id/<?php echo $v->id; ?>"><img class="media-object" src="/nfs/image/<?php echo $v->src; ?>" style="width:230px;" alt="..."></a></div>
        <div class="media-body p15 pr25 mshow">
          <h3 class="media-heading"><a href="/site/item/id/<?php echo $v->id; ?>"><?php echo $v->name; ?></a></h3>
          <p class="pt10"><?php echo $v->summary; ?></p>
          <p class="pt15 pricef "><span class="f30 text-danger">￥<?php echo $v->total; ?></span> <del class="f14">￥<?php echo $v->price; ?></del></p>
          <p class="pt10"><a class="btn btn-primary" href="/site/item/id/<?php echo $v->id; ?>">限时半价 立即抢购</a></p>
        </div>
      </div>
    </div>
    <?php } ?>
  </div>
</div>
<!--promo02 end--> 

<!--hot products-->
<div class="container">
  <div class="row mt15">
    <div class="col-md-12">
      <h4>热卖推荐 <small>HOT SALES</small></h4>
    </div>
  </div>
  <div class="row mt10">
    <?php foreach ($hot as $v) { ?>
    <div class="col-md-3">
      <div class="thumbnail"> <a href="/site/item/id/<?php echo $v->id; ?>"><img src="/nfs/image/<?php echo $v->src; ?>" alt="..."></a>
        <div class="caption">
          <div class="productinfo clearfix pt10">
            <h3 class="pull-left"><a href="/site/item/id/<?php echo $v->id; ?>"><?php echo $v->name; ?></a></h3>
            <p class=" pull-right text-danger mtb0 pricef">￥<?php echo $v->total; ?></p>
          </div>
        </div>
      </div>
    </div>
    <?php } ?>
  </div>
</div>

<!--blog-->
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <h4>美食博客 <small>BLOG</small></h4>
    </div>
  </div>
  <div class="row">
    <div class="col-md-4  mt10">
      <div class="media cusbox">
        <div class="media-left"><a href="blogpost.html"><img class="media-object" src="/app/statics/site/img/p01.jpg" alt="..." width="120"></a></div>
        <div class="media-body pt10">
          <h5 class="media-heading"><a href="blogpost.html">学做金桔柠檬蜂蜜茶</a> <small class="pricef">01-25</small> </h5>
          <p class="pt10 pr5">生津止渴，维护心血管功能，防止血管硬化、高血压等疾病的食疗保健好饮品。</p>
          <p> <a class="" href="blogpost.html">阅读全文 &rarr;</a></p>
        </div>
      </div>
    </div>
    <div class="col-md-4  mt10">
      <div class="media cusbox">
        <div class="media-left"><a href="blogpost.html"><img class="media-object" src="/app/statics/site/img/p01.jpg" alt="..." width="120"></a></div>
        <div class="media-body pt10">
          <h5 class="media-heading"><a href="blogpost.html">学做金桔柠檬蜂蜜茶</a> <small class="pricef">01-15</small> </h5>
          <p class="pt10 pr5">生津止渴，维护心血管功能，防止血管硬化、高血压等疾病的食疗保健好饮品。</p>
          <p> <a class="" href="blogpost.html">阅读全文 &rarr;</a></p>
        </div>
      </div>
    </div>
    <div class="col-md-4  mt10">
      <div class="media cusbox">
        <div class="media-left"><a href="blogpost.html"><img class="media-object" src="/app/statics/site/img/p01.jpg" alt="..." width="120"></a></div>
        <div class="media-body pt10">
          <h5 class="media-heading"><a href="blogpost.html">学做金桔柠檬蜂蜜茶</a> <small class="pricef">02-03</small> </h5>
          <p class="pt10 pr5">生津止渴，维护心血管功能，防止血管硬化、高血压等疾病的食疗保健好饮品。</p>
          <p> <a class="" href="blogpost.html">阅读全文 &rarr;</a></p>
        </div>
      </div>
    </div>
    <div class="col-md-4  mt10">
      <div class="media cusbox">
        <div class="media-left"><a href="blogpost.html"><img class="media-object" src="/app/statics/site/img/p01.jpg" alt="..." width="120"></a></div>
        <div class="media-body pt10">
          <h5 class="media-heading"><a href="blogpost.html">学做金桔柠檬蜂蜜茶</a> <small class="pricef">01-25</small> </h5>
          <p class="pt10 pr5">生津止渴，维护心血管功能，防止血管硬化、高血压等疾病的食疗保健好饮品。</p>
          <p> <a class="" href="blogpost.html">阅读全文 &rarr;</a></p>
        </div>
      </div>
    </div>
    <div class="col-md-4  mt10">
      <div class="media cusbox">
        <div class="media-left"><a href="blogpost.html"><img class="media-object" src="/app/statics/site/img/p01.jpg" alt="..." width="120"></a></div>
        <div class="media-body pt10">
          <h5 class="media-heading"><a href="blogpost.html">学做金桔柠檬蜂蜜茶</a> <small class="pricef">01-15</small> </h5>
          <p class="pt10 pr5">生津止渴，维护心血管功能，防止血管硬化、高血压等疾病的食疗保健好饮品。</p>
          <p> <a class="" href="blogpost.html">阅读全文 &rarr;</a></p>
        </div>
      </div>
    </div>
    <div class="col-md-4  mt10">
      <div class="media cusbox">
        <div class="media-left"><a href="blogpost.html"><img class="media-object" src="/app/statics/site/img/p01.jpg" alt="..." width="120"></a></div>
        <div class="media-body pt10">
          <h5 class="media-heading"><a href="blogpost.html">学做金桔柠檬蜂蜜茶</a> <small class="pricef">02-03</small> </h5>
          <p class="pt10 pr5">生津止渴，维护心血管功能，防止血管硬化、高血压等疾病的食疗保健好饮品。</p>
          <p> <a class="" href="blogpost.html">阅读全文 &rarr;</a></p>
        </div>
      </div>
    </div>
  </div>
</div>
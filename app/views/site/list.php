<!--mainarea-->
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <ul class="list-unstyled main-list clearfix">
        <li><a href="/site/list" class="active"><span class="ico001"></span> <span>全部</span></a></li>
        <li><a href="/site/list/k/中西主食"><span class="ico002"></span> <span>中西主食</span></a></li>
        <li><a href="/site/list/k/缤纷甜点"><span class="ico003"></span> <span>缤纷甜点</span></a></li>
        <li><a href="/site/list/k/滋味饮品"><span class="ico004"></span> <span>滋味饮品</span></a></li>
        <li><a href="/site/list/k/手工冰淇淋"><span class="ico005"></span> <span>手工冰淇淋</span></a></li>
        <li><a href="/site/list/k/手工曲奇饼"><span class="ico006"></span> <span>手工曲奇饼</span></a></li>
      </ul>
    </div>
  </div>
  <div class="row mt10">
    <?php foreach ($product_list as $v) { ?>
    <div class="col-md-3">
      <div class="thumbnail"> <a href="/site/item/id/<?php echo $v->pd_id; ?>"><img src="/nfs/image/<?php echo $v->pd_image; ?>" alt="..."></a>
        <div class="caption">
          <div class="productinfo clearfix pt10">
            <h3 class="pull-left"><a href="/site/item/id/<?php echo $v->pd_id; ?>"><?php echo $v->pd_name; ?></a></h3>
            <p class=" pull-right text-danger mtb0 pricef">￥<?php echo $v->pd_price; ?></p>
          </div>
        </div>
      </div>
    </div>
    <?php } ?>
    
  </div>
  <div class="row">
    <div class="col-md-12  text-right">
      <?php echo $pages; ?>
    </div>
  </div>
</div>

<!--mainarea end-->
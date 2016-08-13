<!--main-area-->
<div class="container">
  <div class="row"> 
    <!--<div class="col-md-12">
      <ol class="breadcrumb">
        <li><a href="index.html">首页</a></li>
        <li class="active">博客</li>
      </ol>
    </div>-->
    
    <div class="col-md-9">
      <?php foreach ($content_list as $v) { ?>
      <div class="blog-block">
        <h4><a href="/site/blogDetail"><?php echo $v->ct_title; ?></a> <?php if($v->ct_status==2) echo '<span class="label label-danger">荐</span>'; ?></h4>
        <p><span  class="pricef"><?php echo date('Y-m-d H:i', $v->ct_utime); ?></span> <!--<a href="javascript:;"><i class="fa fa-heart"></i> 收藏此文</a>-->  </p>
        <p><a href="/site/blogDetail/id/<?php echo $v->ct_id; ?>"><img src="/nfs/image/<?php echo $v->ct_image; ?>" alt="..." class="img-responsive"></a></p>
        <p><?php echo mb_substr(strip_tags($v->ct_detail), 0, 500, 'utf-8'), '...'; ?></p>
        <p><a href="/site/blogDetail/id/<?php echo $v->ct_id; ?>">阅读全文  &rarr;</a></p>
      </div>
      <?php } ?>
      <div class=" text-right">
        <?php echo $pages; ?>
      </div>
    </div>

    <?php include '_blog_side.php'; ?>

  </div>
</div>
<!--main-area end-->
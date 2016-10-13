<!--main-area-->
<div class="container">
  <div class="row"> 
    <div class="col-md-12">
      <ol class="breadcrumb">
        <li><a href="index.html">首页</a></li>
        <li><a href="blog.html">博客</a></li>
        <li class="active">咕噜家秘制红辣羊排</li>
      </ol>
    </div>
    
    <div class="col-md-9">
      <div class="blog-block">
        <h4><a href="javascript:;"><?php echo $contents->ct_title; ?></a>
          <?php if($contents->ct_status == 2) echo '<span class="label label-danger">荐</span>'; ?>
        </h4>
        <p><span  class="pricef"><?php echo date('Y-m-d H:i', $contents->ct_utime); ?></span> <!--<a href="javascript:;"><i class="fa fa-heart"></i> 收藏此文</a>--> </p>
        <p><a href="javascript:;"><img src="/nfs/image/<?php echo $contents->ct_image; ?>" alt="..." class="img-responsive"></a></p>
        <?php echo $contents->ct_detail; ?>
      </div>
      <p>&nbsp;</p>
      <!--
      <div>
        <ul class="pager">
        <li class="previous "><a href="javascript:;"><span aria-hidden="true">&larr;</span> 上一篇：没有了</a></li>
        <li class="next"><a href="javascript:;">下一篇：学做金桔柠檬茶 <span aria-hidden="true">&rarr;</span></a></li>
      </ul>
      </div>-->
    </div>
    
    <?php include '_blog_side.php'; ?>

  </div>
</div>
<!--main-area end-->
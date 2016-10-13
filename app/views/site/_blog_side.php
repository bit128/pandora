<div class="col-md-3">
  <h4 class=" mt25">博文分类</h4>
  <div class="list-group">
    <a href="/site/blog" class="list-group-item">全部美食</a>
    <?php foreach ($blog_channel['result'] as $v) { ?>
    <a href="/site/blog/cn/<?php echo $v->cn_id; ?>" class="list-group-item"><?php echo $v->cn_name; ?></a>
    <?php } ?>
  </div>
  <h4 class=" mt25">热门博文</h4>
  <?php foreach ($hot_content['result'] as $v) { ?>
    <div class="media cusbox">
      <div class="media-left">
        <a href="/site/blogDetail/id/<?php echo $v->ct_id; ?>">
          <img class="media-object" src="/nfs/image/<?php echo $v->ct_image; ?>" alt="..." width="80">
        </a>
      </div>
      <div class="media-body pt10">
        <h5 class="media-heading"><a href="/site/blogDetail/id/<?php echo $v->ct_id; ?>"><?php echo $v->ct_title;?></a> <small class="pricef">02-03</small> </h5>
        <p class="pt10 pr5"> <a class="" href="/site/blogDetail/id/<?php echo $v->ct_id; ?>">阅读全文 &rarr;</a></p>
      </div>
    </div>
  <?php } ?>
</div>
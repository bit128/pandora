<!--main-area-->
<div class="container">
  <div class="row">
    <div class="col-md-12">
    <!--新闻开始-->
    <ul class="list-unstyled newslist">
      <?php foreach ($content_list as $v) { ?>
        <li>
          <h3><?php echo $v->ct_title; ?> <small><?php echo date('Y-m-d H:i', $v->ct_utime); ?></small></h3>
          <?php echo $v->ct_detail; ?>
        </li>
      <?php } ?>
    </ul>
    
    <div class=" text-right">
        <?php echo $pages; ?>
      </div>
    
    </div>
  </div>
</div>
<!--main-area end-->
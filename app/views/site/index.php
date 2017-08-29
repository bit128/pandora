<div class="container">

    <div class="row">

        <div class="col-sm-3"><?php include '_nav.php'; ?></div>

        <div class="col-sm-9">
            <?php foreach ($main_list as $item) { ?>
            <div class="row">
                <?php if ($item->ct_image != '') { ?>
                <div class="col-md-3">
                    <a href="/site/content/id/<?php echo $item->ct_id; ?>" target="_blank">
                        <img src="/nfs/image<?php echo $item->ct_image; ?>" class="img-responsive" style="margin-top:12px;">
                    </a>
                </div>
                <div class="col-md-9">
                <?php } else { ?>
                <div class="col-md-12">
                <?php } ?>
                    <h2 class="blog-post-title">
                        <a href="/site/content/id/<?php echo $item->ct_id; ?>" style="color:#555;" target="_blank"><?php echo $item->ct_title; ?></a>
                    </h2>
                    <p class="blog-post-meta">
                        <?php echo date('Y年m月d日 H:i, D', $item->ct_ctime); ?>
                    </p>
                    <p><?php echo \core\tools\MbString::substr(strip_tags($item->ct_detail), 0, 150); ?>...</p>
                    <p>
                        <?php
                            foreach ($item->indexs as $v) { echo '<span class="label label-info">',$v->dc_keyword,'</span> '; } 
                        ?>
                    </p>
                    <hr>
                </div>
            </div>
            <?php } ?>
            <p><?php echo $pages; ?></p>

        </div>

    </div>

</div>
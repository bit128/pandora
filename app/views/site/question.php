<div class="container">

    <div class="row">

        <div class="col-sm-3"><?php include '_nav.php'; ?></div>

        <div class="col-sm-8 col-sm-offset-1">
            <h3>我的提问</h3>
            <hr>
            <?php foreach ($note_list as $item) { ?>
            <div style="border-bottom:1px dashed #ccc; margin-bottom:10px;">
                <p>
                    <?php echo date('Y年m月d日 H:i:s D', $item->tn_time); ?>
                    <span class="pull-right" style="font-size:14px;">
                        <span class="glyphicon glyphicon-thumbs-up"></span>(<?php echo $item->tn_great; ?>)
                    </span>
                </p>
                <h4><a href="/site/content/id/<?php echo $item->ct_id; ?>" target="_blank" style="color:#666;">原帖：<?php echo $item->ct_title; ?></a></h4>
                <p style="font-size:13px;"><?php echo $item->tn_content; ?></p>
                <p style="font-size:12px;color:#fa6800"><?php echo $item->tn_remark; ?></p>
            </div>
            <?php } ?>
            <p><?php echo $pages; ?></p>
        </div>

    </div>

</div>
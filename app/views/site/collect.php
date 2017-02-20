<div class="container">

    <div class="row">

        <div class="col-sm-3"><?php include '_nav.php'; ?></div>

        <div class="col-sm-8 col-sm-offset-1">
            <h3>我的收藏</h3>
            <hr>
            <?php foreach ($collect_list as $item) { ?>
            <div class="row">
                <?php if ($item->ct_image != '') { ?>
                <div class="col-md-2">
                    <a href="/site/content/id/<?php echo $item->by_id; ?>" target="_blank">
                        <img src="/nfs/image<?php echo $item->ct_image; ?>" class="img-responsive" style="margin-top:18px;">
                    </a>
                </div>
                <div class="col-md-9">
                <?php } else { ?>
                <div class="col-md-11">
                <?php } ?>
                    <h2 class="blog-post-title">
                        <a href="/site/content/id/<?php echo $item->by_id; ?>" style="color:#555;font-size:16px;" target="_blank"><?php echo $item->ct_title; ?></a>
                    </h2>
                    <p style="font-size:12px;">
                        <?php echo date('Y年m月d日 H:i, D', $item->cl_time); ?>
                    </p>
                    <p><?php echo \library\MbString::substr(strip_tags($item->ct_detail), 0, 36); ?>...</p>
                    <hr>
                </div>
                <div class="col-md-1" style="padding-top:20px;">
                    <a href="javascript:;" class="del_collect" data-val="<?php echo $item->cl_id; ?>"><span class="glyphicon glyphicon-trash"></span></a>
                </div>
            </div>
            <?php } ?>
            <p><?php echo $pages; ?></p>
            <p>&nbsp;</p>
        </div>

    </div>

</div>
<script type="text/javascript">
$(document).ready(function(){
    var user_id = '<?php echo \core\Autumn::app()->request->getSession('user_id')?>';
	var token = '<?php echo \core\Autumn::app()->request->getSession('token');?>';
    $('.del_collect').on('click', function(){
        if (confirm('确认要删除该收藏吗？')){
            var cl_id = $(this).attr('data-val');
            $.post(
                '/collect/delete',
                {user_id: user_id, token: token, cl_id: cl_id},
                function(data){
                    if (data.code == 1)
                        location.reload();
                    else
                        alert(data.error);
                },
                'json'
            );
        }
    });
});
</script>
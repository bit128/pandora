<div class="container">
	<div class="row">
		<?php
		$i = 0;
		$e = false;
		$album_list[] = array();
		foreach ($album_list as $v ) { 
			if(++$i == 7) {
				echo '</div><div class="row">';
				$i = 0;
				$e = true;
			}else{
				$e = false;
			}
			if($v){
		?>
		<div class="col-md-2" data-val="<?php echo $v->al_id; ?>">
			<div class="thumbnail">
				<img src="/nfs/image/<?php echo $v->al_image; ?>">
				<div style="text-align:center;padding:10px 0 10px;">
					<strong><?php echo $v->al_image; ?></strong>
				</div>
				<p style="text-align:center;">
					<button type="button" class="btn btn-xs set_sort" data-val="prev" title="左移">
						<span class="glyphicon glyphicon-arrow-left"></span>
					</button>
					<button type="button" class="btn btn-xs set_sort" data-val="next" title="右移">
						<span class="glyphicon glyphicon-arrow-right"></span>
					</button>
					<?php if ($v->al_status == 1) { ?>
					<button type="button" class="btn btn-xs btn-info set_status" data-val="0" title="可见">
						<span class="glyphicon glyphicon-eye-open"></span>
					</button>
					<?php } else { ?>
					<button type="button" class="btn btn-xs set_status" data-val="1" title="隐藏">
						<span class="glyphicon glyphicon-eye-close"></span>
					</button>
					<?php } ?>
					<button type="button" class="btn btn-xs img_delete" title="删除">
						<span class="glyphicon glyphicon-trash"></span>
					</button>
				</p>
			</div>
		</div>
		<?php } else { ?>
		<div class="col-md-2">
			<div class="thumbnail">
				<img src="/app/statics/files/images/default.jpg">
				<div style="text-align:center;padding:10px 0 10px;">
					<strong><!--添加图片--></strong>
				</div>
				<div id="upload_image" style="position:relative;margin-bottom:10px;text-align:center;">
					<input id="fileImage" type="file" style="position:absolute;filter:alpha(opacity=0);opacity:0;width:100%;height:20px;" name="file_name">
					<button type="button" class="btn btn-xs btn-success">
						<span class="glyphicon glyphicon-plus"></span> 点击上传图片
					</button>
				</div>
			</div>
		</div>
		<?php }} if(!$e) { echo '</div>'; } ?>
	</div>
</div>
<script type="text/javascript" src="/app/statics/home/js/ajaxfileupload.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	var by_id = '<?php echo $by_id; ?>';
	var al_type = '<?php echo $al_type; ?>';
	//插入图片
	$('#upload_image').on('change', '#fileImage', function(){
		$.ajaxFileUpload({
			url:'/nfs/upload',
			fileElementId:'fileImage',
			dataType: 'json',
			success: function (data, status){
				var path = data.src;
				if(path != ''){
					$.post(
						'/album/add',
						{by_id: by_id, al_type: al_type, al_image: path},
						function(data){
							if(data.code == 1)
								location.reload();
							else
								alert(data.error);
						},
						'json'
						);
				}else{
					if(data.error != '')alert(data.error);
				}
			}
		});
	});
	//设置状态
	$('.set_status').on('click', function(){
		var al_id = $(this).parents('.col-md-3').attr('data-val');
		var status = $(this).attr('data-val');
		if(status == '0') {
			$(this).removeClass('btn-info').attr('data-val', 1).html('<span class="glyphicon glyphicon-eye-close"></span>');
		} else {
			$(this).addClass('btn-info').attr('data-val', 0).html('<span class="glyphicon glyphicon-eye-open"></span>');
		}
		$.post(
			'/album/setInfo',
			{al_id: al_id, field: 'al_status', value: status}
			);
	});
	//设置排序
	$('.set_sort').on('click', function(){
		var al_id = $(this).parents('.col-md-3').attr('data-val');
		var type = $(this).attr('data-val');
		$.post(
			'/album/setSort',
			{al_id: al_id, by_id: by_id, type: type},
			function(data){
				if(data.code == 1)
					location.reload()
				else
					alert(data.error);
			},
			'json'
			);
	});
	//删除图片
	$('.img_delete').on('click', function(){
		if(confirm('确定要删除吗？不可恢复！')) {
			var al_id = $(this).parents('.col-md-2').attr('data-val');
			$.post(
				'/album/delete',
				{al_id: al_id},
				function(data){
					if(data.code == 1)
						location.reload();
				},
				'json'
				);
		}
	});
});
</script>
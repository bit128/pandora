<div class="container">
	<div class="row">
		<div class="col-md-5">
			<button type="button" class="btn btn-sm btn-success" id="dict_new">
				<span class="glyphicon glyphicon-plus"></span> 增加索引词
			</button>
			<?php if ($pid != '-1') { ?>
			<a href="/home/dictionary/f/<?php echo $pid; ?>" class="btn btn-sm btn-default">
				<span class="glyphicon glyphicon-chevron-left"></span> 返回上一级
			</a>
			<?php } ?>
			<span class="btn-group">
				<a href="/home/dictionary/s/0/f/<?php echo $fid; ?>" class="btn btn-sm <?php echo $sort == 0 ? 'btn-info' : 'btn-default'; ?>">默认排序</a>
				<a href="/home/dictionary/s/1/f/<?php echo $fid; ?>" class="btn btn-sm <?php echo $sort == 1 ? 'btn-info' : 'btn-default'; ?>">用量排序</a>
			</span>
		</div>
		<div class="col-md-3">
			<div style="padding-top:4px;">词汇总数：<strong><?php echo $count; ?></strong> 个</div>
		</div>
		<div class="col-md-4">
			<form class="input-group" method="get" action="">
				<input type="text" class="form-control input-sm" name="k" value="<?php echo $keyword; ?>">
				<span class="input-group-btn">
					<button type="submit" class="btn btn-info btn-sm">
						<span class="glyphicon glyphicon-search"></span> 搜索
					</button>
				</span>
			</form>
		</div>
	</div>
	<p>&nbsp;</p>
	<table class="table table-bordered">
		<thead>
			<tr>
				<th style="width:100px;">ID</th>
				<th style="width:100px;">封面</th>
				<th style="text-align:center;">词汇</th>
				<th style="width:60px;">搜索量</th>
				<th style="width:200px;">创建时间</th>
				<th style="width:100px;">操作</th>
			</tr>
		</thead>
		<tbody id="dict_list">
			<?php foreach ($dictionary_list as $v) { ?>
			<tr data-val="<?php echo $v->dc_id; ?>">
				<td><?php echo $v->dc_id; ?></td>
				<td class="set_avatar">
					<input id="img_<?php echo $v->dc_id; ?>" type="file" style="position: absolute;filter: alpha(opacity=0);opacity:0;width:80px;height:60px;" name="file_name">
					<?php if($v->dc_avatar == '') {
						echo '<img src="/app/statics/files/default.jpg" class="img-responsive" style="max-width:80px;">';
					}else{
						echo '<img src="/nfs/image',$v->dc_avatar,'" class="img-responsive" style="max-width:80px;">';
					} ?>
				</td>
				<td style="text-align:center;"><strong style="font-size:18px;" class="dict_update"><?php echo $v->dc_keyword; ?></strong></td>
				<td><?php echo $v->dc_count; ?></td>
				<td><?php echo date('Y-m-d H:i:s', $v->dc_time); ?></td>
				<td>
					<a href="/home/dictionary/f/<?php echo $v->dc_id; ?>" class="btn btn-xs btn-info">成员</a>
					<button type="button" class="btn btn-xs btn-warning dict_delete">删除</button>
				</td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
	<p><?php echo $pages; ?></p>
</div>
<script type="text/javascript" src="/app/statics/home/js/ajaxfileupload.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	var fid = '<?php echo $fid; ?>';
	//新建词汇
	$('#dict_new').on('click', function(){
		$.post(
			'/dictionary/add',
			{dc_fid: fid, dc_keyword: '新关键词'},
			function(data){
				if(data.code == 1)
					location.reload();
				else
					alert(data.error);
			},
			'json'
			);
	});
	//修改词汇
	$('#dict_list').on('click', '.dict_update', function(){
		var dc_id = $(this).parents('tr').attr('data-val');
		var td = $(this).parent();
		var ov = $(this).text();
		var input = td.html('<input type="text" value="'+ov+'">').find('input');
		input.focus();
		input.one('blur', function(){
			var nv = input.val();
			if (nv != '' && nv != ov) {
				ov = nv;
				$.post(
					'/dictionary/update',
					{dc_id: dc_id, field: 'dc_keyword', value: nv}
				);
			}
			td.html('<strong style="font-size:18px;" class="dict_update">'+ov+'</strong>');
		});
	});
	//删除词汇
	$('.dict_delete').on('click', function(){
		if(confirm('确定要删除词汇吗？包括索引')){
			var dc_id = $(this).parents('tr').attr('data-val');
			$.post(
				'/dictionary/delete',
				{dc_id: dc_id},
				function(data){
					if(data.code == 1)
						location.reload();
					else
						alert(data.error);
				},
				'json'
				);
		}
	});
	//设置词汇封面
	$('#dict_list').on('change', '.set_avatar input', function(){
		var dc_id = $(this).parents('tr').attr('data-val');
		var image = $(this).parent().find('img');
		$.ajaxFileUpload({
			url:'/nfs/upload',
			fileElementId:'img_'+dc_id,
			dataType: 'json',
			success: function (data, status){
				if(data.code == 1) {
					image.attr('src', '/nfs/image'+data.uri);
					$.post(
						'/dictionary/update',
						{dc_id: dc_id, field: 'dc_avatar', value: data.uri}
					);
				} else {
					alert('图片可能损坏，请换一张图片');
				}
			}
		});
	});
});
</script>
<div class="container">
	<div class="row">
		<div class="col-md-4">
			<?php if ($keyword == '') { ?>
			<button type="button" class="btn btn-sm btn-success" id="dict_new">
				<span class="glyphicon glyphicon-plus"></span> 增加词汇
			</button>
			<?php } if ($fid != '0' || $keyword != '') { ?>
			<a href="javascript:history.back();" class="btn btn-sm btn-default">
				<span class="glyphicon glyphicon-chevron-left"></span> 返回上一页
			</a>
			<?php } ?>
		</div>
		<div class="col-md-5">
			<div style="padding-top:8px;">词汇总数：<strong><?php echo $count; ?></strong> 个</div>
		</div>
		<div class="col-md-3">
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
				<th style="width:130px;">操作</th>
			</tr>
		</thead>
		<tbody id="dict_list">
			<?php foreach ($category_list as $v) { ?>
			<tr data-val="<?php echo $v->ca_id; ?>">
				<td><?php echo $v->ca_id; ?></td>
				<td>
					<a href="/home/file/avatar/category/bid/<?php echo $v->ca_id; ?>">
					<?php if($v->ca_image == '') {
						echo '<img src="/app/statics/files/default.jpg" class="img-responsive" style="max-width:80px;">';
					}else{
						echo '<img src="/nfs/image',$v->ca_image,'" class="img-responsive" style="max-width:80px;">';
					} ?>
					</a>
				</td>
				<td style="text-align:center;"><strong style="font-size:18px;" class="dict_update"><?php echo $v->ca_name; ?></strong></td>
				<td>
					<a href="/home/category/f/<?php echo $v->ca_id; ?>" class="btn btn-xs btn-info">
						<span class="glyphicon glyphicon-tags"></span> 成员
					</a>
					<button type="button" class="btn btn-xs btn-warning dict_delete">
						<span class="glyphicon glyphicon-trash"></span> 删除
					</button>
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
			'/category/add',
			{ca_fid: fid, ca_name: '新关键词'},
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
		var ca_id = $(this).parents('tr').attr('data-val');
		var td = $(this).parent();
		var ov = $(this).text();
		var input = td.html('<input type="text" value="'+ov+'">').find('input');
		input.focus();
		input.one('blur', function(){
			var nv = input.val();
			if (nv != '' && nv != ov) {
				ov = nv;
				$.post(
					'/category/update',
					{ca_id: ca_id, field: 'ca_name', value: nv}
				);
			}
			td.html('<strong style="font-size:18px;" class="dict_update">'+ov+'</strong>');
		});
	});
	//删除词汇
	$('.dict_delete').on('click', function(){
		if(confirm('确定要删除词汇吗？包括索引')){
			var ca_id = $(this).parents('tr').attr('data-val');
			$.post(
				'/category/delete',
				{ca_id: ca_id},
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
});
</script>
<div class="container">
	<div class="row">
		<div class="col-md-4">
			<button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#dict_box">
				<span class="glyphicon glyphicon-plus"></span> 增加索引词
			</button>
			<span class="btn-group">
				<a href="/home/dictionary/s/0/t/<?php echo $type; ?>" class="btn btn-sm <?php echo $sort == 0 ? 'btn-info' : 'btn-default'; ?>">默认排序</a>
				<a href="/home/dictionary/s/1/t/<?php echo $type; ?>" class="btn btn-sm <?php echo $sort == 1 ? 'btn-info' : 'btn-default'; ?>">用量排序</a>
			</span>
		</div>
		<div class="col-md-2">
			<select class="form-control input-sm" id="change_type">
				<option value="/home/dictionary/t/-1/s/1">全部词汇</option>
				<?php foreach (\app\models\M_dictionary::$_types as $k => $v) {
					echo '<option value="/home/dictionary/t/',$k,'/s/',$sort,'" ';
					if($type == $k) { echo 'selected'; }
					echo '>',$v,'</option>';
				} ?>
			</select>
		</div>
		<div class="col-md-2">
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
				<th>编号</th>
				<th>词汇</th>
				<th>分类</th>
				<th>搜索量</th>
				<th>创建时间</th>
				<th>操作</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($dictionary_list as $v) { ?>
			<tr>
				<td><small><?php echo $v->dc_id; ?></small></td>
				<td><?php echo $v->dc_keyword; ?></td>
				<td><?php echo \app\models\M_dictionary::$_types[$v->dc_type]; ?></td>
				<td><?php echo $v->dc_count; ?></td>
				<td><?php echo date('m-d H:i', $v->dc_time); ?></td>
				<td>
					<button type="button" class="btn btn-xs btn-warning dict_delete">删除</button>
				</td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
	<p><?php echo $pages; ?></p>
</div>
<!-- 新建词汇 -->
<div id="dict_box" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title">创建新词汇</h4>
			</div>
			<div class="modal-body" style="padding-bottom:0px;">
				<div class="row">
					<div class="col-md-6">
						<p>
							<label>词汇分类</label>
							<select class="form-control" id="dc_type">
								<?php foreach (\app\models\M_dictionary::$_types as $k => $v) {
									echo '<option value="',$k,'">',$v,'</option>';
								} ?>
							</select>
						</p>
					</div>
					<div class="col-md-6">
						<p>
							<label>词汇名称</label>
							<input type="text" class="form-control" id="dc_keyword">
						</p>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
				<button type="button" class="btn btn-info" id="dict_add">创建词汇</button>
			</div>
		</div>
	</div>
</div>
<!-- 新建词汇 -->
<script type="text/javascript">
$(document).ready(function(){
	//分类查找
	$('#change_type').on('change', function(){
		location.href = $(this).val();
	});
	//新建词汇
	$('#dict_add').on('click', function(){
		var dc_keyword = $('#dc_keyword').val();
		if(dc_keyword == ''){alert('词汇不能为空.');$('#dc_keyword').focus();return;}
		$.post(
			'/dictionary/add',
			{dc_type: $('#dc_type').val(), dc_keyword: dc_keyword},
			function(data){
				if(data.code == 1)
					location.reload();
				else
					alert(data.error);
			},
			'json'
			);
	});
	//删除词汇
	$('.dict_delete').on('click', function(){
		if(confirm('确定要删除词汇吗？包括索引')){
			var dc_id = $(this).parents('tr').find('td:eq(0)').text();
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
});
</script>
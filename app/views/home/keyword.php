<div class="container">
	<div class="row">
		<div class="col-md-3">
			<div class="input-group">
				<input type="text" class="form-control input-sm" id="input_keyword">
				<span class="input-group-btn">
					<button type="button" class="btn btn-success btn-sm" id="create_keyword">
						<span class="glyphicon glyphicon-plus"></span> 增加关键词
					</button>
				</span>
			</div>
		</div>
		<div class="col-md-6">
			<span class="btn-group">
				<?php $sort_uri = $keyword == '' ? '' : '/k/' . $keyword; ?>
				<a href="/home/keyword/s/0<?php echo $sort_uri; ?>" class="btn btn-sm <?php echo $sort==0 ? 'btn-info' : 'btn-default'; ?>">字序</a>
				<a href="/home/keyword/s/1<?php echo $sort_uri; ?>" class="btn btn-sm <?php echo $sort==1 ? 'btn-info' : 'btn-default'; ?>">创建时间</a>
				<a href="/home/keyword/s/2<?php echo $sort_uri; ?>" class="btn btn-sm <?php echo $sort==2 ? 'btn-info' : 'btn-default'; ?>">使用量</a>
				<a href="/home/keyword/s/3<?php echo $sort_uri; ?>" class="btn btn-sm <?php echo $sort==3 ? 'btn-info' : 'btn-default'; ?>">搜索量</a>
			</span>
		</div>
		<div class="col-md-3">
			<form class="input-group" method="get" action="/home/keyword/s/<?php echo $sort; ?>">
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
	<table class="table table-bordered table-condensed">
		<thead>
			<tr>
				<th style="width:100px;">ID</th>
				<th>名称</th>
				<th style="width:80px;">使用量</th>
				<th style="width:80px;">搜索量</th>
				<th style="width:180px;">创建时间</th>
				<th style="width:80px;">操作</th>
			</tr>
		</thead>
		<tbody id="dict_list">
			<?php foreach ($result as $item) { ?>
			<tr>
				<td><?php echo $item->kw_id; ?></td>
				<td><?php echo $item->kw_name; ?></td>
				<td><?php echo $item->kw_use; ?></td>
				<td><?php echo $item->kw_search; ?></td>
				<td><small><?php echo date('Y-m-d H:i:s', $item->kw_time); ?></small></td>
				<td>
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
	//新建词汇
	$('#create_keyword').on('click', function(){
		var keyword = $('#input_keyword').val();
		if (keyword == '') {
			alert('请填写关键词');
			$('#input_keyword').focus();
			return;
		}
		$.post(
			'/keyword/add',
			{kw_name: keyword},
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
			var kw_id = $(this).parents('tr').find('td:eq(0)').text();
			$.post(
				'/keyword/delete',
				{kw_id: kw_id},
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
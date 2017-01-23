<div class="container">
	<div class="row">
		<div class="col-md-4">
			<button type="button" class="btn btn-info btn-sm" id="product_add">
				<span class="glyphicon glyphicon-plus"></span> 添加商品
			</button>
			<span class="btn-group">
				<a href="/home/product/s/-1" class="btn btn-sm <?php echo $status == -1 ? 'btn-info' : 'btn-default'; ?>">全部商品</a>
				<a href="/home/product/s/1" class="btn btn-sm <?php echo $status == 1 ? 'btn-info' : 'btn-default'; ?>">线上商品</a>
				<a href="/home/product/s/0" class="btn btn-sm <?php echo $status == 0 ? 'btn-info' : 'btn-default'; ?>">下架商品</a>
			</span>
		</div>
		<div class="col-md-4">
			<div style="padding-top:4px;">商品总数：<strong><?php echo $count; ?></strong> 件</div>
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
				<th style="display:none;">编号</th>
				<th>货号</th>
				<th>图片</th>
				<th>名称</th>
				<th>产品摘要</th>
				<th>参考价</th>
				<th>排序</th>
				<th>状态</th>
				<th>操作</th>
			</tr>
		</thead>
		<tbody id="product_list">
			<?php foreach ($product_list as $v) { ?>
			<tr>
				<td style="display:none;"><small><?php echo $v->pd_id; ?></small></td>
				<td><a class="pd_update" data-val="pd_no"><?php echo $v->pd_no; ?></a></td>
				<td>
					<a href="/home/album/id/<?php echo $v->pd_id; ?>/t/product" target="_blank">
					<?php
					if ($v->pd_image != '') {
						echo '<img src="/nfs/image',$v->pd_image,'" style="max-width:80px;">';
					} else {
						echo '<img src="/app/statics/files/default.jpg" style="max-width:80px;">';
					}
					?>
					</a>
				</td>
				<td>
					<strong><a class="pd_update" data-val="pd_name"><?php echo $v->pd_name; ?></a></strong>
					<p><small class="pd_keyword"></small></p>
				</td>
				<td><textarea class="form-control ct_title" style="font-size:12px;"><?php echo $v->ct_title; ?></textarea></td>
				<td><input type="text" value="<?php echo $v->pd_price; ?>" style="width:70px;" class="set_price"></td>
				<td><input type="text" value="<?php echo $v->pd_sort; ?>" style="width:50px;" class="set_sort"></td>
				<td>
					<span class="btn-group set_status">
						<button type="button" class="btn btn-xs <?php echo $v->pd_status == 0 ? 'btn-warning' : 'btn-default'; ?>">下架</button>
						<button type="button" class="btn btn-xs <?php echo $v->pd_status == 1 ? 'btn-success' : 'btn-default'; ?>">上线</button>
					</span>
				</td>
				<td>
					<a href="/home/contentDetail/id/<?php echo $v->pd_id; ?>" class="btn btn-info btn-xs" target="_blank">详情</a>
					<a href="/home/stock/id/<?php echo $v->pd_id; ?>" class="btn btn-success btn-xs" target="_blank">库存</a>
					<button type="button" class="btn btn-warning btn-xs pd_delete">删除</button>
				</td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
	<p><?php echo $pages; ?></p>
</div>
<!-- 设置关键词 -->
<div id="keyword_box" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title">设置关键词</h4>
			</div>
			<div class="modal-body" style="padding-bottom:0px;">
				<div style="position:relative;margin-bottom:10px;">
					<label>输入关键词：</label>
					<div class="input-group">
						<input type="text" class="form-control" id="input_keyword">
						<span class="input-group-btn">
							<button type="button" class="btn btn-success" id="add_keyword">
								<span class="glyphicon glyphicon-plus"></span> 确认
							</button>
						</span>
					</div>
					<div class="list-group" style="position:absolute;display:none;" id="keyword_list">
						<li class="list-group-item"><small>[默认]</small> <strong>Cras justo odio</strong></li>
						<li class="list-group-item"><small>[默认]</small> <strong>Cras justo odio</strong></li>
						<li class="list-group-item"><small>[默认]</small> <strong>Cras justo odio</strong></li>
						<li class="list-group-item"><small>[默认]</small> <strong>Cras justo odio</strong></li>
					</div>
				</div>
				<p>
					<label>已选关键词：</label>
					<textarea class="form-control" rows="7" id="keywords"></textarea>
				</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
				<button type="button" class="btn btn-info" id="update_keyword">保存关键词</button>
			</div>
		</div>
	</div>
</div>
<!-- 设置关键词 -->
<script type="text/javascript">
$(document).ready(function(){
	//添加商品
	$('#product_add').on('click', function(){
		if(confirm('要添加新的商品吗？')){
			$.post(
				'/product/add',
				{pd_name: '新上架商品', pd_no: 'AAAAAA'},
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
	//修改名称、货号
	$('#product_list').on('click', '.pd_update', function(){
		var pd_id = $(this).parents('tr').find('td:eq(0)').text();
		var td = $(this).parent();
		var ov = $(this).text();
		var field = $(this).attr('data-val');
		var input;
		if(field == 'pd_name')
			input = td.html('<textarea class="form-control">'+ov+'</textarea>').find('textarea');
		else if(field == 'pd_no')
			input = td.html('<input class="form-control" value="'+ov+'">').find('input');
		input.focus();
		input.one('blur', function(){
			var nv = $(this).val();
			if(nv != '' && nv != ov) {
				setInfo(pd_id, field, nv);
				ov = nv;
			}
			td.html('<a class="pd_update" data-val="'+field+'">'+ov+'</a>');
		});
	});
	//设置状态
	$('.set_status').on('click', 'button', function(){
		var pd_id = $(this).parents('tr').find('td:eq(0)').text();
		var p = $(this).parent().find('button');
		var index = p.index(this);
		if(index == 1){
			$(this).parent().find('button:eq(0)').removeClass('btn-warning').addClass('btn-default');
			$(this).removeClass('btn-default').addClass('btn-success');
		} else {
			$(this).parent().find('button:eq(1)').removeClass('btn-success').addClass('btn-default');
			$(this).removeClass('btn-default').addClass('btn-warning');
		}
		setInfo(pd_id, 'pd_status', index);
	});
	//设置参考价
	$('.set_price').on('blur', function(){
		var value = $(this).val();
		if(/^\d+\.?\d{0,2}$/.test(value)) {
			var pd_id = $(this).parents('tr').find('td:eq(0)').text();
			setInfo(pd_id, 'pd_price', value);
		}else{
			alert('价格格式：12.00或者12');
		}
	});
	//设置排序
	$('.set_sort').on('blur', function(){
		var value = $(this).val();
		if(/\d+/.test(value)) {
			var pd_id = $(this).parents('tr').find('td:eq(0)').text();
			setInfo(pd_id, 'pd_sort', value);
		}else{
			alert('请填写整数');
		}
	});
	//修改商品
	function setInfo(pd_id, field, value) {
		$.post(
			'/product/setInfo',
			{pd_id: pd_id, field: field, value: value},
			function(data){
				if(data.code != 1)
					alert(data.error);
			},
			'json'
			);
	}
	//删除商品
	$('.pd_delete').on('click', function(){
		if(confirm('确定要删除吗？操作不可恢复哦！')){
			var tr = $(this).parents('tr');
			var pd_id = tr.find('td:eq(0)').text();
			$.post(
				'/product/delete',
				{pd_id: pd_id},
				function(data){
					if(data.code == 1)
						location.reload();
					else
						alert(data.result);
				},
				'json'
				);
		}
	});
	//设置关键词
	(function(){
		var pd_id = '';
		var last_keyword = '';
		//弹框
		$('#product_list').on('click', '.pd_keyword', function(){
			pd_id = $(this).parents('tr').find('td:eq(0)').text();
			$('#keyword_box').modal('show');
			$('#keywords').val($(this).text() != '设置关键词' ? $(this).text() : '');
		});
		//键入关键字事件
		$('#input_keyword').on('keyup', function(){
			var keyword = $(this).val();
			if(keyword != '' && keyword != last_keyword){
				last_keyword = keyword;
				$.get('/dictionary/matchKeywordList/keyword/'+keyword, function(data){
					if(data.code == 1){
						var html = '';
						$.each(data.result.result, function(i, d){
							html += '<a class="list-group-item"><strong>'+d.dc_keyword+'</strong></a>';
						});
						if(html != '') {
							$('#keyword_list').html(html).show();
						}else{
							$('#keyword_list').hide();
						}
					}
				}, 'json');
			}
		});
		//选择关键词
		$('#keyword_box').on('click', '.list-group-item', function(){
			$('#input_keyword').val($(this).text());
			$('#keyword_list').hide();
		});
		//添加关键字
		$('#add_keyword').on('click', function(){
			var keyword = $('#input_keyword').val();
			if(keyword != '')
			{
				$('#keywords').val($('#keywords').val()+' '+keyword);
				$('#input_keyword').val('');
				$('#keyword_list').hide();
			}
		});
		//更新关键字
		$('#update_keyword').on('click', function(){
			var keyword = $('#keywords').val();
			$.post(
				'/dictionary/addIndex',
				{by_id: pd_id, keywords: keyword},
				function(data){
					if(data.code == 1){
						$('#keyword_box').modal('hide');
						$('#keywords').val('');
						loadKeyword();
					}else{
						alert(data.error);
					}
				},
				'json'
				);
		});
		loadKeyword();
		function loadKeyword() {
			$('#product_list').find('tr').each(function(){
				var tr = $(this);
				var pd_id = tr.find('td:eq(0)').text();
				$.get('/dictionary/getIndex/id/'+pd_id, function(data){
					if(data.code == 1){
						var html = '';
						$.each(data.result, function(i, d){
							html += ' '+d.dc_keyword;
						});
						if(html.replace(' ', '') == '')
							html = '设置关键词';
						tr.find('.pd_keyword').html(html);
					}
				}, 'json');
			});
		}
	})();
	//设置产品摘要
	$('#product_list').on('blur', '.ct_title', function(){
		var pd_id = $(this).parents('tr').find('td:eq(0)').text();
		var ct_title = $(this).val();
		$.post(
			'/content/update',
			{ct_id: pd_id, field: 'ct_title', value: ct_title},
			function(data){
				if(data.code != 1) {
					alert(data.error);
				}
			},
			'json'
		);
	});
});
</script>
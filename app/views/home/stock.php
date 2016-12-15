<style type="text/css">
.se_img_ck img {
	border: 2px dotted #FA6800;
}
</style>
<div class="container">
	<div class="row">
		<div class="col-md-4">
			<button type="button" class="btn btn-sm btn-success" id="stock_add">
				<span class="glyphicon glyphicon-plus"></span> 添加新库存
			</button>
		</div>
		<div class="col-md-4">
			<span class="btn-group">
				<a href="" class="btn btn-sm btn-info">默认顺序</a>
				<a href="" class="btn btn-sm btn-default">最多库存</a>
				<a href="" class="btn btn-sm btn-default">最少库存</a>
			</span>
		</div>
	</div>
	<p>&nbsp;</p>
	<table class="table table-bordered">
		<thead>
			<tr>
				<th>编号</th>
				<th>图片</th>
				<th>库存名称</th>
				<th>尺寸</th>
				<th>数量</th>
				<th>单价</th>
				<th>折扣</th>
				<th>操作</th>
			</tr>
		</thead>
		<tbody id="stock_list">
			<?php foreach ($stock_list as $v) { ?>
			<tr>
				<td><small><?php echo $v->st_id; ?></small></td>
				<td>
					<a href="javascript:;" class="chiose_img">
					<?php
					if ($v->st_image != '') {
						echo '<img src="/nfs/image',$v->st_image,'" style="max-width:80px;">';
					} else {
						echo '<img src="/app/statics/files/default.jpg" style="max-width:80px;">';
					}
					?>
					</a>
				</td>
				<td><a class="st_update" data-val="st_name"><?php echo $v->st_name; ?></a></td>
				<td><a class="st_update" data-val="st_size"><?php echo $v->st_size; ?></a></td>
				<td><input type="text" style="width:50px;" value="<?php echo $v->st_count; ?>" class="set_count"></td>
				<td><input type="text" style="width:80px;" value="<?php echo $v->st_price; ?>" class="set_price"></td>
				<td><input type="text" style="width:50px;" value="<?php echo $v->st_discount; ?>" class="set_discount"></td>
				<td>
					<?php if($v->st_status == 1){ ?>
					<button type="button" class="btn btn-xs btn-info set_status" data-val="0">启用</button>
					<?php } else { ?>
					<button type="button" class="btn btn-xs set_status" data-val="1">停用</button>
					<?php } ?>
					<button type="button" class="btn btn-xs btn-warning">删除</button>
				</td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
	<p><?php echo $pages; ?></p>
</div>
<!-- 图片选择器 -->
<div id="image_box" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title">选择库存图片</h4>
			</div>
			<div class="modal-body" style="padding-bottom:0px;" id="image_select">
				<p>没有找到商品图片，请先上传商品图片！</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
				<button type="button" class="btn btn-info" id="update_image">设置为库存图片</button>
			</div>
		</div>
	</div>
</div>
<!-- 图片选择器 -->
<script type="text/javascript">
$(document).ready(function(){
	var pd_id = '<?php echo $pd_id; ?>';
	//创建库存
	$('#stock_add').on('click', function(){
		if(confirm('确定创建新的库存吗？')) {
			$.post(
				'/stock/add',
				{pd_id: pd_id, st_name: '默认库存', st_size: '默认规格'},
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
	//更新文本字段
	$('#stock_list').on('click', '.st_update', function(){
		var st_id = $(this).parents('tr').find('td:eq(0)').text();
		var td = $(this).parent();
		var ov = $(this).text();
		var field = $(this).attr('data-val');
		var input = td.html('<input type="text" value="'+ov+'">').find('input');
		input.focus();
		input.one('blur', function(){
			var nv = $(this).val();
			if(nv != '' && nv != ov) {
				setInfo(st_id, field, nv);
				ov = nv;
			}
			td.html('<a class="st_update" data-val="'+field+'">'+ov+'</a>');
		});
	})
	//设置数量
	$('#stock_list').on('blur', '.set_count', function(){
		var v = $(this).val();
		if(!/^[0-9]+$/.test(v)){alert('数字必须是正整数');}
		var st_id = $(this).parents('tr').find('td:eq(0)').text();
		setInfo(st_id, 'st_count', v);
	});
	//设置单价
	$('#stock_list').on('blur', '.set_price', function(){
		var v = $(this).val();
		if(!/^\d+\.?\d{0,2}$/.test(v)){alert('价格格式：12.00或者12');}
		var st_id = $(this).parents('tr').find('td:eq(0)').text();
		setInfo(st_id, 'st_price', v);
	});
	//设置折扣
	$('#stock_list').on('blur', '.set_discount', function(){
		var v = $(this).val();
		if(!/^((0\.\d{1,2})|(1\.0))$/.test(v)){alert('折扣范围：1.0~0.01');}
		var st_id = $(this).parents('tr').find('td:eq(0)').text();
		setInfo(st_id, 'st_discount', v);
	});
	//设置状态
	$('#stock_list').on('click', '.set_status', function(){
		var st_id = $(this).parents('tr').find('td:eq(0)').text();
		var status = $(this).attr('data-val');
		if(status == '0'){
			$(this).removeClass('btn-info').text('停用').attr('data-val', 1);
		}else{
			$(this).addClass('btn-info').text('启用').attr('data-val', 0);
		}
		setInfo(st_id, 'st_status', status);
	});
	//更新库存信息
	function setInfo(st_id, field, value, callback){
		$.post(
			'/stock/setinfo',
			{st_id: st_id, field: field, value: value},
			function(data){
				if(callback == undefined){
					if(data.code != 1)
						alert(data.error);
				}else{
					callback(data);
				}
			},
			'json'
			);
	}
	// ====== ====== 设置图片 ====== ======
	var st_id = '';
	var is_update = false;
	//设置库存图片
	$('#update_image').on('click', function(){
		if(st_id != ''){
			var img = $('.se_img_ck').attr('data-val');
			if(img) {
				setInfo(st_id, 'st_image', img, function(data){
					if(data.code == 1){
						location.reload();
					}else{
						alert(data.error);
					}
				});
				$('#image_box').modal('hide');
			} else {
				alert('请选择图片');
			}
		}
	});
	//库存图片选择器
	$('.chiose_img').on('click', function(){
		st_id = $(this).parents('tr').find('td:eq(0)').text();
		if(! is_update)
			loadImageList();
		$('.se_img').removeClass('se_img_ck');
		$('#image_box').modal('show');
	});
	//选择图片
	$('#image_select').on('click', '.se_img', function(){
		$('.se_img').removeClass('se_img_ck');
		$(this).addClass('se_img_ck');
	});
	//加载商品图片
	function loadImageList() {
		$.post(
			'/album/getList',
			{offset:0, limit: 4, by_id: pd_id},
			function(data){
				if(data.code == 1) {
					var html = '<div class="row">';
					$.each(data.result.result, function(i, d){
						html += '<div class="col-md-3 se_img" data-val="'+d.al_image+'"><img src="/nfs/image'
							+d.al_image+'" class="img-responsive img-thumbnail"></div>';
					});
					if(html != '')
						html += '</div>';
					$('#image_select').html(html);
					is_update = true;
				} else {
					alert(data.error);
				}
			},
			'json'
			);
	}
});
</script>
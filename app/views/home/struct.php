<div class="container">
	<div class="row">
		<div class="col-md-4">
			<p>
				<button type="button" class="btn btn-sm btn-success" id="config_add">
					<span class="glyphicon glyphicon-plus"></span>增加配置项
				</button>
			</p>
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>编号</th>
						<th>名称</th>
						<th>操作</th>
					</tr>
				</thead>
				<tbody id="head_list"></tbody>
			</table>
		</div>
		<div class="col-md-8">
			<p>
				<button type="button" class="btn btn-sm btn-default" id="struct_format">
					<span class="glyphicon glyphicon-repeat"></span> 格式化配置项
				</button>
				<button type="button" class="btn btn-sm btn-info" id="struct_save">
					<span class="glyphicon glyphicon-floppy-disk"></span> 保存配置项
				</button>
			</p>
			<textarea class="form-control" rows="20" id="struct"></textarea>
		</div>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$config = [];
	var cf_id = '';
	//载入配置列表
	loadConfigList();
	function loadConfigList() {
		$.get('/config/getList', function(data){
			config = data.result;
			var html = '';
			$.each(config, function(i, d){
				html += '<tr><td>'+d.id+'</td><td><a href="javascript:;" class="set_name">'+d.name+'</a></td><td>'
					+ '<button type="button" class="btn btn-xs btn-info config_edit">编辑</button> '
					+ '<button type="button" class="btn btn-xs btn-warning config_delete">删除</button>'
					+ '</td></tr>';
			});
			$('#head_list').html(html);
		}, 'json');
	}
	//增加配置项
	$('#config_add').on('click', function(){
		$.post(
			'/config/add',
			{name: '新配置项'},
			function(data){
				if(data.code == 1)
					loadConfigList();
			},
			'json'
			);
	});
	//设置配置项名称
	$('#head_list').on('click', '.set_name', function(){
		var id = $(this).parents('tr').find('td:eq(0)').text();
		var td = $(this).parent();
		var ov = $(this).text();
		var input = td.html('<input type="text" value="'+ov+'">').find('input');
		input.focus();
		input.one('blur', function(){
			var nv = $(this).val();
			if(nv != '' && nv != ov){
				$.post(
					'/config/setName',
					{id: id, name: nv},
					function(data){
						if(data.code == 1)
							loadConfigList();
					},
					'json'
					);
				ov = nv;
			}
			td.html('<a href="javascript:;" class="set_name">'+ov+'</a>');
		});
	});
	//编辑配置项
	$('#head_list').on('click', '.config_edit', function(){
		cf_id = $(this).parents('tr').find('td:eq(0)').text();
		var obj = JSON.parse(config[cf_id].data);
		if(obj == null)
			obj = {};
		$('#struct').val(JSON.stringify(obj, null, "\t"));
	});
	//删除配置项
	$('#head_list').on('click', '.config_delete', function(){
		var id = $(this).parents('tr').find('td:eq(0)').text();
		$.post(
			'/config/delete',
			{id: id},
			function(data){
				if(data.code == 1)
					loadConfigList();
			},
			'json'
			);
		cf_id = '';
		$('#struct').val('');
	});
	//保存配置项
	$('#struct_save').on('click', function(){
		if(cf_id != ''){
			var vali = true;
			var struct_str = $('#struct').val();
			if(struct_str == '')
				struct_str = '{}';
			try {
				JSON.parse(struct_str);
			} catch (e) {
				alert(e.name+' '+e.message);
				vali = false;
			}
			if(vali) {
				$.post(
					'/config/setBody',
					{id: cf_id, body: struct_str},
					function(data){
						if(data.code == 1)
							loadConfigList();
						else
							alert(data.error);
					},
					'json'
					);
			}
		}
	});
	//格式化
	$('#struct_format').on('click', function(){
		var vali = true;
		var struct_str = $('#struct').val();
		if(struct_str != ''){
			try {
				var obj = JSON.parse(struct_str);
			} catch (e) {
				alert(e.name+' '+e.message);
				vali = false;
			}
			if(vali) {
				$('#struct').val(JSON.stringify(obj, null, "\t"));
			}
		}
	});
});
</script>
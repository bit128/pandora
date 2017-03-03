<link rel="stylesheet" href="/app/statics/home/css/zTreeStyle/zTreeStyle.css" type="text/css" />
<div class="container">
	<div class="row">
		<div class="col-md-3">
			<div class="panel panel-info">
				<div class="panel-heading">栏目目录</div>
				<div class="panel-body">
					<div id="tree" class="ztree"></div>
				</div>
			</div>
		</div>
		<div class="col-md-9">
			<div class="row">
				<div class="col-md-6">
					<span style="font-size:18px;">内容管理列表 <strong id="channel_name">- 站点根目录</strong></span>
				</div>
				<div class="col-md-6">
					<div class="pull-right" style="margin-top:-5px;" id="content_btns">
						<a href="javascript:;" class="btn btn-info btn-sm" id="content_add">
							<span class="glyphicon glyphicon-plus"></span> <strong>新增内容</strong>
						</a>
						<span class="btn-group">
							<a href="javascript:;" class="btn btn-success btn-sm set_sort" data-val="0">
								<span class="glyphicon glyphicon-sort-by-attributes-alt"></span> 最近创建
							</a>
							<a href="javascript:;" class="btn btn-default btn-sm set_sort" data-val="2">
								<span class="glyphicon glyphicon-sort-by-attributes-alt"></span> 最近更新
							</a>
						</span>
					</div>
				</div>
			</div>	
			<table class="table table-bordered table-hover" style="margin-top:16px;">
				<thead>
					<tr>
						<th style="width:100px;">编号</th>
						<th>封面</th>
						<th>标题</th>
						<th>时间</th>
						<th>浏览量</th>
						<th>操作</th>
					</tr>
				</thead>
				<tbody id="content_list">
					<!--
					<tr>
						<td style="text-align:center;">
							<select>
								<option>请选择</option>
								<option>文本</option>
								<option>相册</option>
								<option>视屏</option>
							</select>
							<a href="javascript:;"><span class="glyphicon glyphicon-edit"></span> 编辑文本</a>
							<small>112358132652a</small>
						</td>
						<td>
							<img src="/app/statics/files/images/default.jpg" class="img-responsive" style="max-width:80px;">
						</td>
						<td>
							<strong>这里是标题</strong><br>
							<small style="color:#999;">这里是副标题，可以很长很长的哦</small>
							<div style="font-size:10px;color:#cc63c9;">Java 架构 数据库</div>
						</td>
						<td><small>12月26日 12:56</small></td>
						<td><small>12月26日 12:56</small></td>
						<td>17</td>
						<td style="width:50px;">
							<select>
								<option>公开</option>
								<option>隐藏</option>
								<option>删除</option>
							</select>
						</td>
					</tr>-->
				</tbody>
			</table>
			<div id="pages" style="text-align:center;"></div>
		</div>
	</div>
</div>
<!-- 内容结束 -->
<!-- 栏目详情 -->
<div id="channel_box" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title">栏目管理</h4>
			</div>
			<div class="modal-body" style="padding-bottom:0px;">
				<form id="channel_form">
					<div class="row">
						<div class="col-md-6">
							<p>
								<label>编号：</label>
								<strong id="cn_id"></strong>
							</p>
						</div>
						<div class="col-md-6">
							<p>
								<label>更新时间：</label>
								<span class="text-info" id="cn_utime"></span>
							</p>
						</div>
					</div>
					<p>
						<label>名称：</label>
						<input type="text" class="form-control" id="cn_name" disabled>
					</p>
					<p>
						<label>副标题：</label>
						<input type="text" class="form-control" id="cn_nick">
					</p>
					<p>
						<label>超链接：</label>
						<input type="text" class="form-control" id="cn_url">
					</p>
					<p>
						<label>状态：</label>
						<span id="cn_status"></span>
					</p>
				</form>
			</div>
			<div class="modal-footer">
				<div class="row">
					<div class="col-md-4"></div>
					<div class="col-md-4">
						<select class="form-control" id="cn_admin"></select>
					</div>
					<div class="col-md-4">
						<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
						<button type="button" class="btn btn-primary" id="update_channel">更新栏目</button>
					</div>
				</div>
			</div>
		</div>
	</div>
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
				<div class="row">
					<div class="col-md-6">
						<p>
							<label>备选关键词：</label>
							<div id="select_keywords"></div>
						</p>
					</div>
					<div class="col-md-6">
						<p>
							<label>已选关键词：</label>
							<div id="keywords"></div>
						</p>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
			</div>
		</div>
	</div>
</div>
<!-- 设置关键词 -->
<!-- 栏目详情 -->
<script type="text/javascript" src="/app/statics/home/js/jquery.ztree.core-3.5.min.js"></script>
<script type="text/javascript" src="/app/statics/home/js/jquery.ztree.excheck-3.5.min.js"></script>
<script type="text/javascript" src="/app/statics/home/js/jquery.ztree.exedit-3.5.min.js"></script>
<script type="text/javascript" src="/app/statics/home/js/ajaxfileupload.js"></script>
<script type="text/javascript" src="/app/statics/home/js/main.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	var cn_id = 1;
	var ct_id = 0;
// ====== ====== 内容管理 ====== ======
	var content = new Content($('#content_list'), $('#content_btns'), $('#pages'), $('#keyword_box'));
// ====== ====== 栏目管理 ====== ======
	//栏目树设置
	var setting = {
		async: {
			enable: true,
			url: '/channel/getChannelTree',
			autoParam: ['id'],
			dataFilter: filter
		},
		view: {
			addHoverDom: addHoverDom,
			removeHoverDom: removeHoverDom,
			selectedMulti: false,
			dblClickExpand: false
		},
		edit: {
			enable: true
		},
		data: {
			simpleData: {
				enable: true
			}
		},
		callback: {
			beforeRemove: beforeRemove,
			beforeRename: beforeRename,
			onRightClick: onRightClick,
			onDblClick: onDblClick,
			onDrop: onDrop
		}
	};
	//数据过滤
	function filter(treeId, parentNode, childNodes) {
		if (! childNodes) {
			return null;
		}
		/*
		for (var i=0, l=childNodes.length; i<l; i++) {
		  //childNodes[i].name = childNodes[i].name.replace(/\.n/g, '.');
		}*/
		return childNodes;
	}
	//新建栏目
	function addHoverDom(treeId, treeNode) {
		var sObj = $("#" + treeNode.tId + "_span");
		if (treeNode.editNameFlag || $("#addBtn_"+treeNode.id).length>0) return;
		var addStr = "<span class='button add' id='addBtn_" + treeNode.id + "' title='添加' onfocus='this.blur();'></span>";
		sObj.after(addStr);
		var btn = $("#addBtn_"+treeNode.id);
		if (btn) btn.bind("click", function() {
			//提交创建子栏目数据
			$.post(
				'/channel/add',
				{cn_name: '新建栏目', cn_fid: treeNode.id},
				function(data) {
					if(data.code == 1) {
						var zTree = $.fn.zTree.getZTreeObj("tree");
						if(treeNode.isParent) {
							zTree.reAsyncChildNodes(treeNode,'refresh');
						} else {
							zTree.addNodes(treeNode, {id:data.result, pId:treeNode.id, name:"新建栏目"});
						}
					}
				},
				'json'
			);
		});
	}
	//隐藏操作按钮
	function removeHoverDom(treeId, treeNode) {
		$("#addBtn_"+treeNode.id).unbind().remove();
	};
	//删除栏目
	function beforeRemove(treeId, treeNode) {
		var zTree = $.fn.zTree.getZTreeObj("tree");
		zTree.selectNode(treeNode);
		if(treeNode.status == '2') {
			alert('不可以删除系统栏目');
			return false;
		}
		if(treeNode.isParent) {
			alert('您需要先删除子栏目！');
			return false;
		}
		if(confirm("确认删除 " + treeNode.name + " 栏目及内容吗？")) {
			$.post(
				'/channel/delete',
				{cn_id: treeNode.id},
				function(data) {
					if (data.code == 1) {
						zTree.removeNode(treeNode);
					} else {
						alert(data.error);
					}
				},
				'json'
			);
		}
		return false;
	}
	//重命名栏目
	function beforeRename(treeId, treeNode, newName) {
		if(newName.length == 0) {
			alert('栏目名称不能为空.');
			return false;
		} else {
			$.post(
				'/channel/rename',
				{cn_id: treeNode.id, cn_name: newName},
				function(data) {
					//
				},
				'json'
			);
		}
		return true;
	}
	//栏目详情
	function onRightClick(event, treeId, treeNode) {
		cn_id = treeNode.id;
		$.post(
			'/channel/get',
			{cn_id: cn_id},
			function(data) {
				if(data.code == 1) {
					var date = new Date(parseInt(data.result.cn_time) * 1000);
					$('#cn_utime').text(date.getFullYear()+'-'+(date.getMonth()+1)+'-'+date.getDate()+' '+date.getHours()+':'+date.getMinutes());
					$('#cn_id').text(data.result.cn_id);
					$('#cn_name').val(data.result.cn_name);
					$('#cn_nick').val(data.result.cn_nick);
					$('#cn_url').val(data.result.cn_url);
					loadAdminList(data.result.cn_admin);
					if(data.result.cn_status == '1') {
						$('#cn_status').html('<input type="radio" name="cn_status" value="1" checked> 启用 <input type="radio" name="cn_status" value="0"> 禁用');
					} else if(data.result.cn_status == '0') {
						$('#cn_status').html('<input type="radio" name="cn_status" value="1"> 启用 <input type="radio" name="cn_status" value="0" checked> 禁用');
					} else {
						$('#cn_status').html('<strong class="text-danger">系统</strong>');
					}
				} else {
					$('#channel_box').modal('hide');
				}
			},
			'json'
		);
		$('#channel_box').modal('show');
	}
	//加载管理员列表
	function loadAdminList(select){
		$.get('/admin/getAccountList', function(data){
			if(data.code == 1) {
				var html = '<option value="">公开读写</option>';
				$.each(data.result, function(i, d){
					if(select != d.am_account)
						html += '<option value="'+d.am_account+'">'+d.am_name+'</option>';
					else
						html += '<option value="'+d.am_account+'" selected>'+d.am_name+'</option>';
				});
				$('#cn_admin').html(html);
			}
		}, 'json');
	}
	//更新栏目详情
	$('#update_channel').on('click', function(){
		if(cn_id) {
			var cn_nick = $('#cn_nick').val();
			var cn_url = $('#cn_url').val();
			var cn_admin = $('#cn_admin').val();
			var cn_status = $('input[name="cn_status"]:checked').val();
			$.post(
				'/channel/update',
				{cn_id: cn_id, cn_nick: cn_nick, cn_url: cn_url, cn_admin: cn_admin, cn_status: cn_status},
				function(){
					$('#channel_form')[0].reset();
				},
				'json'
			);
			$('#channel_box').modal('hide');
		}
	});
	//栏目内容列表
	function onDblClick(event, treeId, treeNode) {
		cn_id = treeNode.id;
		$('#channel_name').text('- '+treeNode.name);
		content.getList(cn_id);
	}
	//栏目排序
	function onDrop(event, treeId, treeNodes, targetNode, moveType, isCopy) {
		var data = treeNodes[0];
		if(moveType) {
			$.post(
				'/channel/setSort',
				{cn_id: data.id, cn_fid: data.pId, by_id: targetNode.id, type: moveType}
			);
		}
	}
	//初始化栏目树
	$.fn.zTree.init($("#tree"), setting);

});
</script>
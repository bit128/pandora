<style type="text/css">
/*------ editor ------*/
body {
	background-color: #eeeeee;
}
#note_editor {
	margin-top: 10px;
	font-size:16px;
	color:#666;
	min-height: 460px;
	height: auto;
	width:100%;
	padding:10px;
	background: #fff;
	outline:none;
}
#note_editor textarea {
	border: 1px solid #eee;
}
.btn-orange {
	background-color: #fa6800;
    color: #fff;
}
.btn-orange:hover {
	background-color: #fa5500;
    color: #fff;
}
.btn-grew {
	background-color: #eee;
    color: #333;
}
.btn-grew:hover {
	background-color: #fa5500;
    color: #fff;
}
.cbtn-list {
	text-align: center;
	margin-top: 16px;
}
.cbtn {
	width: 40px;
	height: 40px;
	padding-top: 9px;
	font-size: 16px;
	border-radius: 50%;
	background-color: #fff;
	display: inline-block;
	text-align: center;
	color: #666;
	box-shadow: 0 0 5px #ddd;
	margin-right: 5px;
	outline: none !important;
}
.cbtn:hover {
	color: #fa6800;
	box-shadow: 0 0 10px #fa6800;
}
.cbtn:active {
	color: #fa6800;
}
.cbtn-active {
	background-color: #fa6800;
	color: #fff !important;
}
.cbtn-big {
	width: 60px;
	height: 60px;
	font-size: 20px;
	padding-top: 15px;
}
.btn-color {
	width: 20px;
	height: 20px;
	border-radius: 50%;
	display: inline-block;
}
</style>
<div class="container">
	<div class="row">
		<div class="col-md-2">
			<div id="note_btns">
				<div class="cbtn-list">
					<a href="javascript:;" class="cbtn" title="代码模式" data-val="0">
						<span class="glyphicon glyphicon-list-alt"></span>
					</a>
					<a href="javascript:;" class="cbtn cbtn-big" title="保存">
						<span class="glyphicon glyphicon-save"></span>
					</a>
				</div>
				<div class="cbtn-list">
					<a href="javascript:;" class="cbtn" title="大标题">
						<span class="glyphicon glyphicon-th-list"></span>
					</a>
					<a href="javascript:;" class="cbtn" title="中标题">
						<span class="glyphicon glyphicon-align-justify"></span>
					</a>
					<a href="javascript:;" class="cbtn" title="小标题">
						<span class="glyphicon glyphicon-list"></span>
					</a>
				</div>
				<div class="cbtn-list">
					<a href="javascript:;" class="cbtn" title="左对齐">
						<span class="glyphicon glyphicon-align-left"></span>
					</a>
					<a href="javascript:;" class="cbtn" title="居中">
						<span class="glyphicon glyphicon-align-center"></span>
					</a>
					<a href="javascript:;" class="cbtn" title="右对齐">
						<span class="glyphicon glyphicon-align-right"></span>
					</a>
				</div>
				<div class="cbtn-list">
					<a href="javascript:;" class="cbtn" title="粗体">
						<span class="glyphicon glyphicon-bold"></span>
					</a>
					<a href="javascript:;" class="cbtn" title="斜体">
						<span class="glyphicon glyphicon-italic"></span>
					</a>
				</div>
				<div class="cbtn-list">
					<a href="javascript:;" class="cbtn" title="插入资源" data-toggle="modal" data-target="#file_box">
						<span class="glyphicon glyphicon-font"></span>
					</a>
					<a href="javascript:;" class="cbtn" title="插入表格" data-toggle="modal" data-target="#table_box">
						<span class="glyphicon glyphicon-th"></span>
					</a>
				</div>
				<div class="cbtn-list">
					<a href="javascript:;" class="btn-color" data-val="666666" style="background-color:#666666;box-shadow:0 0 3px #666666;"></a>
					<a href="javascript:;" class="btn-color" data-val="FF6666" style="background-color:#FF6666;box-shadow:0 0 3px #FF6666;"></a>
					<a href="javascript:;" class="btn-color" data-val="0099CC" style="background-color:#0099CC;box-shadow:0 0 3px #0099CC;"></a>
					<a href="javascript:;" class="btn-color" data-val="FFCC00" style="background-color:#FFCC00;box-shadow:0 0 3px #FFCC00;"></a>
					<a href="javascript:;" class="btn-color" data-val="669933" style="background-color:#669933;box-shadow:0 0 3px #669933;"></a>
					<a href="javascript:;" class="btn-color" data-val="996600" style="background-color:#996600;box-shadow:0 0 3px #996600;"></a>
					<a href="javascript:;" class="btn-color" data-val="993399" style="background-color:#993399;box-shadow:0 0 3px #993399;"></a>
				</div>
			</div>
		</div>
		<div class="col-md-10">
			<div id="note_editor"></div>
		</div>
	</div>
	<p>&nbsp;</p>
</div>
<!-- 插入代码 开始 -->
<div id="file_box" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">插入资源</h4>
			</div>
			<div class="modal-body" style="padding-bottom:0;">
				<?php if ($file_list['count']) { ?>
				<table class="table table-bordered" id="file_list">
					<tbody>
						<?php foreach ($file_list['result'] as $item) { ?>
						<tr>
							<td><a href="<?php echo $item->file_path; ?>" target="_blank"><?php echo $item->file_name != '' ? $item->file_name
								: substr($item->file_path, strlen($item->file_path) - 17); ?></a></td>
							<td style="width:110px;">
								<button class="btn btn-xs btn-default" data-val="<?php echo $item->file_type; ?>" data-path="<?php echo $item->file_path; ?>">
									<span class="glyphicon glyphicon-chevron-right"></span> 插入到页面
								</button>
							</td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
				<?php } ?>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-grew" data-dismiss="modal">关闭</button>
				<a type="button" href="/home/file/bid/<?php echo $cn_id; ?>" class="btn btn-orange">管理资源附件</a>
			</div>
		</div>
	</div>
</div>
<!-- 插入代码 结束 -->
<!-- 插入表格 开始 -->
<div id="table_box" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">插入表格</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-4">
						<input type="text" class="form-control" placeholder="行数" id="tab_rows">
					</div>
					<div class="col-md-4">
						<input type="text" class="form-control" placeholder="列数" id="tab_cols">
					</div>
					<div class="col-md-4" style="padding-top:6px;">
						<input type="checkbox" id="tab_thead" checked> <strong style="font-size:16px;">包含表头</strong>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-grew" data-dismiss="modal">关闭</button>
				<button type="button" class="btn btn-orange" id="insert_table">插入表格</button>
			</div>
		</div>
	</div>
</div>
<!-- 插入表格 结束 -->
<script type="text/javascript" src="/app/statics/home/js/main.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	var cn_id = '<?php echo $cn_id; ?>';
	/*------ 笔记类 ------*/
	var Note = function(editarea, btns){
		//编辑区域dom
		this.editarea = editarea;
		//编辑按钮dom
		this.btns = btns;

		this.cn_id = 0;
		this.savetime = 60;
		this.timer;

		this.bindEvent();
	};
	Note.prototype = {
		constructor: Note,
		bindEvent: function(){
			var f = this;
			//编辑按钮事件
			f.btns.on('click', 'a', function(){
				var i = f.btns.find('a').index(this);
				switch (i) {
					case 0: //代码模式
						f.codeView(f, $(this));
						break;
					case 1: //保存
						f.update(f);
						break;
					case 2: //大标题
						f.insertTitle(f, 1);
						break;
					case 3: //小标题
						f.insertTitle(f, 2);
						break;
					case 4: //小标题
						f.insertTitle(f, 3);
						break;
					case 5: //左对齐
						document.execCommand('justifyLeft');
						f.setTimer(f);
						break;
					case 6: //居中
						document.execCommand('justifyCenter');
						f.setTimer(f);
						break;
					case 7: //右对齐
						document.execCommand('justifyRight');
						f.setTimer(f);
						break;
					case 8: //加粗
						document.execCommand('bold');
						f.setTimer(f);
						break;
					case 9: //斜体
						document.execCommand('italic');
						f.setTimer(f);
						break;
				}
			});
			//字体颜色
			f.btns.on('click', '.btn-color', function(){
				document.execCommand('foreColor', false, '#' + $(this).attr('data-val'));
				f.setTimer(f);
			});
			//编辑内容事件
			f.editarea.on('keyup', function(){
				f.setTimer(f);
			});
		},
		codeView: function(f, btn){
			if(btn.attr('data-val') == '0'){
				btn.addClass("cbtn-active").attr('data-val', '1');
				f.editarea[0].contentEditable = false;
				f.editarea.html('<textarea class="form-control" rows="22">'+f.editarea.html()+'</textarea>');
				f.btns.find('button:gt(1)').hide();
			}else{
				btn.removeClass('cbtn-active').attr('data-val', '0');
				f.editarea[0].contentEditable = true;
				f.editarea.html(f.editarea.find('textarea').val());
				f.btns.find('button:gt(1)').show();
			}
		},
		refresh: function(){
			this.cn_id = 0;
			this.editarea.html('');
			this.editarea.hide();
		},
		insertTitle: function(f, types){
			var style,title;
			switch (types) {
				case 1:
					style = 'font-size:30px;color:#333;';
					title = '大号模版标题';
					break;
				case 2:
					style = 'font-size:26px;color:#666;';
					title = '中号模版标题';
					break;
				case 3:
					style = 'font-size:20px;color:#996600;';
					title = '小号模版标题';
					break;
			}
			document.execCommand('insertHTML', false, '<div style="'+style+'">'+title+'</div><br>');
		},
		setTimer: function(f){
			if(f.timer == undefined && f.cn_id != 0) {
				var limit = f.savetime;
				var btn = f.btns.find('a:eq(1)');
				f.timer = setInterval(function(){
					if(--limit > 0) {
						btn.html('<span style="color:#fa6800">'+limit+'s</span>');
					} else {
						f.update(f);
					}
				}, 1000);
			}
		},
		open: function(cn_id){
			var f = this;
			if(cn_id == f.cn_id)
				return;
			f.editarea.show();
			if(cn_id != undefined)
				f.cn_id = cn_id;
			$.get('/channel/getContent/id/'+f.cn_id, function(data){
				if(data.code == 1){
					f.editarea[0].contentEditable = true;
					f.editarea.html(data.result);
				}else{
					alert(data.error);
				}
			}, 'json');
		},
		update: function(f){
			var btn = f.btns.find('a:eq(1)');
			btn.html('<span class="glyphicon glyphicon-save"></span>');
			clearInterval(f.timer);
			f.timer = undefined;
			var ta = f.editarea.find('textarea');
			if(ta.val()){
				$.post('/channel/updateField', {cn_id: f.cn_id, field: 'cn_content', value: ta.val()});
			}else{
				$.post('/channel/updateField', {cn_id: f.cn_id, field: 'cn_content', value: f.editarea.html()});
			}
		}
	};
	/*------ 滚动目录类 ------*/
	var ScrollMenu = function(menu){
		this.menu = menu;
		this.floats = false;
		this.limit = 20;
		this.bindEvent();
	};
	ScrollMenu.prototype = {
		constructor: ScrollMenu,
		bindEvent: function(){
			var f = this;
			$(window).on('scroll', function(){
				if(f.getScrollTop() > f.limit) {
					f.menu.attr('style', "position:fixed;top:80px;z-index:2000;");
					f.floats = true;
				} else if (f.floats) {
					f.menu.attr('style', "padding: 20px 0 20px;margin-top:10px;");
					f.floats = false;
				}
			});
		},
		setLimit: function(limit){
			this.limit = limit;
		},
		getScrollTop: function() {  
			var scrollPos;  
			if (window.pageYOffset) {  
				scrollPos = window.pageYOffset; 
			} else if (document.compatMode && document.compatMode != 'BackCompat') {
				scrollPos = document.documentElement.scrollTop; 
			} else if (document.body) {
				scrollPos = document.body.scrollTop;
			}   
			return scrollPos;   
		}
	};
	//菜单滚动
	new ScrollMenu($('#note_btns'));
	//笔记编辑器
	var note = new Note($('#note_editor'), $('#note_btns'));
	note.open(cn_id);
	//插入附件
	$('#file_list').on('click', 'button', function(){
		var types = $(this).attr('data-val');
		if (types == 'jpg' || types == 'jpeg' || types == 'png' || types == 'gif') {
			document.execCommand('insertHTML', false, '<p style="text-align:center;"><img src="'+$(this).attr('data-path')+'" style="max-width:100%"/></p><br>');
		}else{
			document.execCommand('insertHTML', false, '<a href="'+$(this).attr('data-path')+'" >'+$(this).parents('tr').find('td:eq(0)').text()+'</a>');
		}
	});
	//插入表格
	$('#insert_table').on('click', function(){
		var rows = $('#tab_rows').val();
		var cols = $('#tab_cols').val();
		var pattern = /^\d+$/;
		if(pattern.test(rows) && pattern.test(cols) && rows > 0 && cols > 0){
			html = '';
			ths = '';
			tds = '';
			while (cols) {
				ths += '<th></th>';
				tds += '<td></td>';
				--cols;
			}
			if($('#tab_thead')[0].checked){
				html += '<thead style="background:#eee;"><tr>' + ths + '</tr></thead>';	
			}
			html += '<tbody>';
			while (rows) {
				html += '<tr>' + tds + '</tr>';
				--rows;
			}
			$('#note_editor').append('<table class="table table-bordered table-condensed">' + html + '</tbody></table><br>');
			$('#tab_rows').val('');
			$('#tab_cols').val('');
			$('#table_box').modal('hide');
		} else {
			alert('行数和列数请填写正整数');
		}
	});
});
</script>
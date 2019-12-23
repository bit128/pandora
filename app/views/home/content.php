<style type="text/css">
/*------ editor ------*/
body {
	background-color: #eeeeee;
}
#note_editor {
	margin-top: 10px;
	min-height: 460px;
	height: auto;
	width:100%;
	padding:10px;
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
<link href="/app/statics/home/css/editor.css" rel="stylesheet">
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
				<div class="cbtn-list"></div>
			</div>
		</div>
		<div class="col-md-10">
			<div id="note_editor" class="p-editor"></div>
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
				<a type="button" href="/home/file/bid/<?php echo $id; ?>" class="btn btn-orange">管理资源附件</a>
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
	const cn_id = '<?php echo $id; ?>';
	const cn_md = '<?php echo $model; ?>';
	const colors = ['666666','FF6666','0099CC','FFCC00','669933','996600','993399'];
	/*------ 笔记类 ------*/
	var Note = function(editarea, btns){
		//编辑区域dom
		this.editarea = editarea;
		//编辑按钮dom
		this.btns = btns;

		this.cn_id = 0;
		this.cn_md = '';
		this.savetime = 60;
		this.timer;

		this.bindEvent();
	};
	Note.prototype = {
		constructor: Note,
		bindEvent: function(){
			let f = this;
			//编辑按钮事件
			f.btns.on('click', 'a', function(){
				let i = f.btns.find('a').index(this);
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
				f.editarea.html('<textarea class="form-control" rows="22">'+f.codeFilter(f.editarea.html())+'</textarea>');
				f.btns.find('button:gt(1)').hide();
			}else{
				btn.removeClass('cbtn-active').attr('data-val', '0');
				f.editarea[0].contentEditable = true;
				f.editarea.html(f.editarea.find('textarea').val());
				f.btns.find('button:gt(1)').show();
			}
		},
		codeFilter: function(content){
			return content.replace(/\<div\>\<br\>\<\/div\>/g, '<br>');
		},
		refresh: function(){
			this.cn_id = 0;
			this.editarea.html('');
			this.editarea.hide();
		},
		insertTitle: function(f, types){
			let c,title;
			switch (types) {
				case 1:
					c = 'p-title-l';
					title = '大号标题';
					break;
				case 2:
					c = 'p-title-m';
					title = '中号标题';
					break;
				case 3:
					c = 'p-title-s';
					title = '小号标题';
					break;
			}
			document.execCommand('insertHTML', false, '<div class="'+c+'">'+title+'</div><br>');
		},
		setTimer: function(f){
			if(f.timer == undefined && f.cn_id != 0) {
				let limit = f.savetime;
				let btn = f.btns.find('a:eq(1)');
				f.timer = setInterval(function(){
					if(--limit > 0) {
						btn.html('<span style="color:#fa6800">'+limit+'s</span>');
					} else {
						f.update(f);
					}
				}, 1000);
			}
		},
		open: function(cn_id, cn_md){
			let f = this;
			if(cn_id == f.cn_id) {
				return;
			}
			f.editarea.show();
			if(cn_id != undefined) {
				f.cn_id = cn_id;
				f.cn_md = cn_md;
			}
			$.get('/channel/getHtml/id/'+f.cn_id+'/model/'+f.cn_md, function(data){
				if(data.code == 1){
					f.editarea[0].contentEditable = true;
					f.editarea.html(data.result);
					f.initColors();
				}else{
					alert(data.error);
				}
			}, 'json');
		},
		update: function(f){
			let btn = f.btns.find('a:eq(1)');
			btn.html('<span class="glyphicon glyphicon-save"></span>');
			clearInterval(f.timer);
			f.timer = undefined;
			let ta = f.editarea.find('textarea');
			let content = '';
			if(ta.val()){
				content = f.codeFilter(ta.val());
			}else{
				content = f.codeFilter(f.editarea.html());
			}
			$.post('/channel/setHtml', {id: f.cn_id, model: f.cn_md, content: content});
		},
		initColors: function(){
			let html = '';
			for (c of colors) {
				html += '<a href="javascript:;" class="btn-color" data-val="'+c+'" style="background-color:#'+c+';box-shadow:0 0 3px #'+c+';"></a> ';
			}
			this.btns.find('.cbtn-list:last').html(html);
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
			let f = this;
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
			let scrollPos;  
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
	const note = new Note($('#note_editor'), $('#note_btns'));
	note.open(cn_id, cn_md);
	//插入附件
	$('#file_list').on('click', 'button', function(){
		let types = $(this).attr('data-val');
		if (types == 'jpg' || types == 'jpeg' || types == 'png' || types == 'gif') {
			document.execCommand('insertHTML', false, '<p style="text-align:center;"><img src="'+$(this).attr('data-path')+'" style="max-width:100%"/></p><br>');
		}else{
			document.execCommand('insertHTML', false, '<a href="'+$(this).attr('data-path')+'" >'+$(this).parents('tr').find('td:eq(0)').text()+'</a>');
		}
	});
	//插入表格
	$('#insert_table').on('click', function(){
		let rows = $('#tab_rows').val();
		let cols = $('#tab_cols').val();
		let pattern = /^\d+$/;
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
				html += '<thead><tr>' + ths + '</tr></thead>';	
			}
			html += '<tbody>';
			while (rows) {
				html += '<tr>' + tds + '</tr>';
				--rows;
			}
			$('#note_editor').append('<table class="p-table">' + html + '</tbody></table><br>');
			$('#tab_rows').val('');
			$('#tab_cols').val('');
			$('#table_box').modal('hide');
		} else {
			alert('行数和列数请填写正整数');
		}
	});
});
</script>
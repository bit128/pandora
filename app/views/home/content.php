<style type="text/css">
/*------ editor ------*/
#note_editor {
	margin-top: 10px;
	font-size:16px;
	border: 1px #ddd dashed;
	border-radius: 8px;
	color:#666;
	min-height: 480px;
	height: auto;
	width:100%;
	padding:10px;
	background: #fff;
	outline:none;
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
</style>
<div class="container">
	<div class="row">
		<div class="col-md-3">
			<div style="padding: 20px 0 20px;margin-top:10px;" id="note_btns">
				<div style="text-align:center;">
					<button type="button" class="btn btn-sm btn-grew">
						<span class="glyphicon glyphicon-floppy-disk"></span> 自动保存
					</button>
					<button type="button" class="btn btn-sm btn-grew" data-val="0">
						<span class="glyphicon glyphicon-list-alt"></span> 代码模式
					</button>
				</div>
				<div style="text-align:center;margin-top:20px;">
					<span class="btn-group">
						<button type="button" class="btn btn-sm btn-grew dropdown-toggle" data-toggle="dropdown">
							字号 <span class="caret"></span>
						</button>
						<ul class="dropdown-menu">
							<li><a href="javascript:;" class="size">一号</a></li>
							<li><a href="javascript:;" class="size">二号</a></li>
							<li><a href="javascript:;" class="size">三号</a></li>
							<li><a href="javascript:;" class="size">四号</a></li>
							<li><a href="javascript:;" class="size">五号</a></li>
							<li><a href="javascript:;" class="size">六号</a></li>
							<li><a href="javascript:;" class="size">七号</a></li>
						</ul>
					</span>
					<span class="btn-group">
						<button type="button" class="btn btn-sm btn-grew dropdown-toggle" data-toggle="dropdown">
							颜色 <span class="caret"></span>
						</button>
						<ul class="dropdown-menu">
							<li><a href="javascript:;" class="color" style="color:#fff;background:#000">#000000</a></li>
							<li><a href="javascript:;" class="color" style="color:#fff;background:#333">#333333</a></li>
							<li><a href="javascript:;" class="color" style="color:#fff;background:#666">#666666</a></li>
							<li><a href="javascript:;" class="color" style="color:#fff;background:#999">#999999</a></li>
							<li><a href="javascript:;" class="color" style="color:#fff;background:#ccc">#cccccc</a></li>
							<li><a href="javascript:;" class="color" style="color:#999;background:#fff">#ffffff</a></li>
							<li><a href="javascript:;" class="color" style="color:#fff;background:#ff0000">#ff0000</a></li>
							<li><a href="javascript:;" class="color" style="color:#fff;background:#ff4e00">#ff4e00</a></li>
							<li><a href="javascript:;" class="color" style="color:#fff;background:#ff8a00">#ff8a00</a></li>
							<li><a href="javascript:;" class="color" style="color:#fff;background:#baff00">#baff00</a></li>
							<li><a href="javascript:;" class="color" style="color:#fff;background:#00fff6">#00fff6</a></li>
							<li><a href="javascript:;" class="color" style="color:#fff;background:#00c0ff">#00c0ff</a></li>
							<li><a href="javascript:;" class="color" style="color:#fff;background:#0084ff">#0084ff</a></li>
							<li><a href="javascript:;" class="color" style="color:#fff;background:#6c00ff">#6c00ff</a></li>
							<li><a href="javascript:;" class="color" style="color:#fff;background:#de00ff">#de00ff</a></li>
							<li><a href="javascript:;" class="color" style="color:#fff;background:#ff008a">#ff008a</a></li>
						</ul>
					</span>
					<span class="btn-group">
						<button type="button" class="btn btn-sm btn-grew dropdown-toggle" data-toggle="dropdown">
							背景 <span class="caret"></span>
						</button>
						<ul class="dropdown-menu">
							<li><a href="javascript:;" class="bg" style="color:#fff;background:#000">#000000</a></li>
							<li><a href="javascript:;" class="bg" style="color:#fff;background:#333">#333333</a></li>
							<li><a href="javascript:;" class="bg" style="color:#fff;background:#666">#666666</a></li>
							<li><a href="javascript:;" class="bg" style="color:#fff;background:#999">#999999</a></li>
							<li><a href="javascript:;" class="bg" style="color:#fff;background:#ccc">#cccccc</a></li>
							<li><a href="javascript:;" class="bg" style="color:#999;background:#fff">#ffffff</a></li>
							<li><a href="javascript:;" class="bg" style="color:#fff;background:#ff0000">#ff0000</a></li>
							<li><a href="javascript:;" class="bg" style="color:#fff;background:#ff4e00">#ff4e00</a></li>
							<li><a href="javascript:;" class="bg" style="color:#fff;background:#ff8a00">#ff8a00</a></li>
							<li><a href="javascript:;" class="bg" style="color:#fff;background:#baff00">#baff00</a></li>
							<li><a href="javascript:;" class="bg" style="color:#fff;background:#00fff6">#00fff6</a></li>
							<li><a href="javascript:;" class="bg" style="color:#fff;background:#00c0ff">#00c0ff</a></li>
							<li><a href="javascript:;" class="bg" style="color:#fff;background:#0084ff">#0084ff</a></li>
							<li><a href="javascript:;" class="bg" style="color:#fff;background:#6c00ff">#6c00ff</a></li>
							<li><a href="javascript:;" class="bg" style="color:#fff;background:#de00ff">#de00ff</a></li>
							<li><a href="javascript:;" class="bg" style="color:#fff;background:#ff008a">#ff008a</a></li>
						</ul>
					</span>
				</div>
				<div style="text-align:center;margin-top:20px;">
					<button type="button" class="btn btn-sm btn-grew" title="大标题">
						<span class="glyphicon glyphicon-th-list"></span> 大标题
					</button>
					<button type="button" class="btn btn-sm btn-grew" title="小标题">
						<span class="glyphicon glyphicon-list"></span> 小标题
					</button>
				</div>
				<div style="text-align:center;margin-top:20px;">
					<button type="button" class="btn btn-sm btn-grew" title="左对齐">
						<span class="glyphicon glyphicon-align-left"></span> 左对齐
					</button>
					<button type="button" class="btn btn-sm btn-grew" title="居中">
						<span class="glyphicon glyphicon-align-center"></span> 居中
					</button>
					<button type="button" class="btn btn-sm btn-grew" title="右对齐">
						<span class="glyphicon glyphicon-align-right"></span> 右对齐
					</button>
				</div>
				<div style="text-align:center;margin-top:20px;">
					<button type="button" class="btn btn-sm btn-grew" title="粗体">
						<span class="glyphicon glyphicon-bold"></span> 粗体
					</button>
					<button type="button" class="btn btn-sm btn-grew" title="斜体">
						<span class="glyphicon glyphicon-italic"></span> 斜体
					</button>
				</div>
				<div style="text-align:center;margin-top:20px;">
					<button type="button" class="btn btn-sm btn-grew" data-toggle="modal" data-target="#file_box">
						<span class="glyphicon glyphicon-font"></span> 插入资源
					</button>
					<button type="button" class="btn btn-sm btn-grew" data-toggle="modal" data-target="#table_box">
						<span class="glyphicon glyphicon-th"></span> 插入表格
					</button>
				</div>
			</div>
		</div>
		<div class="col-md-9">
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
			f.btns.on('click', 'button', function(){
				var i = f.btns.find('button').index(this);
				switch (i) {
					case 0: //保存
						f.update(f);
						break;
					case 1:
						f.codeView(f, $(this));
						break;
					case 10: //加粗
						document.execCommand('bold');
						f.setTimer(f);
						break;
					case 11: //斜体
						document.execCommand('italic');
						f.setTimer(f);
						break;
					case 5: //大标题
						f.insertTitle(f, 1);
						break;
					case 6: //小标题
						f.insertTitle(f, 2);
						break;
					case 7: //左对齐
						document.execCommand('justifyLeft');
						f.setTimer(f);
						break;
					case 8: //居中
						document.execCommand('justifyCenter');
						f.setTimer(f);
						break;
					case 9: //右对齐
						document.execCommand('justifyRight');
						f.setTimer(f);
						break;
				}
			});
			//设置字号
			f.btns.on('click', '.size', function(){
				var i = f.btns.find('.size').index(this);
				document.execCommand('fontSize', false, i + 1);
				f.setTimer(f);
			});
			//字体颜色
			f.btns.on('click', '.color', function(){
				document.execCommand('foreColor', false, $(this).text());
				f.setTimer(f);
			});
			//背景色
			f.btns.on('click', '.bg', function(){
				document.execCommand('backColor', false, $(this).text());
				f.setTimer(f);
			});
			//编辑内容事件
			f.editarea.on('keyup', function(){
				f.setTimer(f);
			});
		},
		codeView: function(f, btn){
			if(btn.attr('data-val') == '0'){
				btn.removeClass('btn-grew').addClass("btn-orange").attr('data-val', '1');
				f.editarea[0].contentEditable = false;
				f.editarea.html('<textarea class="form-control" rows="22">'+f.editarea.html()+'</textarea>');
				f.btns.find('button:gt(1)').hide();
			}else{
				btn.removeClass('btn-ornage').addClass("btn-grew").attr('data-val', '0');
				f.editarea[0].contentEditable = true;
				f.editarea.html(f.editarea.find('textarea').val());
				f.btns.find('button:gt(1)').show();
			}
		},
		refresh: function(){
			this.cn_id = 0;
			this.editarea.html('');
			this.editarea.hide();
		},/*
		getPosition: function(){
			var position = -1;
			var obj = document.getElementById('note_editor');

			if(window.getSelection()){
				position = window.getSelection().focusOffset;
			}else{
				var range = document.selection.createRange();
				range.moveStart('character', -obj.value.length);
				position = range.text.length;
			}
			return position;
		},*/
		insertTitle: function(f, types){
			var style,title;
			if(types == 1){
				style = 'font-size:28px;color:#333;';
				title = '大号模版标题';
			}else{
				style = 'font-size:20px;color:#33ccff;';
				title = '小号模版标题';
			}
			document.execCommand('insertHTML', false, '<div style="'+style+'">'+title+'</div><br>');
		},
		setTimer: function(f){
			if(f.timer == undefined && f.cn_id != 0) {
				var limit = f.savetime;
				var btn = f.btns.find('button:eq(0)');
				btn.removeClass('btn-grew').addClass('btn-orange');
				f.timer = setInterval(function(){
					if(--limit > 0) {
						btn.html('<span class="glyphicon glyphicon-floppy-disk"></span> 自动保存('+limit+'s)');
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
			var btn = f.btns.find('button:eq(0)');
			btn.html('<span class="glyphicon glyphicon-floppy-disk"></span> 自动保存');
			btn.removeClass('btn-orange').addClass('btn-grew');
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
			while(cols){
				ths += '<th></th>';
				tds += '<td></td>';
				--cols;
			}
			if($('#tab_thead')[0].checked){
				html += '<thead style="background:#eee;"><tr>' + ths + '</tr></thead>';	
			}
			html += '<tbody>';
			while(rows){
				html += '<tr>' + tds + '</tr>';
				--rows;
			}
			$('#note_editor').append('<table class="table table-bordered table-condensed">' + html + '</tbody></table><br>');
			$('#tab_rows').val('');
			$('#tab_cols').val('');
			$('#table_box').modal('hide');
		}else{
			alert('行数和列数请填写正整数');
		}
	});
});
</script>
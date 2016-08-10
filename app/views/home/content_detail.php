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
</style>
<link rel="stylesheet" type="text/css" href="/app/statics/home/css/prism.css">
<div class="container" style="position:relative;">
	<div class="row" id="note_btns" style="text-align:center;">
		<div class="col-md-4" style="padding-bottom:10px;">
			<button type="button" class="btn btn-sm btn-grew">
				<span class="glyphicon glyphicon-floppy-disk"></span> 保存
			</button>
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
		<div class="col-md-4" style="padding-bottom:10px;">
			<button type="button" class="btn btn-sm btn-grew" title="粗体">
				<span class="glyphicon glyphicon-bold"></span>
			</button>
			<button type="button" class="btn btn-sm btn-grew" title="斜体">
				<span class="glyphicon glyphicon-italic"></span>
			</button>
			<button type="button" class="btn btn-sm btn-grew" title="大标题">
				<span class="glyphicon glyphicon-th-list"></span>
			</button>
			<button type="button" class="btn btn-sm btn-grew" title="小标题">
				<span class="glyphicon glyphicon-list"></span>
			</button>
			<button type="button" class="btn btn-sm btn-grew" title="左对齐">
				<span class="glyphicon glyphicon-align-left"></span>
			</button>
			<button type="button" class="btn btn-sm btn-grew" title="居中">
				<span class="glyphicon glyphicon-align-center"></span>
			</button>
			<button type="button" class="btn btn-sm btn-grew" title="右对齐">
				<span class="glyphicon glyphicon-align-right"></span>
			</button>
		</div>
		<div class="col-md-4" style="padding-bottom:10px;">
			<span id="upload_image" style="position:relative;">
				<input id="fileImage" type="file" style="position:absolute;left:0;filter:alpha(opacity=0);opacity:0;width:83px;height:30px;" name="file_name">
				<button type="button" class="btn btn-sm btn-grew">
					<span class="glyphicon glyphicon-picture"></span> 上传图片
				</button>
			</span>
			<button type="button" class="btn btn-sm btn-grew" data-toggle="modal" data-target="#code_box">
				<span class="glyphicon glyphicon-font"></span> 插入代码
			</button>
			<button type="button" class="btn btn-sm btn-grew" data-toggle="modal" data-target="#table_box">
				<span class="glyphicon glyphicon-th"></span> 插入表格
			</button>
		</div>
	</div>
	<div id="note_editor"></div>
	<p>&nbsp;</p>
</div>
<!-- 插入代码 开始 -->
<div id="code_box" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">插入代码</h4>
			</div>
			<div class="modal-body">
				<p>
					<textarea class="form-control" rows="12" id="code_content"></textarea>
				</p>
				<div id="lang_select">
					<a href="javascript:;" class="btn btn-orange btn-sm" data-val="language-markup">标记语言</a>
					<a href="javascript:;" class="btn btn-grew btn-sm" data-val="language-javascript">JavaScript</a>
					<a href="javascript:;" class="btn btn-grew btn-sm" data-val="language-java">Java</a>
					<a href="javascript:;" class="btn btn-grew btn-sm" data-val="language-php">PHP</a>
					<a href="javascript:;" class="btn btn-grew btn-sm" data-val="language-c">C</a>
					<a href="javascript:;" class="btn btn-grew btn-sm" data-val="language-cpp">C++</a>
					<a href="javascript:;" class="btn btn-grew btn-sm" data-val="language-python">Python</a>
					<a href="javascript:;" class="btn btn-grew btn-sm" data-val="language-bash">Bash</a>
					<a href="javascript:;" class="btn btn-grew btn-sm" data-val="language-json">JSON</a>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-grew" data-dismiss="modal">关闭</button>
				<button type="button" class="btn btn-orange" id="insert_code">插入代码</button>
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
<script type="text/javascript" src="/app/statics/home/js/prism.js"></script>
<script type="text/javascript" src="/app/statics/home/js/main.js"></script>
<script type="text/javascript" src="/app/statics/home/js/ajaxfileupload.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	var ct_id = '<?php echo $ct_id; ?>';
	//菜单滚动
	new ScrollMenu($('#note_btns'));
	//笔记编辑器
	var note = new Note($('#note_editor'), $('#note_btns'));
	note.open(ct_id);
	//插入图片
	$('#upload_image').on('change', '#fileImage', function(){
		if(note.ct_id != 0) {
			$.ajaxFileUpload({
				url:'/nfs/upload',
				fileElementId:'fileImage',
				dataType: 'json',
				success: function (data, status){
					var path = data.src;
					if(path != ''){
						$('#note_editor').append('<p><img src="/nfs/image/'+path+'" style="max-width:100%;"></p><br>');
						note.setTimer(note);
					}else{
						if(data.error != '')alert(data.error);
					}
				}
			});
		}
	});
	//插入代码
	$('#lang_select').on('click', 'a', function(){
		$('#lang_select').find('a').removeClass('btn-orange').addClass('btn-grew');
		$(this).removeClass('btn-grew').addClass('btn-orange');
	});
	$('#insert_code').on('click', function(){
		var c = $('#code_content').val();
		if(c.trim().length == 0){alert('请填写内容!');$('#code_content').focus();return;}
		var t = $('#lang_select').find('.btn-orange').attr('data-val');
		c = c.replace(/&/g, '&amp;');
		c = c.replace(/"/g, '&quot;');
		c = c.replace(/</g, '&lt;');
		c = c.replace(/>/g, '&gt;');
		$('#note_editor').append('<pre><code class="'+t+'">'+c+'</code></pre><br>');
		$('#code_content').val('');
		$('#code_box').modal('hide');
		Prism.highlightAll();
		note.setTimer(note);
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
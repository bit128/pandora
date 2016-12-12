/*------ 内容管理类 ------*/
var Content = function(handle, btns, pages){
	this.handle = handle;
	this.btns = btns;
	this.pages = pages;

	this.default_title = '请填写内容标题';
	this.default_subtit = '在这里可以选择插入副标题';
	this.default_keyword = '可以选填关键字多个使用空格隔开';
	this.status_enum = [[2, '推荐'], [1, '公开'], [0, '隐藏'], [-1, '删除']];

	this.cn_id 		= 0;	//栏目编号
	this.ct_sort	= 0;	//排序方式
	this.ct_offset	= 0;	//内容列表起始位置
	this.ct_limit	= 20;	//查询行数
	this.ct_count	= 0;	//内容总数
	this.ct_pages	= 0;	//总页数
	this.ct_np		= 1;	//当前页数
	this.ct_psize	= 5;	//分页按钮个数（双倍）
	this.bindEvent();
};
Content.prototype = {
	constructor: Content,
	bindEvent: function(){
		var f = this;
		f.btns.on('click', '#content_add', function(){
			if(f.cn_id){
				f.add();
			}else{
				alert('请先选择栏目.');
			}
		});
		f.btns.on('click', '.set_sort', function(){
			$('.set_sort').removeClass('btn-success').addClass('btn-default');
			$(this).removeClass('btn-default').addClass('btn-success');
			var sort = parseInt($(this).attr('data-val'));
			switch(sort){
				case 0: $(this).attr('data-val', 1).html('<span class="glyphicon glyphicon-sort-by-attributes"></span> 最初创建'); break;
				case 1: $(this).attr('data-val', 0).html('<span class="glyphicon glyphicon-sort-by-attributes-alt"></span> 最近创建'); break;
				case 2: $(this).attr('data-val', 3).html('<span class="glyphicon glyphicon-sort-by-attributes"></span> 最初更新'); break;
				case 3: $(this).attr('data-val', 2).html('<span class="glyphicon glyphicon-sort-by-attributes-alt"></span> 最近更新'); break;
			}
			f.ct_sort = sort;
			f.ct_offset = 0;
			f.getList();
		});
		f.handle.on('change', '.set_status', function(){
			var status = $(this).val();
			var tr = $(this).parents('tr');
			if(status == '-1' && confirm('确定要删除吗？操作不可恢复')){
				f.remove(tr.attr('data-id'), function(data){
					if(data.code == 1){
						tr.remove();
					}else{
						alert(data.error);
					}
				});
			}else{
				f.update(tr.attr('data-id'), 'ct_status', status, function(data){
					if(data.code != 1)
						alert(data.error);
				});
			}
		});
		f.handle.on('click', '.set_text', function(){
			var box = $(this);
			var ct_id = box.parents('tr').attr('data-id');
			var field = box.attr('data-field');
			var ov = $(this).text();
			var input = box.html('<input type="text" value="'+ov+'">').find('input');
			input.focus();
			input.on('click', function(e){ e.stopPropagation(); });
			input.one('blur', function(){
				input.unbind();
				var nv = $(this).val();
				if(nv != '' && nv != ov){
					ov = nv;
					f.update(ct_id, field, nv, function(data){
						if (data.code != 1)
							alert(data.error);
					});
				}
				box.text(ov);
			});
			
		});
		f.handle.on('change', '.set_image input', function(){
			var ct_id = $(this).parents('tr').attr('data-id');
			var image = $(this).parent().find('img');
			$.ajaxFileUpload({
				url:'/nfs/upload',
				fileElementId:'img_'+ct_id,
				dataType: 'json',
				success: function (data, status){
					if(data.code == '1') {
						image.attr('src', '/nfs/image/'+data.src);
						f.update(ct_id, 'ct_image', data.src);
					} else {
						alert('图片可能损坏，请换一张图片');
					}
				}
			});
		});
		f.pages.on('click', 'a', function(){
			f.ct_np = parseInt($(this).text());
			f.ct_offset = (f.ct_np - 1) * f.ct_limit;
			f.pages.find('li').removeClass('active');
			$(this).parent().addClass('active');
			f.getList();
		});
	},
	add: function(cn_id){
		var f = this;
		if(cn_id != undefined)
			f.cn_id = cn_id
		if(f.cn_id){
			$.post(
				'/content/add',
				{cn_id: f.cn_id},
				function(data){
					if(data.code == 1){
						f.getList();
					}
				},
				'json'
			);
		}
	},
	update: function(ct_id, field, value, callback){
		$.post(
			'/content/update',
			{ct_id: ct_id, field: field, value: value},
			function(data){
				if(callback != undefined)
					callback(data);
			},
			'json'
		);
	},
	getList: function(cn_id){
		var f = this;
		if(cn_id != undefined){
			f.cn_id = cn_id
			f.ct_offset = 0;
			f.ct_count = 0;
			f.ct_pages = 0;
		}
		if(f.cn_id){
			$.post(
				'/content/getList',
				{offset: f.ct_offset, limit: f.ct_limit, cn_id: f.cn_id, sort: f.ct_sort},
				function(data){
					f.ct_count = parseInt(data.result.count);
					f.ct_pages = Math.ceil(f.ct_count / f.ct_limit);
					var html = '';
					$.each(data.result.result, function(i, d){
						html += '<tr data-id="'+d.ct_id+'"><td style="text-align:center;width:130px;">';
						html += '<p>'+d.ct_id+'</p>';
						html += '<a href="/home/contentDetail/id/'+d.ct_id+'" target="_blank" class="btn btn-info btn-xs edit_content"><span class="glyphicon glyphicon-pencil"></span> 编辑</a>'
						html += ' <a href="/home/contentNote/id/'+d.ct_id+'" class="btn btn-default btn-xs edit_content"><span class="glyphicon glyphicon-comment"></span> 评论</button></td>';
						html += '<td class="set_image"><input id="img_'+d.ct_id+'" type="file" style="position: absolute;filter: alpha(opacity=0);opacity:0;width:80px;height:60px;" name="file_name">';
						if(d.ct_image == ''){
							html += '<img src="/app/statics/files/images/default.jpg" class="img-responsive" style="max-width:80px;"></td>';
						}else{
							html += '<img src="/nfs/image/'+d.ct_image+'" class="img-responsive" style="max-width:80px;"></td>';
						}
						html += '<td><strong class="set_text" data-field="ct_title">'+(d.ct_title != '' ? d.ct_title : f.default_title)+'</strong><br>';
						html += '<small style="color:#999;" class="set_text" data-field="ct_subtit">'+(d.ct_subtit != '' ? d.ct_subtit : f.default_subtit)+'</small>';
						html += '<div style="font-size:10px;color:#cc63c9;" class="set_text" data-field="ct_keyword">'+(d.ct_keyword != '' ? d.ct_keyword : f.default_keyword)+'</div></td>';
						html += '<td><small><span class="text-info">(创建)</span> '+f.printTime(d.ct_ctime)+'<br><span class="text-warning">(更新)</span> '+f.printTime(d.ct_utime)+'</small></td>';
						html += '<td>'+d.ct_view+'</td>';
						html += '<td style="width:50px;"><select class="set_status">';
						for(var i=0; i<f.status_enum.length; i++){
							if(d.ct_status != f.status_enum[i][0])
								html += '<option value="'+f.status_enum[i][0]+'">'+f.status_enum[i][1]+'</option>';
							else
								html += '<option value="'+f.status_enum[i][0]+'" selected>'+f.status_enum[i][1]+'</option>';
						}
						html += '</select></td>';
					});
					f.handle.html(html);
					f.buildPage();
				},
				'json'
			);
		}
	},
	remove: function(ct_id, callback){
		$.post(
			'/content/delete',
			{ct_id: ct_id},
			function(data){
				if(callback != undefined)
					callback(data);
			},
			'json'
		);
	},
	printTime: function(timestamp){
		var date;
		if(timestamp > 0)
			date = new Date(timestamp * 1000);
		else
			date = new Date();
		var min = date.getMinutes();
		if (min < 10)
			min = '0' + min;
		return date.getMonth()+'月'+date.getDate()+'日 '+date.getHours()+':'+min;
	},
	buildPage: function() {
		var f = this;
		var html = '<ul class="pagination pagination-sm" style="margin:0px;">';
		var full = f.ct_psize * 2;
		//第一页
		if(f.ct_np == 1) {
			html += '<li class="active"><a href="javascript:;">1</a></li>';
			var i = 2;
			var e = f.ct_pages <= full ? f.ct_pages : full;
			for(; i<=e; ++i) {
				html += '<li><a href="javascript:;">'+i+'</a></li>';
			}
		}
		//最后一页
		else if(f.ct_np == f.ct_pages) {
			var i = f.ct_pages > full ? (f.ct_pages - full) : 1;
			for(; i<f.ct_pages; ++i) {
				html += '<li><a href="javascript:;">'+i+'</a></li>';
			}
			html += '<li class="active"><a href="javascript:;">'+f.ct_pages+'</a></li>';
		}
		//中间页
		else {
			var i = f.ct_np > f.ct_psize ? (f.ct_np - f.ct_psize) : 1;
			for(; i<f.ct_np; ++i) {
				html += '<li><a href="javascript:;">'+i+'</a></li>';
			}
			html += '<li class="active"><a href="javascript:;">'+f.ct_np+'</a></li>';
			var e = (f.ct_np + f.ct_psize) > f.ct_pages ? f.ct_pages : (f.ct_np + f.ct_psize);
			var j = f.ct_np + 1;
			for(; j<=e; ++j) {
				html += '<li><a href="javascript:;">'+j+'</a></li>';
			}
		}
		html += '</ul>';
		f.pages.html(html);
	}
};
/*------ 笔记类 ------*/
var Note = function(editarea, btns){
	//编辑区域dom
	this.editarea = editarea;
	//编辑按钮dom
	this.btns = btns;

	this.ct_id = 0;
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
				case 5: //加粗
					document.execCommand('bold');
					f.setTimer(f);
					break;
				case 6: //斜体
					document.execCommand('italic');
					f.setTimer(f);
					break;
				case 7: //大标题
					f.insertTitle(f, 1);
					break;
				case 8: //小标题
					f.insertTitle(f, 2);
					break;
				case 9: //左对齐
					document.execCommand('justifyLeft');
					f.setTimer(f);
					break;
				case 10: //居中
					document.execCommand('justifyCenter');
					f.setTimer(f);
					break;
				case 11: //右对齐
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
		this.ct_id = 0;
		this.editarea.html('');
		this.editarea.hide();
	},
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
	},
	insertTitle: function(f, types){
		var style,title;
		if(types == 1){
			style = 'font-size:28px;color:#333;';
			title = '大号智能标题';
		}else{
			style = 'font-size:20px;color:#500;';
			title = '小号智能标题';
		}
		document.execCommand('insertHTML', false, '<div class="title" style="'+style+'" data-val="'+types+'">'+title+'</div><br>');
	},
	setTimer: function(f){
		if(f.timer == undefined && f.ct_id != 0) {
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
	open: function(ct_id){
		var f = this;
		if(ct_id == f.ct_id)
			return;
		f.editarea.show();
		if(ct_id != undefined)
			f.ct_id = ct_id;
		$.get('/content/get/ct_id/'+f.ct_id, function(data){
			if(data.code == 1){
				f.editarea[0].contentEditable = true;
				f.editarea.html(data.result.ct_detail);
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
			$.post('/content/update', {ct_id: f.ct_id, field: 'ct_detail', value: ta.val()});
		}else{
			$.post('/content/update', {ct_id: f.ct_id, field: 'ct_detail', value: f.editarea.html()});
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
				f.menu.attr('style', "position:fixed;left:0;top:60px;width:"+$(document).width()+"px;z-index:2000;text-align:center;");
				f.floats = true;
			} else if (f.floats) {
				f.menu.attr('style', "text-align:center;");
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
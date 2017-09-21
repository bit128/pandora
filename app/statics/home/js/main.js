/**
 * 友好的警告框
 * @param {*} message 
 * @param {*} style 
 */
var alert = function(message, style){
    if (style == undefined)
        style = 'danger';
    var toast = $('#toast_box');
    message += ' <span class="glyphicon glyphicon-remove"></span>';
    if (toast.html() != undefined) {
        toast.attr('class', 'alert alert-'+style).html(message);
    } else {
        $('body').append('<div id="toast_box" class="alert alert-'+ style +'">'+message+'</div>');
        toast = $('#toast_box');
        toast.attr('style', "position:fixed;");
    }
    var left = ($(document).width() - toast.width()) / 2;
    toast.attr('style', "position:fixed;top:80px;left:"+left+'px');
    toast.fadeOut(5000);
};
/**
 * 格式化时间
 * @param {*} format    y-m-d h:i:s
 * @param {*} time      毫秒时间戳
 * @param {*} timezone  时区 
 */
var dateFormat = function(format, time){
    var date;
    if (time != undefined)
        date = new Date(time);
    else
        date = new Date();
    var date_dict = {
        'y': date.getFullYear(),
        'm': date.getMonth() + 1,
        'd': date.getDate(),
        'h': date.getHours(),
        'i': date.getMinutes(),
        's': date.getSeconds()
    }
    if (format == undefined)
        format = 'y-m-d h:i:s';
    var date_str = '';
    for(var i=0; i<format.length; i++) {
        var s = format.charAt(i);
        if (date_dict[s]) {
            date_str += date_dict[s] < 10 ? '0'+date_dict[s] : date_dict[s];
        } else {
            date_str += s;
        }  
    }
    return date_str;
};
/*------ 关键词管理 ------*/
var Keyword = function(handle){
	this.handle = handle;

	this.by_id = '';
	this.last_keyword = '';
	this.ignore = [];
	this.bindEvent();
}
Keyword.prototype = {
	constructor: Keyword,
	bindEvent: function(){
		var f = this;
		f.handle.on('click', '#select_keywords a', function(){
			var dc_id = $(this).attr('data-val');
			var a = $(this);
			var a_t = $(this).text();
			$.post(
				'/dictionary/addIndex',
				{dc_id: dc_id, by_id: f.by_id},
				function(data){
					if(data.code == 1){
						ignore.push(dc_id)
						a.remove();
						$('#keywords').append('<a href="javascript:;" class="label label-info" data-val="'
							+dc_id+'">'+a_t.split(' ')[0]+' x</a> ');
						//loadKeywordList();
					}else{
						alert(data.error);
					}
				},
				'json'
			);
		});
		f.handle.on('click', '#keywords a', function(){
			var dc_id = $(this).attr('data-val');
			var a = $(this);
			var a_t = $(this).text();
			$.post(
				'/dictionary/deleteIndex',
				{dc_id: dc_id, by_id: f.by_id},
				function(data){
					if(data.code == 1){
						for (var i=0; i<ignore.length; i++) {
							if (ignore[i] == dc_id)
								ignore.splice(i, 1);
						}
						a.remove();
						$('#select_keywords').append('<a href="javascript:;" class="label label-success" data-val="'
							+dc_id+'">'+a_t.split(' ')[0]+' +</a> ');
					}else{
						alert(data.error);
					}
				},
				'json'
			);
		});
	},
	open: function(by_id){
		var f = this;
		f.by_id = by_id;
		f.handle.modal('show');
		$.get('/dictionary/getIndex/id/'+by_id, function(data){
			if(data.code == 1){
				var html = '';
				ignore = [];
				$.each(data.result, function(i, d){
					html += '<a href="javascript:;" class="label label-info" data-val="'+d.dc_id+'">'+d.dc_keyword+' x</a> ';
					ignore.push(d.dc_id);
				});
				f.handle.find('#keywords').html(html);
				//备选关键词
				f.searchKeywords(f, -1);
			}
		}, 'json');
	},
	searchKeywords: function(f, types){
		$.get('/dictionary/getKeywordList/t/'+types, function(data){
			if(data.code == 1){
				var html = '';
				$.each(data.result, function(i, d){
					if(ignore.indexOf(d.dc_id) == -1)
						html += '<a href="javascript:;" class="label label-success" data-val="'+d.dc_id+'">'+d.dc_keyword+' +</a> ';
				});
				f.handle.find('#select_keywords').html(html);
			}
		}, 'json');
	}
};
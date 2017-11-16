<style rel="stylesheet">
    table .btn {
        margin-bottom:5px;
    }
    #data_list td {
        padding:0;
        vertical-align:middle;
        text-align:center;
    }
    #data_list td input {
        width:100%;
        padding:4px 10px 4px;
        border:0;
    }
    .channel-title {
        margin-bottom:5px;
    }
    .channel-title a {
        color: #369;
        font-weight:bold;
        font-size:15px;
    }
    .channel-index {
        font-size:12px;
    }
    .channel-index a {
        color: #396;
    }
    .breadcrumb {
        margin:0;
        font-size:12px;
        padding:7px ;
    }
    .list-active {
        color:#31708f;
        background-color:#d9edf7;
    }
</style>
<div class="container">
	<div class="row">
        <div class="col-md-5">
            <ol class="breadcrumb">
                <li></li>
                <?php
                    array_unshift($breadcrumb, ['id'=>'0','name'=>'根目录']);
                    $bc = count($breadcrumb)-1;
                    foreach ($breadcrumb as $c => $b) {
                    echo $c == $bc ? '<li>' : '<li><a href="/home/channel/fid/'.$b['id'].'">';
                    if (strlen($b['name']) > 15) {
                        echo \core\tools\MbString::substr($b['name'], 0, 5), '...';
                    } else {
                        echo $b['name'];
                    }
                    echo $c == $bc ? '</li>' : '</a></li>';
                } ?>
            </ol>
        </div>
		<div class="col-md-4">
            <?php if ($keyword == '') { ?>
			<button type="button" class="btn btn-sm btn-success" id="create_channel">
				<span class="glyphicon glyphicon-plus"></span> 创建栏目内容
			</button>
            <?php } ?>
            <span class="btn-group">
                <?php $s_uri = \core\Autumn::app()->route->reUrl(['s'=>null,'page'=>null]); ?>
                <a href="<?php echo $s_uri,'/s/',0; ?>" class="btn btn-sm <?php echo $status == 0 ? 'btn-info' : 'btn-default'; ?>">全部</a>
                <a href="<?php echo $s_uri,'/s/',1; ?>" class="btn btn-sm <?php echo $status == 1 ? 'btn-danger' : 'btn-default'; ?>">隐藏</a>
                <a href="<?php echo $s_uri,'/s/',2; ?>" class="btn btn-sm <?php echo $status == 2 ? 'btn-success' : 'btn-default'; ?>">公开</a>
                <a href="<?php echo $s_uri,'/s/',3; ?>" class="btn btn-sm <?php echo $status == 3 ? 'btn-warning' : 'btn-default'; ?>">热门</a>
            </span>
            <a href="<?php echo \core\Autumn::app()->route->reUrl(['o'=>$order==0?1:0]);?>" class="btn btn-sm btn-default">
                <?php if ($order == 0){ ?>    
                <span class="glyphicon glyphicon-sort-by-order-alt"></span>
                <?php } else { ?>
                <span class="glyphicon glyphicon-sort-by-order"></span>
                <?php } ?>
            </a>
		</div>
		<div class="col-md-3">
			<form class="input-group" method="get" action="<?php echo \core\Autumn::app()->route->reUrl(['k'=>null,'page'=>null]); ?>">
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
				<th style="width:100px;">ID</th>
				<th style="width:100px;">封面</th>
				<th style="text-align:center;">名称</th>
				<th style="width:160px;">时间</th>
				<th style="width:60px;">排序</th>
                <th style="width:80px;">状态</th>
				<th style="width:180px;">操作</th>
			</tr>
		</thead>
        <tbody id="channel_list">
            <?php foreach ($result as $item) { ?>
            <tr>
                <td><small><?php echo $item->cn_id; ?></small></td>
                <td>
                    <a href="/home/file/avatar/channel/bid/<?php echo $item->cn_id; ?>">
                    <?php if($item->cn_image == '') {
						echo '<img src="/app/statics/files/default.jpg" class="img-responsive" style="max-width:80px;">';
					}else{
						echo '<img src="/nfs/image',$item->cn_image,'" class="img-responsive" style="max-width:80px;">';
					} ?>
                    </a>
                </td>
                <td>
                    <div class="channel-title">
                        <a href="javascript:;" class="set_text" data-field="cn_name"><?php echo $item->cn_name; ?></a>
                    </div>
                    <div class="channel-index">
                        <a href="javascript:;" class="set_index">
                            <?php echo $item->cn_keyword != '' ? $item->cn_keyword : '设置关键词'; ?>
                        </a>
                    </div>
                </td>
                <td>
                    <small class="text-success"><?php echo '创建：', date('Y-m-d H:i',$item->cn_ctime); ?></small><br>
                    <small class="text-warning"><?php if($item->cn_utime) echo '更新：', date('Y-m-d H:i',$item->cn_utime); ?></small><br>
                </td>
                <td><a href="javascript:;" class="set_text" data-field="cn_sort"><?php echo $item->cn_sort; ?></a></td>
                <td>
                    <select class="set_status">
                    <?php foreach (['隐藏','公开','热门'] as $k => $v) {
                        $tk = $k + 1;
                        if ($tk != $item->cn_status)
                            echo '<option value="',$tk,'">',$v,'</option>';
                        else
                            echo '<option value="',$tk,'" selected>',$v,'</option>';
                    } ?>
                    </select>
                </td>
                <td>
                    <a href="/home/content/id/<?php echo $item->cn_id; ?>" target="_blank" class="btn btn-xs btn-default">
                        <span class="glyphicon glyphicon-print"></span> 内容
                    </a>
                    <a href="/home/file/bid/<?php echo $item->cn_id; ?>" class="btn btn-xs btn-default">
                        <span class="glyphicon glyphicon-file"></span> 资源
                    </a>
                    <button type="button" class="btn btn-xs btn-default set_data">
                        <span class="glyphicon glyphicon-list"></span> 扩展
                    </button>
                    <a href="/home/channel/fid/<?php echo $item->cn_id; ?>" class="btn btn-xs btn-success">
                        <span class="glyphicon glyphicon-tags"></span> 成员
                    </a>
                    <button type="button" class="btn btn-xs btn-info move_channel">
                        <span class="glyphicon glyphicon-move"></span> 移动
                    </button>
                    <button type="button" class="btn btn-xs btn-warning delete_channel">
                        <span class="glyphicon glyphicon-trash"></span> 删除
                    </button>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    <p><?php echo $pages; ?></p>
</div>
<!-- 移动位置 -->
<div id="menu_modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">移动到目录</h4>
            </div>
            <div class="modal-body">
                <div class="list-group" style="margin-bottom:0;" id="menu_list"></div>
            </div>
            <div class="modal-footer" style="margin-top:0;">
                <button type="button" class="btn btn-warning pull-left" id="menu_back">
                    <span class="glyphicon glyphicon-chevron-left"></span> 上一层目录
                </button>
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    <span class="glyphicon glyphicon-remove"></span> 关闭
                </button>
                <button type="button" class="btn btn-info" id="menu_move">
                    <span class="glyphicon glyphicon-ok"></span> 移动到目录
                </button>
            </div>
        </div>
    </div>
</div>
<!-- 移动位置 -->
<!-- 扩展字段 -->
<div id="data_modal" class="modal fade" tabindex="-2" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">扩展字段</h4>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>字段名称</th>
                            <th>数据内容（点击可修改）</th>
                            <th><span class="glyphicon glyphicon-cog"></span></th>
                        </tr>
                    </thead>
                    <tbody id="data_list"></tbody>
                </table>
                <div style="text-align:center;">
                    <button type="button" class="btn btn-xs btn-default" id="data_new_field">
                        <span class="glyphicon glyphicon-plus"></span> 插入新字段行
                    </button>
                    <button type="button" class="btn btn-xs btn-success" id="data_save_data">
                        <span class="glyphicon glyphicon-save"></span> 保存扩展字段数据
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- 扩展字段 -->
<!-- 设置关键字 -->
<div id="keyword_modal" class="modal fade" tabindex="-3" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <legend>选择关键字</legend>
                        <p>
                            <input id="search_keyword" type="text" class="form-control input-sm" placeholder="搜索关键词...">
                        </p>
                        <div id="keyword_search_list"></div>
                        <div id="keyword_hot_list"></div>
                    </div>
                    <div class="col-md-6">
                        <legend>已选关键字</legend>
                        <p>
                            <textarea class="form-control" id="select_keyword"></textarea>
                        </p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    <span class="glyphicon glyphicon-remove"></span> 关闭
                </button>
                <button type="button" class="btn btn-info" id="save_keyword">
                <span class="glyphicon glyphicon-save"></span> 保存关键词
                </button>
            </div>
        </div>
    </div>
</div>
<!-- 设置关键字 -->
<script type="text/javascript">
$(document).ready(function(){
    const cn_fid = '<?php echo $cn_fid; ?>';
    /*------扩展字段 ------*/
    var ExtensionData = function(modal){
        this.handle = modal;
        this.cn_id = '';
        this.data = {};
        this.data_list = this.handle.find('#data_list');
        var f = this;
        /*------ 绑定页面事件 ------*/
        //新字段
        f.handle.on('click', '#data_new_field', function(){
            f.data_list.append('<tr><td><input type="text"/></td><td><input type="text"/></td>'
                +'<td><a href="javascript:;"><span class="glyphicon glyphicon-trash"></span></a></td></tr>');
        });
        //删除字段
        f.handle.on('click', '#data_list a', function(){
            var tr = $(this).parents('tr');
            var key = $.trim(tr.find('input:eq(0)').val());
            if (f.data[key] != undefined)
                delete f.data[key];
            tr.remove();
            f.cacheData();
        });
        //插入内容
        f.handle.on('focus', '#data_list input', function(){
            var is_key = $(this).parents('tr').find('input').index(this) == 0 ? true : false;
            var input = $(this);
            var ov = $.trim(input.val());
            input.one('blur', function(){
                var nv = $.trim($(this).val());
                if (nv != ov) {
                    if (is_key && ! /^[a-zA-Z]+[a-zA-Z0-9]+$/.test(nv)) {
                        alert('字段名必须是以字母开头，字母和数字的组合，2个以上的字符');
                    } else if (is_key && f.data[nv] != undefined) {
                        alert('字段名不能重名');
                    } else {
                        ov = nv;
                        f.cacheData();
                    }
                }
                input.val(ov);
            });
        });
        //保存扩展数据
        f.handle.on('click', '#data_save_data', function(){
            $.post(
                '/channel/updateField',
                {cn_id: f.cn_id, field: 'cn_data', value: JSON.stringify(f.data)},
                function(res){
                    if (res.code == 1) {
                        f.cn_id = '';
                        f.data_list.html('');
                        f.handle.modal('hide');
                    } else {
                        alert(res.error);
                    }
                },
                'json'
            );
        });
    };
    ExtensionData.prototype = {
        constructor: ExtensionData,
        loadData: function(cn_id) {
            var f = this;
            $.get('/channel/getData/id/'+cn_id, function(res){
                if (res.code == 1) {
                    f.cn_id = cn_id;
                    f.data = res.result;
                    f.render();
                    f.handle.modal('show');
                } else {
                    alert(res.error);
                }
            }, 'json')
        },
        render: function(){
            var html = '';
            $.each(this.data, function(k, v){
                html += '<tr><td><input type="text" value="'+k
                    +'"></td><td><input type="text" value="'+v
                    +'"></td><td><a href="javascript:;"><span class="glyphicon glyphicon-trash"></span></a></td></tr>';
            });
            this.data_list.html(html);
        },
        cacheData: function(){
            var f = this;
            f.data_list.find('tr').each(function(){
                var key = $.trim($(this).find('input:eq(0) ').val());
                if (key != '')
                    f.data[key] = $(this).find('input:eq(1)').val();
            });
        }
    };
    //扩展字段
    var extensionData = new ExtensionData($('#data_modal'));
    //创建新栏目
    $('#create_channel').on('click', function(){
        if (confirm('确定要创建新栏目吗？')) {
            $.post(
                '/channel/add',
                {cn_fid: cn_fid},
                function(res) {
                    if (res.code == 1)
                        location.reload();
                    else
                        alert(res.error);
                },
                'json'
            );
        }
    });
    //设置名称/排序
    $('#channel_list').on('click', '.set_text', function(){
        var cn_id = $(this).parents('tr').find('td:eq(0)').text();
        var td = $(this).parent();
        var value = $(this).text();
        var field = $(this).attr('data-field');
        if (field == 'cn_name')
            var input = td.html('<input type="text" class="form-control" value="'+value+'">').find('input');
        else
            var input = td.html('<input type="text" value='+value+' style="width:50px;">').find('input');
        input.focus();
        input.one('blur', function(){
            if (
                field == 'cn_sort' && /^\d+$/.test($(this).val())
                || field != 'cn_sort' && $(this).val() != '' && $(this).val() != value
            ) {
                value = $(this).val();
                $.post(
                    '/channel/updateField',
                    {cn_id: cn_id, field: field, value: value},
                    function(res){
                        if (res.code != 1)
                            alert(res.error);
                    },
                    'json'
                );
            }
            td.html('<a href="javascript:;" class="set_text" data-field="'+field+'">'+value+'</a>');
        });
    });
    //设置状态
    $('#channel_list').on('change', '.set_status', function(){
        var cn_id = $(this).parents('tr').find('td:eq(0)').text();
        $.post(
            '/channel/updateField',
            {cn_id: cn_id, field: 'cn_status', value: $(this).val()},
            function(res){
                if (res.code == 1)
                    location.reload();
                else
                    alert(res.error);
            },
            'json'
        );
    });
    //扩展字段
    $('#channel_list').on('click', '.set_data', function(){
        var cn_id = $(this).parents('tr').find('td:eq(0)').text();
        extensionData.loadData(cn_id);
    });
    //删除栏目
    $('#channel_list').on('click', '.delete_channel', function(){
        if (confirm('确定要删除该栏目以及全部下级栏目和内容吗？操作不可恢复！')) {
            var cn_id = $(this).parents('tr').find('td:eq(0)').text();
            $.post(
                '/channel/deleteAll',
                {cn_id: cn_id},
                function(res) {
                    if (res.code == 1)
                        location.reload();
                    else
                        alert(res.error);
                },
                'json'
            );
        }
    });
    /*------移动到目录逻辑------*/
    (function(){
        var cn_id = '';
        var menu_stack = ['0'];
        //移动目录
        $('#channel_list').on('click', '.move_channel', function(){
            cn_id = $(this).parents('tr').find('td:eq(0)').text();
            $('#menu_modal').modal('show');
            loadMenuList();
        });
        //选中成员
        $('#menu_modal').on('click', '.list-group-item', function(){
            $('#menu_list').find('.list-group-item').removeClass('list-active');
            $(this).addClass('list-active');
        });
        //双击进入子目录
        $('#menu_list').on('dblclick', '.list-group-item', function(){
            menu_stack.push($(this).attr('data-id'));
            loadMenuList();
        });
        //返回上级目录
        $('#menu_back').on('click', function(){
            if (menu_stack.length > 1) {
                menu_stack.splice(menu_stack.length-1, 1);
                loadMenuList();
            }
        });
        //移动到选中的目录中
        $('#menu_move').on('click', function(){
            var cn_fid = $('#menu_list').find('.list-active').attr('data-id');
            if (cn_fid == undefined) {
                if (confirm('您没有选中任何目录，移动到根目录？'))
                    cn_fid = '0';
                else
                    return false;
            }
            $.post(
                '/channel/updateField',
                {cn_id: cn_id, field: 'cn_fid', value: cn_fid},
                function(res){
                    if (res.code == 1)
                        location.reload();
                    else
                        alert(res.error);
                },
                'json'
            );
            $('#menu_modal').modal('hide');
        });
        //加载目录列表
        function loadMenuList() {
            var cn_fid = menu_stack[menu_stack.length-1];
            $.post(
                '/channel/getSimpleList',
                {offset:0, limit:20, cn_fid: cn_fid},
                function(res){
                    if (res.code == 1) {
                        var html = '';
                        $.each(res.result, function(i, d){
                            if (d.cn_id != cn_id)
                                html += '<li class="list-group-item" data-id="'+d.cn_id+'">'+d.cn_name+'</li>';
                        });
                        if (html != '')
                            $('#menu_list').html(html);
                        else
                            menu_stack.splice(menu_stack.length-1, 1);
                        console.log(menu_stack);
                    }
                },
                'json'
            );
        }
    })();
    /*------设置关键字逻辑------*/
    (function(){
        var cn_id = '';
        //显示设置关键字框
        $('#channel_list').on('click', '.set_index', function(){
            cn_id = $(this).parents('tr').find('td:eq(0)').text();
            var sk = $.trim($(this).text());
            if (sk == '设置关键词')
                sk = '';
            $('#select_keyword').val(sk);
            $('#keyword_modal').modal('show');
            //加载热门关键词
            $.post(
                '/keyword/getList',
                {offset:0, limit:5, sort:2},
                function(res){
                    if (res.code == 1) {
                        var html = '';
                        $.each(res.result.result, function(i,d){
                            html += '<span class="label label-warning">'+d.kw_name+'</span> ';
                        });
                        $('#keyword_hot_list').html(html);
                    }
                },
                'json'
            );
        });
        //搜索关键词
        var search_timer;
        $('#search_keyword').on('keyup', function(){
            if (search_timer != undefined)
                clearTimeout(search_timer);
            var keyword = $(this).val();
            if (keyword == '')
                keyword = ' ';
            search_timer = setTimeout(function(){
                $.post(
                    '/keyword/getList',
                    {offset:0, limit:4, keyword:keyword, sort:1},
                    function(res){
                        var html = '';
                        if (res.code == 1) {
                            if($.trim(keyword) != '')
                                html += '<span class="label label-info">'+keyword+'</span> ';
                            $.each(res.result.result, function(i,d){
                                html += '<span class="label label-success">'+d.kw_name+'</span> ';
                            });
                            $('#keyword_search_list').html(html);
                        }
                    },
                    'json'
                );
            }, 500);
        });
        //选中关键词
        $('#keyword_modal').on('click', '.label', function(){
            var keyword = $(this).text();
            var keyword_list = $('#select_keyword').val();
            if (keyword_list.indexOf(keyword) === -1) {
                $('#select_keyword').val(keyword_list+' '+keyword);
            }
            $(this).remove();
        });
        //保存关键词
        $('#save_keyword').on('click', function(){
            $.post(
                '/channel/setKeyword',
                {cn_id: cn_id, keyword: $('#select_keyword').val()},
                function(res){
                    if (res.code == 1)
                        location.reload();
                    else
                        alert(res.error);
                },
                'json'
            );
        });
    })();
});
</script>
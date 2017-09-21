<style rel="stylesheet">
    table .btn {
        margin-bottom:5px;
    }
</style>
<div class="container">
	<div class="row">
		<div class="col-md-4">
            <?php if ($keyword == '') { ?>
			<button type="button" class="btn btn-sm btn-success" id="create_channel">
				<span class="glyphicon glyphicon-plus"></span> 创建栏目
			</button>
            <?php } if ($cn_fid != '0' || $keyword != '') { ?>
			<a href="javascript:history.back();" class="btn btn-sm btn-default">
				<span class="glyphicon glyphicon-chevron-left"></span> 返回上一页
			</a>
            <?php } ?>
		</div>
		<div class="col-md-5">
            <div style="padding-top:5px;"> 内容总数 <strong><?php echo $count; ?></strong> 个</div>
        </div>
		<div class="col-md-3">
			<form class="input-group" method="get" action="">
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
				<th style="width:180px;">管理员</th>
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
                <td><a href="javascript:;" class="set_text" data-field="cn_name"><?php echo $item->cn_name; ?></a></td>
                <td>
                    <small class="text-success"><?php echo '创建：', date('Y-m-d H:i',$item->cn_ctime); ?></small><br>
                    <small class="text-warning"><?php if($item->cn_utime) echo '更新：', date('Y-m-d H:i',$item->cn_utime); ?></small><br>
                </td>
                <td><a href="javascript:;" class="set_text" data-field="cn_sort"><?php echo $item->cn_sort; ?></a></td>
                <td><small><?php echo $item->cn_admin; ?></small></td>
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
                    <a href="/home/channel/fid/<?php echo $item->cn_id; ?>" class="btn btn-xs btn-info">
                        <span class="glyphicon glyphicon-tags"></span> 成员
                    </a><!--
                    <a href="javascript:;" class="btn btn-xs btn-default">
                        <span class="glyphicon glyphicon-comment"></span> 评论
                    </a>-->
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
<!-- 扩展字段 -->
<div id="data_modal" class="modal fade" tabindex="-1" role="dialog">
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
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success pull-left" id="data_new_field">
                    <span class="glyphicon glyphicon-plus"></span> 新字段
                </button>
                <button type="button" class="btn btn-info" id="data_save_data">
                    <span class="glyphicon glyphicon-save"></span> 保存
                </button>
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    <span class="glyphicon glyphicon-remove"></span> 关闭
                </button>
            </div>
        </div>
    </div>
</div>
<!-- 扩展字段 -->
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
            f.data_list.append('<tr><td> </td><td> </td><td><a href="javascript:;"><span class="glyphicon glyphicon-trash"></span></a></td></tr>');
        });
        //删除字段
        f.handle.on('click', '#data_list a', function(){
            var tr = $(this).parents('tr');
            var key = $.trim(tr.find('td:eq(0)').text());
            if (f.data[key] != undefined)
                delete f.data[key];
            tr.remove();
            f.cacheData();
        });
        //插入内容
        f.handle.on('click', '#data_list td', function(){
            var ins = $(this).parent().find('td').index(this);
            if (ins < 2) {
                var td = $(this);
                var value = $.trim($(this).text());
                var input = $(this).html('<input type="text" value="'+value+'">').find('input');
                input.focus();
                input.on('click', function(e){
                    e.stopPropagation();
                });
                input.one('blur', function(){
                    var v = $.trim($(this).val());
                    if (v != '' && v != value) {
                        if (ins == 0 && ! /^[a-zA-Z]+[a-zA-Z0-9]+$/.test(v)) {
                            alert('字段名必须是以字母开头，字母和数字的组合');
                        } else if (f.data[v] != undefined) {
                            alert('字段名不能重名');
                        } else {
                            value = v;
                        }
                    }
                    input.unbind();
                    td.text(value);
                    f.cacheData();
                });
            }
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
                html += '<tr><td>'+k+'</td><td>'+v+'</td><td><a href="javascript:;"><span class="glyphicon glyphicon-trash"></span></a></td></tr>';
            });
            this.data_list.html(html);
        },
        cacheData: function(){
            var f = this;
            f.data_list.find('tr').each(function(){
                var key = $.trim($(this).find('td:eq(0)').text());
                if (key != '')
                    f.data[key] = $(this).find('td:eq(1)').text();
            });
            console.log(f.data);
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
            var input = td.html('<textarea class="form-control">'+value+'</textarea>').find('textarea');
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
});
</script>
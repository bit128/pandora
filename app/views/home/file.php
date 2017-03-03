<div class="container">
    <div class="row">
        <div class="col-md-4" id="upload_file">
            <input id="fileInput" type="file" style="position:absolute;filter:alpha(opacity=0);opacity:0;width:110px;height:30px;" name="file_name">
            <button type="button" class="btn btn-sm btn-success">
                <span class="glyphicon glyphicon-plus"></span> 上传资源文件
            </button>
        </div>
        <div class="col-md-4">
            <div style="padding-top:5px;"> 文件总数 <strong><?php echo $result['count']; ?></strong> 个</div>
        </div>
        <div class="col-md-4">
            <span class="btn-group pull-right">
                <a href="/home/file/bid/<?php echo $file_bid; ?>/s/0" class="btn btn-sm <?php echo $sort == 0 ? 'btn-info' : 'btn-default'; ?>">最早创建</a>
                <a href="/home/file/bid/<?php echo $file_bid; ?>/s/1" class="btn btn-sm <?php echo $sort == 1 ? 'btn-info' : 'btn-default'; ?>">最新创建</a>
                <a href="/home/file/bid/<?php echo $file_bid; ?>/s/2" class="btn btn-sm <?php echo $sort == 2 ? 'btn-info' : 'btn-default'; ?>">最早更新</a>
                <a href="/home/file/bid/<?php echo $file_bid; ?>/s/3" class="btn btn-sm <?php echo $sort == 3 ? 'btn-info' : 'btn-default'; ?>">最新更新</a>
            </span>
        </div>
    </div>
    <p>&nbsp;</p>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>文件名</th>
                <th>类型</th>
                <th>存储路径</th>
                <th>占用空间</th>
                <th>创建时间</th>
                <th>修改时间</th>
                <th>排序</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody id="file_list">
            <?php foreach ($result['result'] as $item) { ?>
            <tr data-val="<?php echo $item->file_id; ?>">
                <td class="file_update" data-field="file_name"><?php echo $item->file_name; ?></td>
                <td><?php echo $item->file_type; ?></td>
                <td><a href="<?php echo $item->file_path; ?>"><?php echo $item->file_path; ?></a></td>
                <td><?php echo round($item->file_size / 1024, 2), ' KB'; ?></td>
                <td><?php echo date('Y-m-d H:i:s', $item->file_ctime); ?></td>
                <td><?php if ($item->file_utime > 0) echo date('Y-m-d H:i:s', $item->file_utime); ?></td>
                <td class="file_update" data-field="file_sort"><?php echo $item->file_sort; ?></td>
                <td><button type="button" class="btn btn-xs btn-warning file_delete">删除</button></td>
            <tr>
            <?php } ?>
        </tbody>
    </table>
    <p><?php echo $pages; ?></p>
</div>
<script type="text/javascript" src="/app/statics/home/js/ajaxfileupload.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    var file_bid = '<?php echo $file_bid; ?>';
	//插入图片
	$('#upload_file').on('change', '#fileInput', function(){
		$.ajaxFileUpload({
			url:'/nfs/upload',
			fileElementId:'fileInput',
			dataType: 'json',
			success: function (data, status){
				if(data.uri != ''){
					$.post(
						'/file/add',
						{file_bid: file_bid, file_path: data.uri, file_type: data.type, file_size: data.size},
						function(data){
							if(data.code == 1)
								location.reload();
							else
								alert(data.error);
						},
						'json'
						);
				}else{
					if(data.error != '')alert(data.error);
				}
			}
		});
	});
    //修改字段
    $('#file_list').on('click', '.file_update', function(){
        var td = $(this);
        var ov = td.text();
        var file_id = td.parents('tr').attr('data-val');
        var field = td.attr('data-field');
        var input = td.html('<input type="text" value="'+ov+'">').find('input');
        input.focus();
        input.on('click', function(e){
            e.stopPropagation();
        });
        input.one('blur', function(){
            var nv = $(this).val();
            if (nv != ov){
                $.post(
                    '/file/setInfo',
                    {file_id: file_id, field: field, value: nv}
                );
                ov = nv;
            }
            td.html(ov);
            input.unbind();
        });
    });
    //删除
    $('#file_list').on('click', '.file_delete', function(){
        if (confirm('确定要删除吗？')) {
            var tr = $(this).parents('tr');
            var file_id = tr.attr('data-val');
            $.post(
                '/file/delete',
                {file_id: file_id},
                function(data){
                    if (data.code == 1)
                        location.reload();
                },
                'json'
            );
        }
    });
});
</script>
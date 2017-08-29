<div class="container">
    <div class="row">
        <div class="col-md-8">
            <button type="button" class="btn btn-sm btn-success" id="new_page">
                <span class="glyphicon glyphicon-plus"></span> 添加页面
            </button>
        </div>
        <div class="col-md-4">
            <form class="input-group" method="get" action="">
                <input type="text" class="form-control input-sm" name="k" value="">
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
                <th>页面编号</th>
                <th>类型</th>
                <th>名称</th>
                <th>页头样式</th>
                <th>页脚样式</th>
                <th>修改时间</th>
                <th style="width:180px;">操作</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($result as $item) { ?>
            <tr>
                <td><?php echo $item->page_id; ?></td>
                <td>
                    <label><input type="radio" name="type_<?php echo $item->page_id; ?>" value="1" <?php if ($item->page_type == 1) echo 'checked'; ?>> 页面</label>
                    <label><input type="radio" name="type_<?php echo $item->page_id; ?>" value="0" <?php if ($item->page_type == 2) echo 'checked'; ?>> 模版</label>
                </td>
                <td><a href="javascript:;"><?php echo $item->page_name; ?></a></td>
                <td><select><option>无样式</option></select></td>
                <td><select><option>无样式</option></select></td>
                <td><small><?php echo date('Y-m-d H:i:s', $item->page_utime); ?></small></td>
                <td>
                    <span class="btn-group">
                        <button type="button" class="btn btn-xs <?php echo $item->page_status == 1 ? 'btn-success' : 'btn-default'; ?>">正常</button>
                        <button type="button" class="btn btn-xs <?php echo $item->page_status == 0 ? 'btn-warning' : 'btn-default'; ?>">停用</button>
                    </span>
                    <button type="button" class="btn btn-xs btn-info">编辑</button>
                    <button type="button" class="btn btn-xs btn-warning">删除</button>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<script type="text/javascript">
$(document).ready(function(){
    $('#new_page').on('click', function(){
        if (confirm('要创建新的页面么？')) {
            $.post(
                '/page/add',
                {},
                function(data){},
                'json'
            );
        }
    });
});
</script>
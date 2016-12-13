<div class="container">
    <div class="row">
        <div class="col-md-4">
            <span class="btn-group">
                <a href="/home/contentNote/id/<?php echo $ct_id; ?>/s/0" class="btn btn-sm <?php echo $status == 0 ? 'btn-info' : 'btn-default'; ?>">未处理</a>
                <a href="/home/contentNote/id/<?php echo $ct_id; ?>/s/1" class="btn btn-sm <?php echo $status == 1 ? 'btn-info' : 'btn-default'; ?>">已处理</a>
            </span>
        </div>
        <div class="col-md-4">
            <div style="padding-top:5px">总数：<strong><?php echo $count; ?></strong>条</div>
        </div>
    </div>
    <p>&nbsp;</p>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>内容</th>
                <th>时间</th>
                <th>电话</th>
                <th>邮箱</th>
                <th>用户</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody id="note_list">
            <?php foreach ($result as $item) { ?>
            <tr data-val="<?php echo $item->tn_id; ?>">
                <td><?php echo $item->tn_content; ?></td>
                <td><?php echo date('m月d日 H:i', $item->tn_time); ?></td>
                <td><?php echo $item->tn_phone; ?></td>
                <td><?php echo $item->tn_email; ?></td>
                <td><?php echo $item->user_id; ?></td>
                <td>
                    <select class="set_status">
                        <option value="-1">删除</option>
                        <option value="0" <?php if($status == 0) echo 'selected'; ?>>未处理</option>
                        <option value="1" <?php if($status == 1) echo 'selected'; ?>>已处理</option>
                    </select>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    <p><?php echo $pages; ?></p>
</div>
<script type="text/javascript">
$(document).ready(function(){
    $('#note_list').on('change', '.set_status', function(){
        var status= parseInt($(this).val());
        var tr = $(this).parents('tr');
        var tn_id = tr.attr('data-val');
        if(status == -1) {
            //删除
        }else{
            //更改
        }
    });
});
</script>
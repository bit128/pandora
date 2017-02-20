<div class="container">

    <div class="row">

        <div class="col-sm-3"><?php include '_nav.php'; ?></div>

        <div class="col-sm-9">

            <div class="row">
                <?php if ($contents->ct_image != '') { ?>
                <div class="col-md-3">
                    <img src="/nfs/image<?php echo $contents->ct_image; ?>" class="img-responsive" style="margin-top:12px;">
                </div>
                <div class="col-md-9">
                <?php } else { ?>
                <div class="col-md-12">
                <?php } ?>
                    <h2 class="blog-post-title"><?php echo $contents->ct_title; ?></h2>
                    <p class="blog-post-meta"><?php echo date('Y年m月d日 H:i, D', $contents->ct_ctime); ?></p>
                    <p>
                        <?php
                            $label_style = array('success','info','warning');
                            foreach ($indexs as $v) { echo '<span class="label label-',$label_style[rand(0,2)],'">',$v->dc_keyword,'</span> '; } 
                        ?>
                    </p>
                    <p>
                        <?php if ($is_coll) { ?>
                        <button type="button" class="btn btn-default" id="collect" data-val="0"><span class="glyphicon glyphicon-star"></span> 已收藏</button>
                        <?php } else { ?>
                        <button type="button" class="btn btn-default" id="collect" data-val="1"><span class="glyphicon glyphicon-star-empty"></span> 收藏</button>
                        <?php } ?>
                        
                        <a href="#comment" class="btn btn-default"><span class="glyphicon glyphicon-comment"></span> 评论<span id="cc"></span></a>
                    </p>
                </div>
            </div>
            <hr>
            <p><?php echo $contents->ct_detail; ?></p>
            <p>&nbsp;</p>
            <hr>
            <h4>有问题欢迎留言：</h4>
            <p><textarea class="form-control" id="comment"></textarea></p>
            <p>
                <button type="button" class="btn btn-sm btn-info" id="add_comment">
                    <span class="glyphiocn glyphicon-plus"></span> 
                    提交留言 ( <small id="comment_mess">还可以输入 500 字</small> )
                </button>
            </p>
            <p>&nbsp;</p>
            <div id="remark_list"></div>
            <div id="page_list" style="text-align:center;"></div>
            <p>&nbsp;</p>

        </div>

    </div>

</div>
<script type="text/javascript">
$(document).ready(function(){
    var user_id = '<?php echo \core\Autumn::app()->request->getSession('user_id')?>';
	var token = '<?php echo \core\Autumn::app()->request->getSession('token');?>';
    var ct_id = '<?php echo $contents->ct_id; ?>';
    //收藏文章
    $('#collect').on('click', function(){
        var btn = $(this);
        var op = $(this).attr('data-val');
        if (op == '1'){
            $.post(
                '/collect/add',
                {by_id: ct_id, cl_type: 1, user_id: user_id, token: token},
                function(data){
                    if (data.code == 1){
                        btn.attr('data-val', 0).html('<span class="glyphicon glyphicon-star"></span> 已收藏');
                    }else{
                        alert(data.error);
                    }
                },
                'json'
            );
        } else {
            $.post(
                '/collect/deleteByEntry',
                {by_id: ct_id, cl_type: 1, user_id: user_id, token: token},
                function(data){
                    if (data.code == 1){
                        btn.attr('data-val', 1).html('<span class="glyphicon glyphicon-star-empty"></span> 收藏');
                    }else{
                        alert(data.error);
                    }
                },
                'json'
            );
        }
    });
    //提交留言
    $('#add_comment').on('click', function(){
        var comment = $('#comment').val();
        if (comment.length <= 500) {
            $.post(
                '/content/addNote',
                {user_id: user_id, token: token, tn_content: comment, ct_id: ct_id},
                function(data){
                    if (data.code == 1) {
                        $('#comment').val('');
                        $('#comment_mess').text('还可以输入 500 字');
                        alert('您的问题提交成功，感谢您的参与～');
                    } else {
                        alert(data.error);
                    }
                },
                'json'
            );
        }
    });
    $('#comment').on('keyup', function(){
        var c = 500 - $(this).val().length;
        if (c >= 0) {
            $('#comment_mess').text('还可以输入 '+c+' 字');
        } else {
            $('#comment_mess').text('您输入的内容太多！');
        }
    });
    //载入评论列表
    (function(){
        var offset = 0
        var limit = 5;
        var npage = 1;
        var pages = 1;
        $('#page_list').on('click', 'a', function(){
            npage = parseInt($(this).text());
			offset = (npage - 1) * limit;
			$(this).find('li').removeClass('active');
			$(this).parent().addClass('active');
			loadComment();
        });
        function loadComment() {
            $.post(
                '/content/getNoteList',
                {offset: offset, limit: limit, ct_id: ct_id},
                function(data){
                    var c = data.result.count;
                    if (c > 0){
                        $('#cc').text('('+c+')');
                    }
					pages = Math.ceil(parseInt(c) / limit);
                    var html = '';
                    $.each(data.result.result, function(i,d ){
                        html += '<div class="row"> <div class="col-md-2">'
                            + '<img src="/nfs/image'+d.user_avatar+'" class="img-responsive img-rounded pull-right" style="max-width:60px;">'
                            + '</div><div class="col-md-10"><blockquote><p>['+d.user_name+'] '+printTime(d.tn_time)
                            + '<span class="pull-right" style="font-size:14px;">'
                            + '<a href="javascript:;"><span class="glyphicon glyphicon-thumbs-up"></span>('+d.tn_great+')</a>'
                            + '</span></p><p style="font-size:14px;">'+d.tn_content+'</p><p style="font-size:12px;color:#fa6800">'
                            + d.tn_remark + '</p></blockquote></div></div>';
                    });
                    $('#remark_list').html(html);
                    buildPage();
                },
                'json'
            );
        }
        function buildPage() {
            var html = '<ul class="pagination pagination-sm" style="margin:0px;">';
            var full = 10;
            var psize = 5;
            //第一页
            if(npage == 1) {
                html += '<li class="active"><a href="javascript:;">1</a></li>';
                var i = 2;
                var e = pages <= full ? pages : full;
                for(; i<=e; ++i) {
                    html += '<li><a href="javascript:;">'+i+'</a></li>';
                }
            }
            //最后一页
            else if(npage == pages) {
                var i = pages > full ? (pages - full) : 1;
                for(; i<pages; ++i) {
                    html += '<li><a href="javascript:;">'+i+'</a></li>';
                }
                html += '<li class="active"><a href="javascript:;">'+pages+'</a></li>';
            }
            //中间页
            else {
                var i = npage > psize ? (npage - psize) : 1;
                for(; i<npage; ++i) {
                    html += '<li><a href="javascript:;">'+i+'</a></li>';
                }
                html += '<li class="active"><a href="javascript:;">'+npage+'</a></li>';
                var e = (npage + psize) > pages ? pages : (npage + psize);
                var j = npage + 1;
                for(; j<=e; ++j) {
                    html += '<li><a href="javascript:;">'+j+'</a></li>';
                }
            }
            html += '</ul>';
            if (npage == 1 && pages < 2){
                $('#page_list').html('');
            }else{
                $('#page_list').html(html);
            }
            
        }
        function printTime(timestamp){
            var date;
            if(timestamp > 0)
                date = new Date(timestamp * 1000);
            else
                date = new Date();
            var min = date.getMinutes();
            if (min < 10)
                min = '0' + min;
            return date.getFullYear()+'年'+(date.getMonth()+1)+'月'+date.getDate()+'日 '+date.getHours()+':'+min;
        }
        loadComment();
    })();
});
</script>
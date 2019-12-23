<style>
    .table {
        margin-top: 10px;
    }
    .t-g tr td {
        width: 50%;
    }
    .t-p tr td:last-child, .t-i tr td:last-child {
        width: 70px;
    }
</style>
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <legend>全局配置</legend>
            <div class="text-right">
                <button class="btn btn-xs btn-info"><span class="glyphicon glyphicon-edit"></span> 新增</button>
            </div>
            <table class="table table-bordered t-g">
                <tr>
                    <td>version</td>
                    <td>1.0 alpha</td>
                </tr>
                <tr>
                    <td>build_ard</td>
                    <td>1</td>
                </tr>
                <tr>
                    <td>build_app</td>
                    <td>1</td>
                </tr>
            </table>
        </div>
        <div class="col-md-4">
            <legend>页面管理</legend>
            <div class="text-right">
                <button class="btn btn-xs btn-info"><span class="glyphicon glyphicon-edit"></span> 新增</button>
                <button class="btn btn-xs btn-success"><span class="glyphicon glyphicon-upload"></span> 上传</button>
            </div>
            <table class="table table-bordered t-p">
                <tr>
                    <td>jet.css</td>
                    <td>12</td>
                    <td>
                        <button class="btn btn-xs btn-default"><span class="glyphicon glyphicon-plus"></span></button>
                        <button class="btn btn-xs btn-warning"><span class="glyphicon glyphicon-trash"></span></button>
                    </td>
                </tr>
                <tr>
                    <td>swiper.min.js</td>
                    <td>7</td>
                    <td>
                        <button class="btn btn-xs btn-default"><span class="glyphicon glyphicon-plus"></span></button>
                        <button class="btn btn-xs btn-warning"><span class="glyphicon glyphicon-trash"></span></button>
                    </td>
                </tr>
                <tr>
                    <td>home.html</td>
                    <td>33</td>
                    <td>
                        <button class="btn btn-xs btn-default"><span class="glyphicon glyphicon-plus"></span></button>
                        <button class="btn btn-xs btn-warning"><span class="glyphicon glyphicon-trash"></span></button>
                    </td>
                </tr>
            </table>
        </div>
        <div class="col-md-4 t-i">
            <legend>图片管理</legend>
            <div class="text-right">
                <button class="btn btn-xs btn-info"><span class="glyphicon glyphicon-edit"></span> 新增</button>
                <button class="btn btn-xs btn-success"><span class="glyphicon glyphicon-upload"></span> 上传</button>
            </div>
            <table class="table table-bordered">
                <tr>
                    <td>logo.png</td>
                    <td>1</td>
                    <td>
                        <button class="btn btn-xs btn-default"><span class="glyphicon glyphicon-plus"></span></button>
                        <button class="btn btn-xs btn-warning"><span class="glyphicon glyphicon-trash"></span></button>
                    </td>
                </tr>
                <tr>
                    <td>icon-btn.png</td>
                    <td>6</td>
                    <td>
                        <button class="btn btn-xs btn-default"><span class="glyphicon glyphicon-plus"></span></button>
                        <button class="btn btn-xs btn-warning"><span class="glyphicon glyphicon-trash"></span></button>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>
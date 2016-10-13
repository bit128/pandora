<!--main-area-->
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <ol class="breadcrumb">
        <li><a href="index.html">首页</a></li>
        <li class="active">我的账户</a></li>
        <li class="active">我的订单</li>
      </ol>
    </div>
  </div>
  
  <div class="row">
   
   <div class="col-md-3 col-md-push-9">
        <div class="list-group">
         <a href="myorder.html" class="list-group-item active"><span class="badge pricef">18</span> 我的订单</a>
         <a href="myfavorite.html" class="list-group-item"><span class="badge pricef">5</span> 我的收藏</a>
         <a href="mydelivery.html" class="list-group-item">配送信息</a>
         <a href="mypassword.html" class="list-group-item">修改密码</a>
         <a href="javascript:;" class="list-group-item"><span class="text-danger">退出登录</span></a>
        </div>
      </div>
      <div class="col-md-9 col-md-pull-3">
       <h3 class="mt0">我的订单</h3>
       
       <div class="pt10">
       <!--订单表开始-->
         <!--已取消订单表格-->
       <div class="panel panel-default">
       <div class="panel-heading"><strong>2015-05-18 订单号：20150518170355</strong></div>
       <table  class="table table-condensed table-bordered">
              <tr>
                <td width="50%"><img src="/app/statics/site/img/food.jpg" class="w80" /> Mango Jerry 芒果慕斯 </td>
                <td width="7%" class="text-center">2份</td>
                <td width="7%" class="text-center"><span class="pricef">￥30</span></td>
                <td width="14%" class="text-center">货到付款支付<br />共计<span class="pricef">￥45</span><br />                  
                含配送费<span class="pricef">￥0.0</span></td>
                <td width="10%" class="text-center">已取消</td>
                <td width="12%" class="text-center"></td>
              </tr>
            </table>
         </div>
         
       <!--待付款订单表格-->
       <div class="panel panel-danger">
       <div class="panel-heading"><strong>2015-05-18 订单号：20150518170355</strong></div>
       <table  class="table table-condensed table-bordered">
              <tr>
                <td width="50%"><img src="/app/statics/site/img/food.jpg" class="w80" /> Mango慕斯 </td>
                <td width="7%" class="text-center">2份</td>
                <td width="7%" class="text-center"><span class="pricef">￥30</span></td>
                <td width="14%" rowspan="3" class="text-center">支付宝支付<br />共计<span class="pricef">￥60</span><br />                  
                含配送费<span class="pricef">￥0.0</span>
                </td>
                <td width="10%" rowspan="3" class="text-center">待付款</td>
                <td width="12%" rowspan="3" class="text-center"><a href="javascript;:" class="btn btn-default btn-sm">立即支付</a> <a href="javascript:;" class="btn btn-link btn-sm mt10">取消订单</a></td>
              </tr>
              <tr>
                <td><img src="/app/statics/site/img/food.jpg" class="w80" /> 芒果慕斯</td>
                <td  class="text-center">1份</td>
                <td  class="text-center"><span class="pricef">￥15</span></td>
              </tr>
              <tr>
                <td><img src="/app/statics/site/img/food.jpg" class="w80" /> 芒果慕斯</td>
                <td  class="text-center">1份</td>
                <td  class="text-center"><span class="pricef">￥15</span></td>
              </tr>
          </table>
         </div>
          <!--待配送订单表格-->
       <div class="panel panel-warning">
       <div class="panel-heading"><strong>2015-05-18 订单号：20150518170355</strong></div>
       <table  class="table table-condensed table-bordered">
              <tr>
                <td width="50%"><img src="/app/statics/site/img/food.jpg" class="w80" /> Mango慕斯 </td>
                <td width="7%" class="text-center">2份</td>
                <td width="7%" class="text-center"><span class="pricef">￥30</span></td>
                <td width="14%" rowspan="3" class="text-center">货到付款支付<br />共计<span class="pricef">￥60</span><br />                  
                含配送费<span class="pricef">￥0.0</span>
                 </td>
                <td width="10%" rowspan="3" class="text-center">待配送</td>
                <td width="12%" rowspan="3" class="text-center"></td>
              </tr>
              <tr>
                <td><img src="/app/statics/site/img/food.jpg" class="w80" /> 芒果慕斯</td>
                <td  class="text-center">1份</td>
                <td  class="text-center"><span class="pricef">￥15</span></td>
              </tr>
             
          </table>
         </div>
       <!--配送中订单表格-->
       <div class="panel panel-info">
       <div class="panel-heading"><strong>2015-05-18 订单号：20150518170355</strong></div>
       <table  class="table table-condensed table-bordered">
              <tr>
                <td width="50%"><img src="/app/statics/site/img/food.jpg" class="w80" /> Mango慕斯 </td>
                <td width="7%" class="text-center">2份</td>
                <td width="7%" class="text-center"><span class="pricef">￥30</span></td>
                <td width="14%" rowspan="2" class="text-center">货到付款支付<br />共计<span class="pricef">￥45</span><br />                  
                含配送费<span class="pricef">￥0.0</span></td>
                <td width="10%" rowspan="2" class="text-center">配送中</td>
                <td width="12%" rowspan="2" class="text-center">&nbsp;</td>
              </tr>
              <tr>
                <td><img src="/app/statics/site/img/food.jpg" class="w80" /> 芒果慕斯</td>
                <td  class="text-center">1份</td>
                <td  class="text-center"><span class="pricef">￥15</span></td>
              </tr>
          </table>
         </div>
       <!--已完成订单表格-->
       <div class="panel panel-success">
       <div class="panel-heading"><strong>2015-05-18 订单号：20150518170355</strong></div>
       <table  class="table table-condensed table-bordered">
              <tr>
                <td width="50%"><img src="/app/statics/site/img/food.jpg" class="w80" /> Mango慕斯 </td>
                <td width="7%" class="text-center">2份</td>
                <td width="7%" class="text-center"><span class="pricef">￥30</span></td>
                <td width="14%" rowspan="2" class="text-center">支付宝支付<br />共计<span class="pricef">￥45</span><br />                  
                含配送费<span class="pricef">￥0.0</span></td>
                <td width="10%" rowspan="2" class="text-center">已完成</td>
                <td width="12%" rowspan="2" class="text-center">&nbsp;</td>
              </tr>
              <tr>
                <td><img src="/app/statics/site/img/food.jpg" class="w80" /> 芒果慕斯</td>
                <td  class="text-center">1份</td>
                <td  class="text-center"><span class="pricef">￥15</span></td>
              </tr>
          </table>
         </div>
         <!--已完成订单表格-->
       <div class="panel panel-success">
       <div class="panel-heading"><strong>2015-05-18 订单号：20150518170355</strong></div>
       <table  class="table table-condensed table-bordered">
              <tr>
                <td width="50%"><img src="/app/statics/site/img/food.jpg" class="w80" /> Mango慕斯 </td>
                <td width="7%" class="text-center">2份</td>
                <td width="7%" class="text-center"><span class="pricef">￥30</span></td>
                <td width="14%" class="text-center">网银支付<br />共计<span class="pricef">￥45</span><br />                  
                含配送费<span class="pricef">￥0.0</span></td>
                <td width="10%" class="text-center">已完成</td>
                <td width="12%" class="text-center">&nbsp;</td>
              </tr>
            </table>
         </div>
       
       <!--订单表结束-->
       <div class="text-right">
  <ul class="pagination mtb0">
    <li class="active"><a href="#" >1</a></li>
    <li><a href="#">2</a></li>
    <li><a href="#">3</a></li>
  </ul>
</div>
<!--分页结束-->
       
      </div>
    </div>
   
  </div>
</div>
<!--main-area end-->
<!--carr-area-->
<div class="container">
  <div class="row">
    <div class="col-md-12">
    
    
     <!--购物车为空显示-->
        <!--<div class="text-center mtb80">
        <h1 class="f20">您的购物车还是空的</h1>
        <h2 class="f30"><a href="order.html" class="text-alert">去点餐 <i class="fa fa-cart-plus fa-lg"></i></a></h2>
        </div>-->
        
        <!--购物车有商品时显示开始-->
        <h1 class="f20">我的购物车 </h1>
        <div class="pt10">
          <table  class="table table-condensed">
            <thead>
              <tr>
                <th>商品</th>
                <th>单价</th>
                <th>数量</th>
                <th>小计</th>
                <th>操作</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><a href="javascript:;"><img src="/app/statics/site/img/food.jpg" class="w80" /></a> <a href="javascript:;" class="pl5">Mango Jerry 芒果慕斯</a></td>
                <td><span class="pricef">￥20.0</span></td>
                <td><input type="text" class="spinnerExample"/></td>
                <td><span class="pricef">￥20.0</span></td>
                <td><a href="javascript;:">移除</a></td>
              </tr>
              <tr>
                <td><a href="javascript:;"><img src="/app/statics/site/img/food.jpg" class="w80" /></a> <a href="javascript:;" class="pl5">金桔柠檬蜂蜜茶</a> </td>
                <td><span class="pricef">￥20.0</span></td>
                <td><input type="text" class="spinnerExample"/></td>
                <td><span class="pricef">￥20.0</span></td>
                <td><a href="javascript;:">移除</a></td>
              </tr>
              <tr>
                <td colspan="5" class=" text-right">
                  <p class="pt10">数量：<span class="pricef">5</span> 商品金额：<span class="pricef">￥80.0</span></p>
                  <p>配送费：<span class="pricef">￥0.00</span></p>
                  <p><strong class="text-danger">总计金额：<span class="pricef">￥80.0</span></strong></p></td>
              </tr>
              <tr>
                <td colspan="5"><div>
                    <p class="mt15 pull-left" ><a href="#"><i class="fa fa-trash-o"></i> 清空购物车</a></p>
                    <p class="pull-right mt10"><a class="btn btn-default btn-lg" href="/site/order">继续挑选</a> <a class="btn btn-default btn-lg" href="checkout.html">下单结算</a></p>
                  </div></td>
              </tr>
            </tbody>
          </table>
          <script type="text/javascript" src="/app/statics/site/js/jquery.spinner.js"></script> 
          <script type="text/javascript">
              $('.spinnerExample').spinner({});
          </script> 
        </div>
        <!--购物车有商品时显示结束--> 
    
    </div>
  </div>
</div>
<!--carr-area end-->
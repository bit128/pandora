<!--carr-area-->
<div class="container">
  <div class="row">
    <div class="col-md-12">
        <h1 class="f20">订单信息</h1>
        <div class=" pt10">
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
            </tbody>
          </table>
          <script type="text/javascript" src="/app/statics/site/js/jquery.spinner.js"></script> 
          <script type="text/javascript">
    $('.spinnerExample').spinner({});
</script> 
        </div>
        
        
        <h1 class="f20"><i class="fa fa-truck"></i> 配送信息 <small class="f14"><span class="label label-danger">暂仅支持池州青阳城区配送</span></small></h1>
        
        <div class="pt10 formwidth clearfix">

            <form class="form-horizontal">
              <fieldset disabled>
                <div class="form-group">
                  <label  class="col-sm-2 control-label">配送区域</label>
                  <div class="col-sm-10">
                    <div class="row pl7">
                      <div class="col-xs-3">
                        <select class="form-control input-sm">
                          <option>安徽</option>
                        </select>
                      </div>
                      <div class="col-xs-3">
                        <select class="form-control input-sm">
                          <option>池州市</option>
                        </select>
                      </div>
                      <div class="col-xs-3">
                        <select class="form-control input-sm">
                          <option>青阳县</option>
                        </select>
                      </div>
                      <div class="col-xs-3">
                        <p class="form-control-static"><a href="help-area.html">详细配送范围</a></p>
                      </div>
                    </div>
                  </div>
                </div>
              </fieldset>
              <div class="form-group">
                <label  class="col-sm-2 control-label">详细地址</label>
                <div class="col-sm-10">
                  <input  class="form-control"  placeholder="详细地址">
                </div>
              </div>
              <div class="form-group">
                <label  class="col-sm-2 control-label">收货人</label>
                <div class="col-sm-10">
                  <input  class="form-control"  placeholder="收货人">
                </div>
              </div>
              <div class="form-group">
                <label  class="col-sm-2 control-label">手机电话</label>
                <div class="col-sm-10">
                  <input  class="form-control"  placeholder="手机电话">
                </div>
              </div>
              <div class="form-group">
                <label  class="col-sm-2 control-label">留言备注</label>
                <div class="col-sm-10">
                  <textarea class="form-control" rows="3"   placeholder="如有特殊要求请备注"></textarea>
                </div>
              </div>
              <div class="form-group clearfix">
                <label  class="col-sm-2 control-label">支付方式</label>
                <div class="col-sm-10">
                <label class="radio-inline"><input type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1" checked="checked"> 货到现金付款 </label>
                <label class="radio-inline"><input type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1" checked="checked"> 支付宝 </label>
                </div>
              </div>
            </form>
  
        </div>
        
        <div class=" t-line01 text-right mt15">
        <p class="pt10">数量：<span class="pricef">5</span> 商品金额：<span class="pricef">￥80.0</span></p>
        <p>配送费：<span class="pricef">￥0.00</span></p>
        <p><strong class="text-danger">总计金额：<span class="pricef">￥80.0</span></strong></p>
        <p class="mt15"><a class="btn btn-default btn-lg" href="cart.html">返回购物车</a> <a class="btn btn-default btn-lg" href="checkdone.html">提交订单</a></p>
        </div>
        
      </div>
  </div>
</div>
<!--carr-area end-->
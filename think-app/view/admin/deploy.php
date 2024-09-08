<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>入门文档</title>
  <!-- 请勿在项目正式环境中引用该 layui.css 地址 -->
  <link href="/res/layui/css/layui.css" rel="stylesheet">
</head>
<body>

<div class="layui-bg-gray" style="padding: 16px;">
  <div class="layui-row layui-col-space15">
    <div class="layui-col-md12">
      <div class="layui-card">
        <div class="layui-card-header">指令中心</div>

          <div class="layui-card-body">
    
            <pre class="layui-code code-tailscale" lay-options="{theme: 'dark'}"></pre>
            <br>
            <form class="layui-form" action="">
              <div class="layui-form-item">
              
                <label class="layui-form-label">接收路由</label>
                <div class="layui-input-block">
                  <input type="checkbox" lay-skin="switch" lay-filter="AcceptRoutes" title="ON|OFF">
                </div>
              </div>

              <div class="layui-form-item">
                <label class="layui-form-label">通告路由</label>
                <div class="layui-inline">

                  <input type="checkbox" lay-skin="switch" lay-filter="AdvertiseRoutes" title="ON|OFF">
                  <div class="layui-input-inline" style="width: 120px;">
                    <input type="text" id="subnet" placeholder="192.168.1.0" autocomplete="off" class="layui-input"  >
                  </div>

                  <div class="layui-form-mid">/</div>
                  <div class="layui-input-inline" style="width: 80px;">
                    <input type="number"  id="cidr" placeholder="24" autocomplete="off" class="layui-input" min="8" step="8" lay-affix="number">
                  </div>

              </div>            
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- 请勿在项目正式环境中引用该 layui.js 地址 -->
<script src="//unpkg.com/layui@2.9.14/dist/layui.js"></script>  
<script>
layui.use(['form', 'laydate', 'util'], function(){
  var form = layui.form;
  var layer = layui.layer;
  var laydate = layui.laydate;
  var util = layui.util;
  var $ = layui.$;

  var tailscale_up = ["tailscale up --login-server=https://tailscale.runyf.cn"]

  // code
  layui.code({
    elem: '.code-tailscale',
    style: 'font-size: 20px;',
    code: tailscale_up[0],
    lang: '复制',
    langMarker: true,
    ln: false
  });


  // 接收路由
  form.on('switch(AcceptRoutes)', function(data){

    if(this.checked){
     
      tailscale_up[1] = "--accept-routes"
      console.log(tailscale_up.join(' '))
      $('.layui-code-line-content').text(tailscale_up.join(' '))
    }else{
      tailscale_up[1] = ""
      console.log(tailscale_up.join(' '))
      $('.layui-code-line-content').text(tailscale_up.join(' '))
    }
  });


  // 通告路由
  form.on('switch(AdvertiseRoutes)', function(data){

    if(this.checked){
      tailscale_up[2] = "--advertise-routes="+$('#subnet').val()+"/"+$('#cidr').val()
      console.log(tailscale_up.join(' '))
      $('.layui-code-line-content').text(tailscale_up.join(' '))
    }else{
      tailscale_up[2] = ""
      console.log(tailscale_up.join(' '))
      $('.layui-code-line-content').text(tailscale_up.join(' '))
    }
  });
  
  

  
});
</script>


</body>
</html>
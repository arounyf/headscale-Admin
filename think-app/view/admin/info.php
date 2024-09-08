<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>设置我的资料</title>
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="/res/layui/css/layui.css" media="all">
  <link rel="stylesheet" href="/res/adminui/dist/css/admin.css" media="all">
</head>
<body>

  <div class="layui-fluid">
    <div class="layui-row layui-col-space15">
      <div class="layui-col-md12">
        <div class="layui-card">
          <div class="layui-card-header">设置我的资料</div>
          <div class="layui-card-body" pad15>
            
            <div class="layui-form" lay-filter="">
              
              
              <div class="layui-form-item">
                <label class="layui-form-label">用户名</label>
                <div class="layui-input-inline">
                  <input type="text" name="nickname"  lay-verify="nickname"  readonly  class="layui-input">
                </div>
              </div>

              
              <div class="layui-form-item">
                <label class="layui-form-label">手机号码</label>
                <div class="layui-input-inline">
                  <input type="text" name="cellphone" value="" lay-verify="phone" autocomplete="off" class="layui-input">
                </div>
              </div>

              
              <div class="layui-form-item">
                <div class="layui-input-block">
                  <button class="layui-btn" lay-submit lay-filter="setmyinfo">确认修改</button>
                </div>
              </div>
            </div>
            
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="/res/layui/layui.js"></script>  
  <script>
  
    layui.use(function(){
    var form = layui.form;
    var layer = layui.layer;
    var $ = layui.$;

      form.on('submit(setmyinfo)', function(obj){
        layer.alert(layui.util.escape(JSON.stringify(obj.field)));
        return false;
      });
      
    });

  </script>
</html>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>设置我的密码</title>
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
          <div class="layui-card-header">修改密码</div>
          <div class="layui-card-body" pad15>
            
            <div class="layui-form" lay-filter="">
              <div class="layui-form-item">
                <label class="layui-form-label">当前密码</label>
                <div class="layui-input-inline">
                  <input type="password" name="oldPassword" lay-verify="required" lay-verType="tips" class="layui-input">
                </div>
              </div>
              <div class="layui-form-item">
                <label class="layui-form-label">新密码</label>
                <div class="layui-input-inline">
                  <input type="password" name="password" lay-verify="pass" lay-verType="tips" autocomplete="off" id="LAY_password" class="layui-input">
                </div>
                <div class="layui-form-mid layui-word-aux">6到16个字符</div>
              </div>
              <div class="layui-form-item">
                <label class="layui-form-label">确认新密码</label>
                <div class="layui-input-inline">
                  <input type="password" name="repassword" lay-verify="repass" lay-verType="tips" autocomplete="off" class="layui-input">
                </div>
              </div>
              <div class="layui-form-item">
                <div class="layui-input-block">
                  <button class="layui-btn" lay-submit lay-filter="btPassword">确认修改</button>
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
  layui.config({
    base: '/res/' // 静态资源所在路径
  }).use(['index', 'set']);

  </script>
<script>
layui.use(function(){
  var form = layui.form;
  var layer = layui.layer;
  var $ = layui.$;


  // 提交事件
  form.on('submit(btPassword)', function(data){
    var field = data.field; // 获取表单字段值
    
    console.log(field);

    $.ajax({
      url:'/api/password',
      type: 'post',
      data:field,
      dataType: 'json',
      success:function(res){
        if(res.code == 0){
          layer.msg('修改成功', {icon: 6});
          setInterval(function() { 
            parent.location.href = '/login';
          }, 1000); 
        }else{
          layer.msg(res.msg, {icon: 7});
        }
        
      }
    });
    

    
    return false; // 阻止默认 form 跳转
  });

});
</script>
  
</html>
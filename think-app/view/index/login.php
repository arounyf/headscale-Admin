<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>异地组网登录页面</title>
  <!-- 请勿在项目正式环境中引用该 layui.css 地址 -->
  <link href="/res/layui/css/layui.css" rel="stylesheet">
  <link rel="shortcut icon" href="./favicon.ico" type="image/x-icon">
</head>
<body>
<style>
.demo-login-container{width: 320px; margin: 21px auto 0;}
.demo-login-other .layui-icon{position: relative; display: inline-block; margin: 0 2px; top: 2px; font-size: 26px;}

h2{margin-top:100px;margin-bottom:50px;text-align:center;font-weight:300;font-size:30px}
#code{width:120px;height:36px;font-family:Arial,宋体;font-style:italic;font-size:24px;color:green;border:0;padding:2px 3px;letter-spacing:3px;font-weight:bolder}
#imgVcode{width:120px;height:36px}

</style>
<h2>异地组网</h2>
<form class="layui-form">
  <div class="demo-login-container">
    <div class="layui-form-item">
      <div class="layui-input-wrap">
        <div class="layui-input-prefix">
          <i class="layui-icon layui-icon-username"></i>
        </div>
        <input type="text" name="username" value="" lay-verify="required" placeholder="用户名" lay-reqtext="请填写用户名" autocomplete="off" class="layui-input" lay-affix="clear">
      </div>
    </div>
    <div class="layui-form-item">
      <div class="layui-input-wrap">
        <div class="layui-input-prefix">
          <i class="layui-icon layui-icon-password"></i>
        </div>
        <input type="password" name="password" value="" lay-verify="required" placeholder="密   码" lay-reqtext="请填写密码" autocomplete="off" class="layui-input" lay-affix="eye">
      </div>
    </div>
    <div class="layui-form-item">
      <div class="layui-row">
        <div class="layui-col-xs7">
          <div class="layui-input-wrap">
            <div class="layui-input-prefix">
              <i class="layui-icon layui-icon-vercode"></i>
            </div>
            <input type="text" name="vcode" value="" lay-verify="required" placeholder="验证码" lay-reqtext="请填写验证码" autocomplete="off" class="layui-input" lay-affix="clear">
          </div>
        </div>
        <div class="layui-col-xs5">
          <div style="margin-left: 10px;">
            <img src="{:captcha_src()}"  id="imgVcode"  onclick="this.src='{:captcha_src()}?tm='+Math.random()">
          </div>
        </div>
      </div>
    </div>
    <div class="layui-form-item">
    <a href="#reg"  id="reg" style="float: left; margin-top: 7px;">注册账号</a>
      <a href="#forget" id="forget" style="float: right; margin-top: 7px;">忘记密码？</a>
    </div>
    <div class="layui-form-item">
      <button class="layui-btn layui-btn-fluid" lay-submit lay-filter="demo-login">登录</button>
    </div>

  </div>
</form>
  



<!-- 请勿在项目正式环境中引用该 layui.js 地址 -->
<script src="/res/layui/layui.js"></script> 

<script>
layui.use(function(){
  var form = layui.form;
  var layer = layui.layer;
  var $ = layui.$;

  
  //取到get参数
  const search = new URLSearchParams(location.search)
  $('input[name="username"]').val(search.get('username'));


  // 提交事件
  form.on('submit(demo-login)', function(data){
    var field = data.field; // 获取表单字段值
    
    console.log(field);

    $.ajax({
      url:'./index_api/login',
      type: 'post',
      data:field,
      dataType: 'json',
      success:function(res){
        if(res.code == 0){
          layer.msg('登录成功', {icon: 6});
          setInterval(function() { 
              location.href="admin"
          }, 1000); 
        }else{
          layer.msg(res.msg, {icon: 7});
          $("#imgVcode").attr("src","{:captcha_src()}?tm="+Math.random());
        }
        
      }
    });
    

    
    return false; // 阻止默认 form 跳转
  });


  $("#forget").click(function(){
    layer.msg("暂未开放", {icon: 7});
  });

  $("#reg").click(function(){
    location.href="reg"
  });

});
</script>
</body>
</html>
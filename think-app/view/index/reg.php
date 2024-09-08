<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>注册</title>
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="/res/layui/css/layui.css" rel="stylesheet">
  <link href="/res/adminui/dist/css/admin.css" rel="stylesheet">
  <link href="/res/adminui/dist/css/login.css" rel="stylesheet">
</head>
<body>
  <style>
    h2{margin-top:-35px;margin-bottom:50px;text-align:center;font-weight:300;font-size:30px}
    #code{width:120px;height:36px;font-family:Arial,宋体;font-style:italic;font-size:24px;color:green;border:0;padding:2px 3px;letter-spacing:3px;font-weight:bolder}
    #imgVcode{width:120px;height:36px}
  </style>
  <div class="layadmin-user-login layadmin-user-display-show" id="LAY-user-login" style="display: none;">
    <div class="layadmin-user-login-main">
      <div class="layadmin-user-login-box layadmin-user-login-header">
        <h2>账户注册</h2>
      </div>
      <form class="layui-form">
        <div class="layadmin-user-login-box layadmin-user-login-body layui-form">

          <div class="layui-form-item">
            <label class="layadmin-user-login-icon layui-icon layui-icon-username" for="LAY-user-login-nickname"></label>
            <input type="text" name="username" id="LAY-user-login-nickname" lay-verify="nickname" placeholder="昵称" class="layui-input">
          </div>
          
          <div class="layui-form-item">
            <label class="layadmin-user-login-icon layui-icon layui-icon-cellphone" for="LAY-user-login-cellphone"></label>
            <input type="text" name="cellphone" id="LAY-user-login-cellphone" lay-verify="phone" placeholder="手机" class="layui-input">
          </div>

          <div class="layui-form-item">
            <label class="layadmin-user-login-icon layui-icon layui-icon-password" for="LAY-user-login-password"></label>
            <input type="password" name="password" id="LAY-user-login-password" lay-verify="pass" placeholder="密码" class="layui-input " lay-affix="eye">
          </div>

          <div class="layui-form-item">
            <label class="layadmin-user-login-icon layui-icon layui-icon-password" for="LAY-user-login-repass"></label>
            <input type="password" name="repass" id="LAY-user-login-repass" lay-verify="required" placeholder="确认密码" class="layui-input" lay-affix="eye">
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
            <input type="checkbox" name="agreement" lay-skin="primary" title="同意用户协议" checked>
          </div>

          <div class="layui-form-item">
            <button class="layui-btn layui-btn-fluid" lay-submit lay-filter="LAY-user-reg-submit">注 册</button>
          </div>

          <a href="login" class="layadmin-user-jump-change layadmin-link layui-hide-xs">用已有帐号登入</a>
          <a href="login" class="layadmin-user-jump-change layadmin-link layui-hide-sm layui-show-xs-inline-block">登入</a>
      
        </div>
      </from>
    
      <div class="layui-trans layadmin-user-login-footer">
      
      <p>© All Rights Reserved </p>

    </div>

  </div>

  <script src="/res/layui/layui.js"></script>  
  <script>
  layui.use(function(){
    var form = layui.form;
    var layer = layui.layer;
    var $ = layui.$;



    //提交事件
    form.on('submit(LAY-user-reg-submit)', function(obj){
      var field = obj.field;
      
      //确认密码
      if(field.password !== field.repass){
        return layer.msg('两次密码输入不一致');
      }
      
      //是否同意用户协议
      if(!field.agreement){
        return layer.msg('你必须同意用户协议才能注册');
      }
      
      //请求接口
      console.log(field);

      $.ajax({
        url:'./index_api/reg',
        type: 'post',
        data:field,
        dataType: 'json',
        success:function(res){
          if(res.code == 0){
            layer.msg('注册成功', {icon: 6});
            setInterval(function() { 
                location.href="login?username="+obj.field.username
            }, 1000); 
          }else{
            layer.msg(res.msg, {icon: 7});
            $("#imgVcode").attr("src","{:captcha_src()}?tm="+Math.random());
          }
          
        }
      });
      
      return false;
    });
  });
  </script>
</html>
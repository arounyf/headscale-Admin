<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>小远异地组网 - 安全高效的创建私有网络</title>
  <!-- 请勿在项目正式环境中引用该 layui.css 地址 -->
  <link href="/res/layui/css/layui.css" rel="stylesheet">
</head>
<body>
<style>
  h1{
    color: #16baaa;
    text-align: center;
    margin-top: 100px;
  }
  #reg{
    width: 200px;
    margin-top: 100px;
    margin-left: auto;
    margin-right: auto;
  }
  .layui-nav{
    background: rgba(128, 128, 128, 0.8);
  }


  html, body {
    margin: 0;
    padding: 0;
  }
  .background {
    position:absolute;  
    display :block; 
    top : 0;   
    left: 0;
    z-index: -1;
  }
</style>
  
<canvas class="background"></canvas>

<ul class="layui-nav">
  <li class="layui-nav-item"><a href="">headscale-Admin</a></li>
  <li class="layui-nav-item"><a href="https://www.runyf.cn">about</a></li>

  <!-- <li class="layui-nav-item"><a href="">菜单3</a></li> -->
</ul>
<h1 id="title">异地组网中心</h1>
<div id="reg">
    <button type="button" class="layui-btn layui-btn-lg reg">注册</button>
    <button type="button" class="layui-btn layui-btn-lg login">登录</button>
</div>

<div class="layui-bg" style="padding: 16px;margin-top: 100px">
  <div class="layui-row layui-col-space15">
  <div class="layui-col-md3"></div>
    <div class="layui-col-md3">
      <div class="layui-card">
        <div class="layui-card-header">概述</div>
        <div class="layui-card-body">
        headscale-Admin异地组网是基于开源项目headscale开发，是一款基于Wireguard协议构建的现代异地组网工具
        </div>
      </div>
    </div>
    <div class="layui-col-md3">
      <div class="layui-card">
        <div class="layui-card-header">适用</div>
        <div class="layui-card-body">
          支持windows、linux、安卓、苹果等等各种设备
        </div>
      </div>
    </div>
    <div class="layui-col-md3"></div>
  </div>
  <div class="layui-row layui-col-space15">
    <div class="layui-col-md3"></div>
    <div class="layui-col-md3">
      <div class="layui-card">
        <div class="layui-card-header">速度</div>
        <div class="layui-card-body">
          90%的情况下可以使用p2p直连，即使失败也可以获得高达200Mbps的中转速率
        </div>
      </div>
    </div>
    <div class="layui-col-md3">
      <div class="layui-card">
        <div class="layui-card-header">计划</div>
        <div class="layui-card-body">
          计划在全国多地搭建中转服务器
        </div>
      </div>
    </div>
    <div class="layui-col-md3"></div>
  </div>
</div>
  

<!-- 请勿在项目正式环境中引用该 layui.js 地址 -->
<script src="/res/particles/particles.min.js"></script>
<script src="/res/layui/layui.js"></script>
<script>
  window.onload= function() {
    Particles.init({
      // Normal options
      selector: '.background',
      maxParticles: 200,
      color: '#48F2E3',
      connectParticles: true,

      
    });
  };

  layui.use(function(){
    var form = layui.form;
    var layer = layui.layer;
    var $ = layui.$;
    
    $('.reg').click(function() {
      window.location.href = "reg"; 
    });

    $('.login').click(function() {
      window.location.href = "login"; 
    });

  });
  
</script>
</body>
</html>
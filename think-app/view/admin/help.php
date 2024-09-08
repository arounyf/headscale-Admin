<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>入门文档</title>
  <!-- 请勿在项目正式环境中引用该 layui.css 地址 -->
  <link href="/res/layui/css/layui.css" rel="stylesheet">
</head>
<style>
  a{
    color: #ff5722;
  }
  a:hover{
    color: red;
  }
</style>
<body>

<div class="layui-bg-gray" style="padding: 16px;">
  <div class="layui-row layui-col-space15">
    <div class="layui-col-md12">
      <div class="layui-card">
        <div class="layui-card-header">文档中心</div>
          <div class="layui-card-body">
            

              <h3><a href="https://www.runyf.cn/archives/467/" target="_blank">windows安装教程</a> </h3>
              <br>
              <h3><a href="https://www.runyf.cn/archives/473/" target="_blank">安卓安装教程</a> </h3>
              <br>
              <h3><a href="https://www.runyf.cn/archives/475/" target="_blank">Linux安装教程</a></h3>


          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- 请勿在项目正式环境中引用该 layui.js 地址 -->
<script src="//unpkg.com/layui@2.9.14/dist/layui.js"></script>  
<script>
layui.use(function(){
  // code
  layui.code({
    elem: '.code-demo'
  });
})
</script>

</body>
</html>
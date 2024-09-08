<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>出错了</title>
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="/res/layui/css/layui.css" media="all">
  <link rel="stylesheet" href="/res/adminui/dist/css/admin.css" media="all">
</head>
<body>


<div class="layui-fluid">
  <div class="layadmin-tips">
    <i class="layui-icon" face>&#xe664;</i>
    
    <div class="layui-text" style="font-size: 20px;">
      <?php echo htmlentities($message); ?>
    </div>
    
  </div>
</div>


  <script src="/res/layui/layui.js"></script>  
  <script>
  layui.config({
    base: '/res/' // 静态资源所在路径
  }).use(['index']);


  setInterval(function() { 
    parent.location.href = '/';
  }, 3000); 
  </script>
</html>
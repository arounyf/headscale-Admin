<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>layui table 组件综合演示</title>
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="/res/layui/css/layui.css" rel="stylesheet">
  <link href="/res/adminui/dist/css/admin.css" rel="stylesheet">
</head>
<body>


  
  <div class="layui-fluid">
    <div class="layui-row layui-col-space15">
      <div class="layui-col-md12">
        <div class="layui-card">
          <div class="layui-card-header">日志中心</div>
          <div class="layui-card-body">
            <table class="layui-hide" id="test-table-index" lay-filter="test-table-index"></table>

            <script type="text/html" id="toolbarDemo">
              <div class="layui-btn-container">
                <button class="layui-btn layui-btn-sm" lay-event="reload">刷新</button>
              </div>
            </script>
                

          </div>
        </div>
      </div>
    </div>
  </div>
  
  <script src="/res/layui/layui.js"></script>  
  <script>

  layui.config({
    base: '/res/' // 静态资源所在路径
  }).use(['index', 'table', 'dropdown','form'], function(){
    var table = layui.table
    ,form = layui.form
    ,$ = layui.$;
    var dropdown = layui.dropdown;





    
    // 创建渲染实例
    table.render({
      elem: '#test-table-index'
      ,url: '/api/getLogs' // 此处为静态模拟数据，实际使用时需换成真实接口
      ,toolbar: '#toolbarDemo'
      ,defaultToolbar: ['filter', 'exports', 'print', {
        title: '帮助'
        ,layEvent: 'LAYTABLE_TIPS'
        ,icon: 'layui-icon-tips'
      }]
      ,height: 'full-100' // 最大高度减去其他容器已占有的高度差
      ,cellMinWidth: 80
      ,totalRow: true // 开启合计行
      ,page: true
      ,cols: <?php echo htmlspecialchars_decode($cols_data);?>
      ,error: function(res, msg){
        console.log(res, msg)
      }
    });

    

    // 工具栏事件
    table.on('toolbar(test-table-index)', function(obj){
      var $ = layui.$;
      var util = layui.util;
      var id = obj.config.id;
      var checkStatus = table.checkStatus(id);
      var othis = lay(this);
      switch(obj.event){

        case 'reload':
          var data = checkStatus.data;
          table.reload('test-table-index',true);
        break;

      };
    });




  });
  </script>
</html>
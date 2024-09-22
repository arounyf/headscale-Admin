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
          <div class="layui-card-header">预共享密钥中心</div>
          <div class="layui-card-body">
            <table class="layui-hide" id="test-table-index" lay-filter="test-table-index"></table>

            <script type="text/html" id="toolbarDemo">
              <div class="layui-btn-container">
                <button class="layui-btn layui-btn-sm" lay-event="add">新建</button>
                <button class="layui-btn layui-btn-sm" lay-event="reload">刷新</button>
              </div>
            </script>
             


            <script type="text/html" id="barDemo">
              <!-- 这里的 checked 的状态只是演示 -->
               <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
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
      ,url: '/api/getPreAuthKey' // 此处为静态模拟数据，实际使用时需换成真实接口
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
          table.reload('test-table-index',true);
        break;
        case 'add':
          layer.confirm('真的需要使用吗', function(index){
            $.ajax({
              url:'/api/addKey',
              type: 'post',
              dataType: 'json',
              success:function(res){
                if(res.code == 0){
                  layer.msg('新建成功', {icon: 6});
                }else{
                  layer.msg('新建失败', {icon: 7});
                }
                
              }
            });
            table.reload('test-table-index',true);
          });
          
        break;

      
      };
    });
   
    //触发单元格工具事件
    table.on('tool(test-table-index)', function(obj){ // 双击 toolDouble
      var $ = layui.$;
      var data = obj.data;
      // console.log(obj)
      if(obj.event === 'del'){
        layer.confirm('真的删除行么', function(index){
          obj.del();
          layer.close(index);

          $.ajax({
            url:'/api/delKey',
            type: 'post',
            dataType: 'json',
            data: {key_id: obj.data.id},
            success:function(res){
              if(res.code == 0){
                layer.msg('删除成功', {icon: 6});
              }else{
                layer.msg('删除失败', {icon: 7});
              }
              
            }
          });
          
        });
      }
    });


   

  });
  </script>
</html>

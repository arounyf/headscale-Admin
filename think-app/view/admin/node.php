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
          <div class="layui-card-header">节点中心</div>
          <div class="layui-card-body">
            <table class="layui-hide" id="test-table-index" lay-filter="test-table-index"></table>

            <script type="text/html" id="toolbarDemo">
              <div class="layui-btn-container">
              <button class="layui-btn layui-btn-sm" lay-event="addNode">添加设备</button>
                <button class="layui-btn layui-btn-sm" lay-event="reload">刷新</button>
                
                <button class="layui-btn layui-btn-sm layui-btn-primary" lay-event="multi-row">
                  多行
                </button>
                <button class="layui-btn layui-btn-sm layui-btn-primary" lay-event="default-row">
                  单行
                </button>

              </div>
            </script>

            <script type="text/html" id="TPL-lastTime">  
                {{#  
                  var util = layui.util;
                  var lastTime = function(){
                    return util.timeAgo(d.lastTime);
                  }; 
                }}
                {{= lastTime() }}
            </script>               

            <script type="text/html" id="barDemo">
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
  }).use(['index', 'table', 'dropdown'], function(){
    var table = layui.table;
    var form = layui.form;
    var dropdown = layui.dropdown;
    var laydate = layui.laydate;
    var util = layui.util;
    var $ = layui.$;
    


    
    // 创建渲染实例
    table.render({
      elem: '#test-table-index'
      ,url: '/api/getMachine' // 此处为静态模拟数据，实际使用时需换成真实接口
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





    //事件-单元格编辑
    table.on('edit(test-table-index)', function(obj){
      var value = obj.value //得到修改后的值
      ,data = obj.data //得到所在行所有键值
      ,field = obj.field; //得到字段

      console.log(field)


      if (field == "name"){
        $.ajax({
        url:'/api/rename',
        type: 'post',
        dataType: 'json',
        data: {machine_id: obj.data.id,machine_name: obj.value},
        success:function(res){
            // console.log(res.code)
            if(res.code == 0){
              layer.msg('修改成功', {icon: 6});
              var field = 'name' //得到字段
              ,value = obj.value //得到修改后的值
              ,data = obj.data; //得到所在行所有键值
              var update = {};
              update[field] = value;
              obj.update(update);
            }else{
              layer.msg('修改失败', {icon: 7});
            }
          }
        });
      }else if(field == "userName"){
        $.ajax({
        url:'/api/new_owner',
        type: 'post',
        dataType: 'json',
        data: {node_id: data.id,user_name: value},
        success:function(res){
            // console.log(res.code)
            if(res.code == 0){
              layer.msg(res.msg, {icon: 6});
            }else{
              layer.msg('修改失败', {icon: 7});
            }
          }
        });
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
        case 'addNode':
          layer.prompt({title: '请输入节点id'}, function(value, index, elem){
            if(value === '') return elem.focus();


            $.ajax({
              url:'/api/addNode',
              type: 'post',
              dataType: 'json',
              data: {nodekey: util.escape(value)},
              success:function(res){
                  console.log(res)
                  if(res.code == 2){
                    layer.msg('输入错误', {icon: 7});
                  }else{
                    layer.msg('添加成功', {icon: 6});
                    table.reload('test-table-index',true);
                  }
              }
            });

        
            // 关闭 prompt
            layer.close(index);
          });
        break;
        case 'reload':
          var data = checkStatus.data;
          table.reload('test-table-index',true);
        break;


        case 'multi-row':
          table.reload('test-table-index', {
            // 设置行样式，此处以设置多行高度为例。若为单行，则没必要设置改参数 - 注：v2.7.0 新增
            lineStyle: 'height: 95px;' 
          });
          layer.msg('已设为多行显示');
        break;
        case 'default-row':
          table.reload('test-table-index', {
            lineStyle: null // 恢复单行
          });
          layer.msg('已设为单行显示');
        break;
        case 'LAYTABLE_TIPS':
          layer.alert('Table for layui-v'+ layui.v);
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
            url:'/api/delNode',
            type: 'post',
            dataType: 'json',
            data: {machine_id: obj.data.id},
            success:function(res){
              layer.msg('删除成功', {icon: 6});
            }
          });
          
        });
      }
    });
   


  });
  </script>
</html>
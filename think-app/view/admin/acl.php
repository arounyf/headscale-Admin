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
          <div class="layui-card-header">访问控制中心</div>
          <div class="layui-card-body">
            <table class="layui-hide" id="test-table-index" lay-filter="test-table-index"></table>

            <script type="text/html" id="toolbarDemo">
              <div class="layui-btn-container">
                <button class="layui-btn layui-btn-sm" lay-event="writeConfig">写入配置</button>
                <button class="layui-btn layui-btn-sm" lay-event="readConfig">读取配置</button>
                <button class="layui-btn layui-btn-sm" lay-event="reload">重载配置</button>
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
      ,url: '/api/getAcls' // 此处为静态模拟数据，实际使用时需换成真实接口
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
      ,cols: [[
        {type: 'checkbox'}
        ,{field:'id', title:'ID', width:10, unresize: true, sort: true, totalRowText: '合计：'}
        ,{field:'user_name', title:'用户名',width:180,totalRow: '{{= d.TOTAL_ROW.count   }} 😊'} 
        ,{field:'acl', title:'ACL',width:800,edit: 'text'}
    
      ]]
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

        case 'writeConfig':
          $.ajax({
            url:'/api/rewrite_acl',
            type: 'post',
            dataType: 'json',
            success:function(res){
              if(res.code == 0){
                layer.msg(res.msg, {icon: 6});
              }else{
                layer.msg(res.msg, {icon: 7});
              }
            }
          });
        break;
        case 'readConfig':
          $.ajax({
            url:'/api/read_acl',
            type: 'post',
            dataType: 'json',
            success:function(res){
              if(res.code == 0){
                // 在此处输入 layer 的任意代码
                layer.open({
                  type: 1, // page 层类型
                  area: ['1000px', '500px'],
                  title: 'ACL',
                  shade: 0.6, // 遮罩透明度
                  shadeClose: true, // 点击遮罩区域，关闭弹层
                  maxmin: true, // 允许全屏最小化
                  anim: 0, // 0-6 的动画形式，-1 不开启
                  content: (res.data).replace(/},/g, "<br>")
                });
              }else{
                layer.msg(res.msg, {icon: 7});
              }
            }
          });
        break;
        case 'reload':
          var data = checkStatus.data;
          // table.reload('test-table-index',true);
          $.ajax({
            url:'/api/reload',
            type: 'post',
            dataType: 'json',
            success:function(res){
              if(res.code == 0){
                layer.msg(res.msg, {icon: 6});
              }
            }
          });
        break;

      
      };
    });


    //事件-单元格编辑
    table.on('edit(test-table-index)', function(obj){
      var value = obj.value //得到修改后的值
      ,field = obj.field; //得到字段

      $.ajax({
        url:'/api/re_acl',
        type: 'post',
        dataType: 'json',
        data: {acl_id: obj.data.id,new_acl: obj.value},
        success:function(res){
          // console.log(res.code)
          if(res.code == 0){
            layer.msg(res.msg, {icon: 6});
            var field = 'name' //得到字段
            var value = obj.value //得到修改后的值

            var update = {};
            update[field] = value;
            obj.update(update);
          }else{
            layer.msg(res.msg, {icon: 7});
          }
        }
      });


    });



  });
  </script>
</html>

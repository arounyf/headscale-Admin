<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>用户中心</title>
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
          <div class="layui-card-header">用户中心</div>
          <div class="layui-card-body">
            <table class="layui-hide" id="test-table-index" lay-filter="test-table-index"></table>

            <script type="text/html" id="toolbarDemo">
              <div class="layui-btn-container">
                <!-- <button class="layui-btn layui-btn-sm" lay-event="addNode">添加设备</button> -->
                <button class="layui-btn layui-btn-sm" lay-event="reload">刷新</button>
                
                <button class="layui-btn layui-btn-sm layui-btn-primary" lay-event="multi-row">
                  多行
                </button>
                <button class="layui-btn layui-btn-sm layui-btn-primary" lay-event="default-row">
                  单行
                </button>

              </div>
            </script>
                          
            <script type="text/html" id="barDemo">
              <input type="checkbox" name="启用" lay-skin="switch" lay-text="是|否" lay-filter="test-table-sexDemo"
                value="{{ d.enable }}" data-json="{{ encodeURIComponent(JSON.stringify(d)) }}" {{ d.enable == "1" ? 'checked' : '' }}>
                  &nbsp;
              <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
            </script>  



            <script type="text/html" id="TPL-expire">  
              {{# 
                var util = layui.util; 
                var result;
                var countdown = util.countdown({
                  date: d.expire,
                  now: new Date(),
                  ready: function(){ 
                    clearTimeout(util.countdown.timer); 
                  },
                  clock: function(obj, inst){  
                    if (obj.d <=30){
                      result = [obj.d,'天',obj.h,'时',obj.m,'分',obj.s,'秒'].join(' ');
                    }else{
                      result = d.expire
                    }
                    util.countdown.timer = inst.timer; 
                  },
                  done: function(obj, inst){
                    result = "已到期";
                  }
                });
              }}
              {{= result }}
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
      ,url: '/api/getUsers' // 此处为静态模拟数据，实际使用时需换成真实接口
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
        {type: 'checkbox', fixed: 'left'}
        ,{field:'id', fixed: 'left', width:80, title: 'ID', sort: true, totalRowText: '合计：'}
        ,{field:'userName', width:150, title: '用户名', sort: true, totalRow: '{{= d.TOTAL_ROW.count   }} 😊'}
        ,{field:'createTime', title:'注册时间', width: 180,templet: function(d){
            var ago = util.timeAgo(d.createTime);
            return ago;
          }
        }
        ,{field:'cellphone', title:'手机号码', width: 180, sort: true}
        ,{field:'role', title:'角色', width: 180, sort: true,templet: function(d){
            if (d.role == "manager"){
              return "超级管理员"
            }else{
              return "普通用户"
            }
           
          }
        }
        ,{field:'expire', title:'到期时间',width:220,edit: 'text',templet: '#TPL-expire'}
        ,{fixed: 'right', title:'操作', width: 140, minWidth: 140, toolbar: '#barDemo'}
      ]] 
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


      if (field == "expire"){
        $.ajax({
        url:'/api/re_expire',
        type: 'post',
        dataType: 'json',
        data: {user_id: obj.data.id,new_expire: obj.value},
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
          $.ajax({
            url:'/api/delUser',
            type: 'post',
            dataType: 'json',
            data: {user_name: obj.data.userName,user_id: obj.data.id},
            success:function(res){
              if (res.code == 2){
                layer.msg("该用户存在节点未删除", {icon: 7});
              }else{
                layer.msg('删除成功', {icon: 6});
                obj.del();
                layer.close(index);
              }
              
            }
          });
          
        });
      } 
    });
   
    //事件-开关操作
    form.on('switch(test-table-sexDemo)', function(obj){
      var $ = layui.$;
      var json = JSON.parse(decodeURIComponent($(this).data('json')));
      //layer.tips(this.value + ' ' + this.name + '：'+ obj.elem.checked, obj.othis);
      
      json = table.clearCacheKey(json);
      console.log(obj.elem.checked); 

      console.log("执行用户状态操作");
      $.ajax({
        url:'/api/user_enable',
        type: 'post',
        dataType: 'json',
        data: {user_id: json.id},
        success:function(res){
            console.log(res)
            if(res.code == 0){
              layer.msg(res.msg, {icon: 6});
            }else{
              layer.msg(res.msg, {icon: 6});
            }
        }
      });
      
    });
   

  });
  </script>
</html>
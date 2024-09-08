<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>控制台</title>
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="/res/layui/css/layui.css" rel="stylesheet">
  <link href="/res/adminui/dist/css/admin.css" rel="stylesheet">
</head>
<body>
  <div class="layui-fluid">
    <div class="layui-row layui-col-space15">
      <div class="layui-col-md8">
        <div class="layui-row layui-col-space15">
          <div class="layui-col-md6">
            <div class="layui-card">
              <div class="layui-card-header">快捷方式</div>
              <div class="layui-card-body">

                <div class="layui-carousel layadmin-carousel layadmin-shortcut">
                  <div carousel-item>
                    <ul class="layui-row layui-col-space10">
                    <li class="layui-col-xs3">
                        <a lay-href="/admin/help">
                          <i class="layui-icon layui-icon-template-1"></i>
                          <cite>入门</cite>
                        </a>
                      </li>

                      <li class="layui-col-xs3">
                        <a lay-href="/admin/node">
                          <i class="layui-icon layui-icon-website"></i>
                          <cite>节点</cite>
                        </a>
                      </li>
                      <li class="layui-col-xs3">
                        <a lay-href="/admin/route">
                          <i class="layui-icon layui-icon-senior"></i>
                          <cite>路由</cite>
                        </a>
                      </li>
                      <li class="layui-col-xs3">
                        <a lay-href="/admin/deploy">
                          <i class="layui-icon layui-icon-fonts-code"></i>
                          <cite>指令</cite>
                        </a>
                      </li>

                            
                    </ul>

                  </div>
                </div>

              </div>
            </div>
          </div>
          <div class="layui-col-md6">
            <div class="layui-card">
              <div class="layui-card-header">数据统计</div>
              <div class="layui-card-body">

                <div class="layui-carousel layadmin-carousel layadmin-backlog">
                  <div carousel-item>
                    <ul class="layui-row layui-col-space10">
                      <li class="layui-col-xs6">
                        <a lay-href="/admin/node" class="layadmin-backlog-body" lay-title="节点中心">
                          <h3>节点数量</h3>
                          <p><cite id="nodeNum">0</cite></p>
                        </a>
                      </li>
                      <li class="layui-col-xs6">
                        <a lay-href="/admin/route" class="layadmin-backlog-body" lay-title="路由中心">
                          <h3>路由数量</h3>
                          <p><cite id="RoutesNum">0</cite></p>
                        </a>
                      </li>

                      <li class="layui-col-xs6">
                        <a class="layadmin-backlog-body" >
                          <h3>累计上行</h3>
                          <p><cite id="sent">0</cite></p>
                        </a>
                      </li>
                      <li class="layui-col-xs6">
                        <a  class="layadmin-backlog-body" >
                          <h3>累计下行</h3>
                          <p><cite id="recv">0</cite></p>
                        </a>
                      </li>

                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="layui-col-md12">
            <div class="layui-card">
              <div class="layui-card-header">数据概览</div>
              <div class="layui-card-body">

                <div class="layui-carousel layadmin-carousel layadmin-dataview" data-anim="fade" lay-filter="LAY-index-dataview">
                  <div carousel-item id="LAY-index-dataview">
                    <div><i class="layui-icon layui-icon-loading1 layadmin-loading"></i></div>
                  </div>
                </div>

              </div>
            </div>

            <div class="layui-card">
              <div class="layui-card-header">服务器地区分布</div>
              <div class="layui-card-body">
                <div class="layui-row layui-col-space15">
                  <div class="layui-col-sm4">
                    <table class="layui-table layuiadmin-page-table" lay-skin="line">
                        <thead>
                          <tr>
                            <th>序号</th>
                            <th>地区</th>
                            <th>带宽</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>1</td>
                            <td>浙江</td>
                            <td>200 Mbps</td>
                          </tr>
                          
                        </tbody>
                      </table>
                  </div>
                  <div class="layui-col-sm8">
                    <div class="layui-carousel layadmin-carousel layadmin-dataview" data-anim="fade" lay-filter="LAY-index-pagethree-home">
                      <div carousel-item id="LAY-index-pagethree-home">
                        <div><i class="layui-icon layui-icon-loading1 layadmin-loading"></i></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

           
          </div>



        </div>
      </div>

      <div class="layui-col-md4">
        <div class="layui-card">
          <div class="layui-card-header">账户信息</div>
          <div class="layui-card-body layui-text layadmin-version">
            <table class="layui-table">
              <colgroup>
                <col width="100">
                <col>
              </colgroup>
              <tbody>
                <tr>
                  <td>注册时间</td>
                  <td id="reg"></td>
                </tr>
                <tr>
                  <td>距离到期</td>
                  <td id="expire">
                    
                  </td>
                </tr>
                <tr>
                  <td>售后微信</td>
                  <td>
                    <script type="text/html" template>
                      
                    </script>
                 </td>
                </tr>
                <tr>
                  <td>公告中心</td>
                  <td>感谢您选择headscale-Admin</td>
                </tr>

              </tbody>
            </table>
          </div>
        </div>



        <div class="layui-card">
          <div class="layui-card-header">进度占用</div>
          <div class="layui-card-body layadmin-takerates">
            <div class="layui-progress" lay-showPercent="yes" lay-filter="cpu-filter-progress">
              <h3>CPU 使用率</h3>
              <div class="layui-progress-bar" lay-percent="0%" id="cpu"></div>
            </div>
            <div class="layui-progress" lay-showPercent="yes"  lay-filter="memory-filter-progress">
              <h3>内存占用率</h3>
              <div class="layui-progress-bar" lay-percent="0%" id="memory"></div>
            </div>
          </div>

        </div>



        <div class="layui-card">
          <div class="layui-card-header">产品动态</div>
          <div class="layui-card-body">
            <div class="layui-carousel layadmin-carousel layadmin-news" data-autoplay="true" data-anim="fade" lay-filter="news">
              <div carousel-item>
                <div><a href="#" class="layui-bg-red">小远组网快速上手文档</a></div>
                <div><a href="#" class="layui-bg-green">小远技术问答专区</a></div>
                <div><a href="#" class="layui-bg-blue">小远博客官网</a></div>
              </div>
            </div>
          </div>
        </div>


      </div>

    </div>
  </div>

  <script src="/res/layui/layui.js?t=1"></script>
  <script>
  layui.config({
    base: '/res/' // 静态资源所在路径
  }).use(['index', 'console']);


  layui.use(function(){
    var layer = layui.layer;
    var util = layui.util;
    var $ = layui.$;
    var element = layui.element;


    $.ajax({
      url:'/api/getMachine?page=1&limit=999',
      type: 'post',
      dataType: 'json',
      success:function(res){
        if(res.code == 0){
          //console.log(res.count)
          $('#nodeNum').html(res.count)
          $('#RoutesNum').html(res.routes)
        }
      }
    });

    $.ajax({
      url:'/api/initData',
      type: 'post',
      dataType: 'json',
      success:function(res){
        if(res.data.defaultPass == '0'){
          location.href = 'password';
          top.layer.msg('请修改默认密码', {icon: 7});
        }

        $('#reg').text((res.data.created_at[0]).split(' ')[0])
        
        // $('#expire').text(res.data.expire)

        var countdown = util.countdown({
          date: res.data.expire, // 目标时间值
          now: new Date(), // 当前时间，一般为服务器时间，此处以本地时间为例
          ready: function(){ // 初始操作
            clearTimeout(util.countdown.timer); // 清除旧定时器，防止多次渲染时重复执行。实际使用时不常用
          },
          clock: function(obj, inst){  // 计时中
            var str = [obj.d,'天',obj.h,'时',obj.m,'分',obj.s,'秒'].join(' ');
            lay('#expire').html(str);
            util.countdown.timer = inst.timer; // 记录当前定时器，以便在重复渲染时清除。实际使用时不常用
          },
          done: function(obj, inst){ // 计时完成
            layer.msg('Time is up');
          }
        });

      }
    });

    setInterval(function(){
      $.ajax({
        url:'/system_api/info',
        type: 'get',
        dataType: 'json',
        success:function(res){
          // console.log(res)

          if(res.cpu_usage > 50){
            $('#cpu').addClass('layui-bg-red'); 
          }else{
            $('#cpu').removeClass('layui-bg-red'); 
          }

          if(res.memory_usage_percent > 50){
            $('#memory').addClass('layui-bg-red');
          }else{
            $('#memory').removeClass('layui-bg-red'); 
          }

          element.progress('cpu-filter-progress', res.cpu_usage+'%'); 
          element.progress('memory-filter-progress', res.memory_usage_percent+'%'); 
          $('#sent').text((res.sent_speed/1024).toFixed(2)+'M'); 
          $('#recv').text((res.recv_speed/1024).toFixed(2)+'M'); 
          
        }
      });

    },2000)
      

  });
  </script>

</html>


<?php
namespace app\controller;

use think\facade\Db;
use think\facade\View;
use think\facade\Session;
use app\model\Users;

class Admin extends  Base
{


    public function index()
    {
        // 查询用户的menus_id
        $hrefs = Db::table('roles')->where([['name','in',Session::get('user_role')],['type','=','menus']])->column('hrefs');
        // 查询用户的menus项目
        $menus = Db::name('menus')->where([['id','in',$hrefs[0]],['show','=',true]])->order('id')->select()->toArray();
        
        return view('index',['username' => Session::get('username'),'menus' => $menus]);
    }


    
    public function console()
    {

        return view();

    }
    
    public function test()
    {


    }

    public function user()
    {
        if (Session::get('user_role') == "manager"){
            return view();
        }else{
            return $this->error("非法请求");

        }
    }

    public function acl()
    {
        if (Session::get('user_role') == "manager"){
            return view();
        }else{
            return $this->error("非法请求");

        }
        
    }

    public function node()
    {
        $manager_cols_data = "[[
            {type: 'checkbox', fixed: 'left'}
            ,{field:'id', fixed: 'left', width:80, title: 'ID', sort: true, totalRowText: '合计：'}
            ,{field:'userName', width:180, title: '用户名', sort: true, edit: 'text',totalRow: '{{= d.TOTAL_ROW.count   }} 😊'}
            ,{field:'name', width:180, title: '节点名', edit: 'text'}
            ,{field:'ip', width: 160, title: 'ip地址'} 
            ,{field:'createTime', title:'创建时间', width: 180, sort: true}
            ,{field:'lastTime', title:'最近连接', width: 180, sort: true,templet:'#TPL-lastTime'}
            ,{field:'Client', title:'客户端', width: 90}
            ,{field:'OS', title:'操作系统', width: 220}
            ,{fixed: 'right', title:'操作', width: 70, minWidth: 70, toolbar: '#barDemo'}
        ]]";


        $user_cols_data  = "[[
            {type: 'checkbox', fixed: 'left'}
            ,{field:'id', fixed: 'left', width:80, title: 'ID', sort: true, totalRowText: '合计：'}
            ,{field:'name', width:180, title: '节点名', edit: 'text',totalRow: '{{= d.TOTAL_ROW.count   }} 😊'}
            ,{field:'ip', width: 160, title: 'ip地址'} 
            ,{field:'createTime', title:'创建时间', width: 180, sort: true}
            ,{field:'lastTime', title:'最近连接', width: 180, sort: true,templet:'#TPL-lastTime'}
            ,{field:'Client', title:'客户端', width: 90}
            ,{field:'OS', title:'操作系统', width: 220}
            ,{fixed: 'right', title:'操作', width: 70, minWidth: 70, toolbar: '#barDemo'}
        ]]";

        if (Session::get('user_role') == "manager"){
            return view('node',['cols_data' => $manager_cols_data]);
        }else{
            return view('node',['cols_data' => $user_cols_data]);

        }
        
    }

    public function route()
    {
        $manager_cols_data  = "[[
            {type: 'checkbox'}
            ,{field:'id', title:'ID', width:10, unresize: true, sort: true, totalRowText: '合计：'}
            ,{field:'name', title:'用户名',width:200, totalRow: '{{= d.TOTAL_ROW.count   }} 😊'}
            ,{field:'machine_id', title:'节点',width:300}
            ,{field:'route', title:'路由',width:180} 
            ,{field:'create_time', title: '创建时间', width:300, sort: true}
            ,{field:'enable', title:'启用', width:160, templet: '#test-table-switchTpl', unresize: true}
        ]]";


        $user_cols_data  = "[[
            {type: 'checkbox'}
            ,{field:'id', title:'ID', width:10, unresize: true, sort: true, totalRowText: '合计：'}
            ,{field:'machine_id', title:'节点',width:300, totalRow: '{{= d.TOTAL_ROW.count   }} 😊'}
            ,{field:'route', title:'路由',width:180} 
            ,{field:'create_time', title: '创建时间', width:300, sort: true}
            ,{field:'enable', title:'启用', width:160, templet: '#test-table-switchTpl', unresize: true}
        ]]";

        if (Session::get('user_role') == "manager"){
            return view('route',['cols_data' => $manager_cols_data]);
        }else{
            return view('route',['cols_data' => $user_cols_data]);

        }
    }

    public function preauthkey()
    {
        $manager_cols_data  = "[[
            {field:'id', title:'ID', width:10, unresize: true, sort: true, totalRowText: '合计：'}
            ,{field:'name', title:'用户名',width:200, totalRow: '{{= d.TOTAL_ROW.count   }} 😊'}
            ,{field:'key', title:'密钥',width:300}
            ,{field:'create_time', title:'创建时间',width:300} 
            ,{field:'expiration', title: '到期时间', width:300, sort: true}
            ,{fixed: 'right', title:'操作', width: 70, minWidth: 70, toolbar: '#barDemo'}
        ]]";


        $user_cols_data  = "[[       
            {field:'id', title:'ID', width:10, unresize: true, sort: true, totalRowText: '合计：'}
            ,{field:'key', title:'密钥',width:300, totalRow: '{{= d.TOTAL_ROW.count   }} 😊'}
            ,{field:'create_time', title:'创建时间',width:300} 
            ,{field:'expiration', title: '到期时间', width:300, sort: true}
            ,{fixed: 'right', title:'操作', width: 70, minWidth: 70, toolbar: '#barDemo'}
        ]]";

        if (Session::get('user_role') == "manager"){
            return view('preauthkey',['cols_data' => $manager_cols_data]);
        }else{
            return view('preauthkey',['cols_data' => $user_cols_data]);

        }
    }

    public function info()
    {
        return view();
    }

    public function password()
    {
        return view();
    }

    public function deploy()
    {
        return view();
    }


    public function help()
    {
        return view();
    }

    public function log()
    {
        $manager_cols_data  = "[[
            {type: 'checkbox'}
            ,{field:'id', title:'ID', width:10, unresize: true, sort: true, totalRowText: '合计：'}
            ,{field:'name', title:'用户名',width:180,totalRow: '{{= d.TOTAL_ROW.count   }} 😊'} 
            ,{field:'content', title:'内容',width:700}
            ,{field:'create_time', title:'时间',width:300}
        ]]";


        $user_cols_data  = "[[
            {type: 'checkbox'}
            ,{field:'id', title:'ID', width:10, unresize: true, sort: true, totalRowText: '合计：'}
            ,{field:'content', title:'内容',width:700,totalRow: '{{= d.TOTAL_ROW.count   }} 😊'}
            ,{field:'create_time', title:'时间',width:300}
        ]]";

        if (Session::get('user_role') == "manager"){
            return view('log',['cols_data' => $manager_cols_data]);
        }else{
            return view('log',['cols_data' => $user_cols_data]);

        }
    }



}

<?php
namespace app\controller;

use app\BaseController;
use think\facade\View;
use think\facade\Db;
use think\facade\Session;

class Install extends BaseController
{

    public function alter_table($sqls_list){
        foreach ($sqls_list as $query) {
            try {
                DB::query($query);
            } catch (\Exception $e) {
                // 可以根据需要记录异常信息或者进行其他处理
                echo "执行 SQL 查询时出错: ".$e->getMessage();
            }
        }
    }

    public function index()

    {
        // 查询所有的表名
        // $tables_name = Db::query("select name from sqlite_master where type='table'");
        // dump($tables_name);

        // 查询表列总数
        $users_column_num = count(Db::query("PRAGMA table_info(users)"));
        if ($users_column_num != 10){
            // 修改表操作
            $sqls_list = [
                "alter table users add column password TEXT default '$2y$10$1oPEl1iKqF/z8igBRbHBn.stOBB/Stl5xqxDp5ujArjPXj/rBdc2S'",
                "alter table users add column expire datetime default '2024-09-12 00:00:00'",
                "alter table users add column cellphone  TEXT",
                "alter table users add column role  TEXT defaule user",
                "alter table users add column enable  numeric defaule true"
            ];
            $this->alter_table($sqls_list);

            $data = [
                'created_at' => date('Y-m-d H:i:s.uP'),
                'updated_at' => date('Y-m-d H:i:s.uP'),
                'deleted_at' => null,
                'name' => 'admin',
                'expire' => '2029-12-30 00:00:00',
                'cellphone' => null,
                'role' => 'manager',
                'enable' => '1'
            ];
            Db::name('users')->save($data);
            dump("用户表更新已完成");
        }else{
            dump("用户表验证成功");
        }

        $menus_column_num = count(Db::query("PRAGMA table_info(menus)"));
        if($menus_column_num != 4){
            Db::query("CREATE TABLE menus(id integer PRIMARY KEY AUTOINCREMENT,title TEXT,href TEXT,show numeric)");
            $data = [
                ['id' => 10, 'title' => '用户', 'href' => 'Admin/user', 'show' => '1'],
                ['id' => 20, 'title' => '节点', 'href' => 'Admin/node', 'show' => '1'],
                ['id' => 30, 'title' => '路由', 'href' => 'Admin/route', 'show' => '1'],
                ['id' => 40, 'title' => '指令', 'href' => 'Admin/deploy', 'show' => '1'],
                ['id' => 50, 'title' => '文档', 'href' => 'Admin/help', 'show' => '1'],
                ['id' => 60, 'title' => 'ACL', 'href' => 'Admin/acl', 'show' => '1'],
                ['id' => 70, 'title' => '密钥', 'href' => 'Admin/preauthkey', 'show' => '1'],
                ['id' => 80, 'title' => '个人中心', 'href' => 'Admin/info', 'show' => 'f'],
                ['id' => 90, 'title' => 'Index', 'href' => 'Admin/index', 'show' => 'f'],
                ['id' => 100, 'title' => '控制台', 'href' => 'Admin/console', 'show' => 'f'],
                ['id' => 110, 'title' => '修改密码', 'href' => 'Admin/password', 'show' => 'f'],
                ['id' => 120, 'title' => '日志', 'href' => 'Admin/log', 'show' => '1']
            ];
            Db::name('menus')->insertAll($data);
            dump("菜单表更新已完成");
        }else{
            dump("菜单表验证成功");
        }

        $roles_column_num = count(Db::query("PRAGMA table_info(roles)"));
        if($roles_column_num != 4){
            Db::query("CREATE TABLE roles(id integer PRIMARY KEY AUTOINCREMENT,name TEXT,hrefs TEXT,type TEXT)");
            $data = [
                ['id' => 1, 'name' => 'manager', 'hrefs' => '10,20,30,60,40,50,70,80,90,100,110,120', 'type' => 'menus'],
                ['id' => 4, 'name' => 'manager', 'hrefs' => '10,20,30,40,50,60,70,80,90,100,110,120,130,140,150,160,170,180,190,200,210,220,230,240,250', 'type' => 'api'],
                ['id' => 2, 'name' => 'user', 'hrefs' => '20,30,40,50,70,80,90,100,110,120', 'type' => 'menus'],
                ['id' => 3, 'name' => 'user', 'hrefs' => '10,20,80,90,100,110,120,130,140,150,160,220,230,240,250', 'type' => 'api']
            ];
            Db::name('roles')->insertAll($data);
            dump("规则表更新已完成");

        }else{
            dump("角色表验证成功");
        }


        $apis_column_num = count(Db::query("PRAGMA table_info(apis)"));
        if($apis_column_num != 3){
            Db::query("CREATE TABLE apis(id integer PRIMARY KEY AUTOINCREMENT,title TEXT,href TEXT)");
            $data = [
                ['id' => 10, 'title' => '登出', 'href' => 'Api/logout'],
                ['id' => 20, 'title' => '改密', 'href' => 'Api/password'],
                ['id' => 30, 'title' => '获取用户', 'href' => 'Api/getUsers'],
                ['id' => 40, 'title' => '删除用户', 'href' => 'Api/delUser'],
                ['id' => 50, 'title' => '更改所有者', 'href' => 'Api/new_owner'],
                ['id' => 60, 'title' => '启用用户', 'href' => 'Api/user_enable'],
                ['id' => 70, 'title' => '修改到期时间', 'href' => 'Api/re_expire'],
                ['id' => 80, 'title' => '控制台初始化', 'href' => 'Api/initData'],
                ['id' => 90, 'title' => '获取节点', 'href' => 'Api/getMachine'],
                ['id' => 100, 'title' => '重命名', 'href' => 'Api/rename'],
                ['id' => 110, 'title' => '添加节点', 'href' => 'Api/addNode'],
                ['id' => 120, 'title' => '删除节点', 'href' => 'Api/delNode'],
                ['id' => 130, 'title' => '获取路由', 'href' => 'Api/getRoute'],
                ['id' => 140, 'title' => '启用路由', 'href' => 'Api/route_enable'],
                ['id' => 150, 'title' => '禁用路由', 'href' => 'Api/route_disable'],
                ['id' => 160, 'title' => '删除路由', 'href' => 'Api/delRoute'],
                ['id' => 170, 'title' => '获取acl', 'href' => 'Api/getAcls'],
                ['id' => 180, 'title' => '修改acl', 'href' => 'Api/re_acl'],
                ['id' => 190, 'title' => '重写acl', 'href' => 'Api/rewrite_acl'],
                ['id' => 200, 'title' => '读取acl', 'href' => 'Api/read_acl'],
                ['id' => 210, 'title' => '重载headscale配置', 'href' => 'Api/reload'],
                ['id' => 220, 'title' => '获取日志', 'href' => 'Api/getLogs'],
                ['id' => 230, 'title' => '获取密钥', 'href' => 'Api/getPreAuthKey'],
                ['id' => 250, 'title' => '删除key', 'href' => 'Api/delKey'],
                ['id' => 240, 'title' => '新增key', 'href' => 'Api/addKey']
            ];
            Db::name('apis')->insertAll($data);
            dump("角色表更新已完成");

        }else{
            dump("角色表验证成功");
        }



        $logs_column_num = count(Db::query("PRAGMA table_info(logs)"));
        if($logs_column_num != 4){
            Db::query("CREATE TABLE logs(id integer PRIMARY KEY AUTOINCREMENT,user_id integer,content TEXT,create_time datetime)");
            dump("日志表更新已完成");
        }else{
            dump("日志表验证成功");
        }



        $routes_column_num = count(Db::query("PRAGMA table_info(routes)"));
        if ($routes_column_num != 10){
            // 修改表操作
            $sqls_list = [
                "alter table routes add column user_id integer",
            ];
            $this->alter_table($sqls_list);
            dump("路由表更新已完成");
        }else{
            dump("路由表验证成功");
        }


        $acl_column_num = count(Db::query("PRAGMA table_info(acls)"));
        if ($acl_column_num != 3){
            Db::query("CREATE TABLE acls(id integer PRIMARY KEY AUTOINCREMENT,acl TEXT,user_id integer)");
            $admin_user_id =  Db::table('users')->where('name','admin')->column('id');
            // 修改表操作
            $data = [
                'acl' => '{"action": "accept","src": ["admin","192.168.0.0/16"],"dst": ["admin:*","192.168.0.0/16:*"]}',
                'user_id' => $admin_user_id[0]
            ];
            Db::name('acls')->save($data);
            dump("ACL表更新已完成");
        }else{
            dump("ACL表验证成功");
        }
    }



}

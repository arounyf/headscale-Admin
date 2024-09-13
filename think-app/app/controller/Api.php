<?php
namespace app\controller;


use app\validate\User;
use app\validate\Reg;
use think\facade\View;
use app\validate\Password;
use think\facade\Db;
use think\facade\Request;
use think\facade\Session;
use think\captcha\facade\Captcha;
use think\exception\ValidateException;



class Api extends Base
{

    public function __construct()
    {
        $this -> init_data();
    }

// --------------------------- 以下是用户操作相关api --------------------------------------
    public function logout(){
        $this->log_record("退出登录成功");
        Session::clear();
        $this->res["code"] = 0;
        $this->res["msg"] = "退出成功";
        $this->resprint($this->res);

    }



    public function password(){
        $code = "1";
        $message="";
        $username = Session::get('username');
        $oldPassword = Request::param('oldPassword');
        $password = Request::param('password');

        //验证器
        try {
            validate(Password::class)->check([
                'oldPassword'  => $oldPassword,
                'password'  => $password,
            ]);


            //密码验证
            if($message === ""){

                $dbpassword = Db::table('users')->where('name',$username)->column('password');
                if (password_verify($oldPassword,$dbpassword[0])){
                    Db::name('users')->where('name', $username)->update(['password' => password_hash($password,PASSWORD_DEFAULT)]);
                    $code = "0";
                    Session::clear();
                    $this->log_record("密码修改成功");
                } else {
                    $message = "旧密码输入错误";
                }

            }
    

        } catch (ValidateException $e) {
                $message = $e->getError();
        }
    

        $this->res['code'] = $code;
        $this->res['msg'] = $message;
        $this->resprint($this->res);
    }

    
    public function getUsers(){
        $page = Request::param('page');
        $limit = Request::param('limit');

        $users = [];



        $cursor = Db::table('users')
            ->order('id')
            ->limit($limit)
            ->page($page)
            ->select();
        $count = Db::table('users')->count();


        
        foreach($cursor as $value){

            $user = [];
            $user = [
                'id' => $value['id'],
                'userName' => $value['name'],
                'createTime' =>  $this->offsetTime($value['created_at']),
                'cellphone' => $value['cellphone'],
                'expire' => $value['expire'],
                'role' => $value['role'],
                'enable' => $value['enable']

            ];
            
            array_push($users,$user);
        }

        $this->res["code"] = 0;
        $this->res["msg"] = "获取成功";
        $this->res["count"] = $count;
        $this->res["totalRow"] = ["count" => count($users)];
        $this->res["data"] = $users;
        $this->resprint($this->res);
    }



        
    public function delUser(){
        $user_id = Request::param('user_id');
        $user_name = Request::param('user_name');
        $url = $this->server_url."/api/v1/user/".$user_name;  
        Db::table('acls')->where('user_id',$user_id)->delete();
        $response = $this->curl_delete($url);
        $this->resprint(json_decode($response, true));
    }


    public function new_owner(){

        $node_id = Request::param('node_id');
        $user_name = Request::param('user_name');
        
        $users = Db::table('users')->where('name',$user_name)->column('name');

        
        if ($users != []){
            $url =  $this->server_url."/api/v1/machine/".$node_id."/user?user=".$user_name;  
            $this->curl_post($url);
            $this->res['code'] = 0;
            $this->res['msg'] = "修改成功";
           
        }
        $this->resprint($this->res);
    }

    
    public function user_enable(){   
        $user_id = Request::param('user_id');
        $status =  Db::table('users')->where('id',$user_id)->column('enable');
        $this->res['code'] = 0;
        if ($status[0]){
            $result = Db::name('users')->where('id', $user_id)->update(['enable' => false ]);
            $this->res['msg'] = "关闭成功";
        }else{
            $result = Db::name('users')->where('id', $user_id)->update(['enable' => true ]);
            $this->res['msg'] = "打开成功";
        }
        $this->resprint($this->res);
    }


    public function re_expire(){
        $user_id = Request::param('user_id');
        $new_expire = Request::param('new_expire');

        $result = Db::name('users')->where('id', $user_id)->update(['expire' => $new_expire ]);

        if ($result == 1){
            $this->res['code'] = 0;
            $this->res['msg'] = "更新成功";
        }else{
            $this->res['code'] = 1;
            $this->res['msg'] = "更新失败";
        }
        $this->resprint($this->res);
    }

    //判断用户是否为初始密码
    public function initData(){
        $data = [];
        $this->res['code'] = 0;
        $username = Session::get('username');
        $dbpassword = Db::table('users')->where('name',$username)->column('password');
        if (password_verify('999888',$dbpassword[0])){
            $data['defaultPass'] = 0;
        }
        
        $expire = Db::table('users')->where('name',$username)->column('expire');
        $reg = Db::table('users')->where('name',$username)->column('created_at');
    
        //获取创建时间和到期时间
        $data['created_at'] = $reg;
        $data['expire'] = $expire;
        $this->res['data'] = $data;
        $this->resprint($this->res);
    }





// --------------------------- 以下是节点操作相关api --------------------------------------

    public function getMachine(){
        $user_id = Session::get('user_id');
        $username = Session::get('username');
        $user_role = Session::get('user_role');
        $page = Request::param('page');
        $limit = Request::param('limit');

        $nodes = [];
        $routes = 0;

        if ($user_role == "manager"){
            $cursor = Db::table('machines')->alias('m')
                ->join('users u','m.user_id = u.id')
                ->field('m.id,u.name,m.given_name,m.ip_addresses,m.created_at,m.last_seen,m.host_info')
                ->order('id')
                ->limit($limit)
                ->page($page)
                ->select();
            $count = Db::table('machines')->count();
        }else{
            $cursor = Db::table('machines')->alias('m')
                ->join('users u','m.user_id = u.id')
                ->where('user_id',$user_id)
                ->field('m.id,u.name,m.given_name,m.ip_addresses,m.created_at,m.last_seen,m.host_info')
                ->order('id')
                ->limit($limit)
                ->page($page)
                ->select();
            $count = Db::table('machines')->where('user_id',$user_id)->count();
        }

        
        foreach($cursor as $value){

            $node = [];
            $node = [
                'id' => $value['id'],
                'userName' => $value['name'],
                'name' => $value['given_name'],
                'ip' => $value['ip_addresses'],
                'createTime' => $this->offsetTime($value['created_at']),
                'lastTime' => $this->offsetTime($value['last_seen'])
            ];
            
            try { $node['Client'] = substr(json_decode($value['host_info'],true)['IPNVersion'],0,6);} catch (\Exception  $e) { $node['Client'] = "未知"; }
            try { $node['OS'] = json_decode($value['host_info'],true)['OS'].json_decode($value['host_info'],true)['OSVersion'];  } catch (\Exception  $e) { $node['OS'] = "未知";  }
            if (isset(json_decode($value['host_info'],true)['RoutableIPs'])){ $routes ++; }
            array_push($nodes,$node);
        }

        $this->res["code"] = 0;
        $this->res["msg"] = "获取成功";
        $this->res["count"] = $count;
        $this->res["routes"] = $routes;
        $this->res["totalRow"] = ["count" => count($nodes)];
        $this->res["data"] = $nodes;
        $this->resprint($this->res);

    }


    public function rename(){
        $machine_id = Request::param('machine_id');
        $machine_name = Request::param('machine_name');
        $url =  $this->server_url."/api/v1/machine/".$machine_id."/rename/".$machine_name;  

        if($this->machine_verify($machine_id)){
            $response = $this->curl_post($url);
            $this->res['code'] = 0;
            $this->res['msg'] = "重命名成功";
            $this->res['data'] = json_decode($response,true);
            // $this->res['data'] = $response;
        }
       
        $this->resprint($this->res);
                
    }


    public function addNode(){
        $username = Session::get('username');
        $nodekey = Request::param('nodekey');
        $url = $this->server_url."/api/v1/machine/register?user=".$username."&key=nodekey:".$nodekey;  
        $response = $this->curl_post($url);
        $this->log_record("添加节点");
        $this->resprint(json_decode($response, true));
    }



    public function delNode(){

        $machine_id = Request::param('machine_id');
        $url = $this->server_url."/api/v1/machine/".$machine_id;  

        if($this->machine_verify($machine_id)){
            $response = $this->curl_delete($url);
            $this->log_record("节点删除成功,节点id:".$machine_id);
            $this->resprint(json_decode($response, true));
        }else{
            $this->resprint($this->res);
        }
        
    }



// --------------------------- 以下是路由操作相关api --------------------------------------
  

    public function getRoute(){
        $page = Request::param('page');
        $limit = Request::param('limit');

        //首先填充user_id,注意user_id非headscale字段
        $cursor = Db::table('routes')->order('id')->where('user_id', null)->cursor();
        foreach($cursor as $route){
            $user_id =  Db::table('machines')->where('id',$route['machine_id'])->column('user_id');
            Db::name('routes')->where('id',$route['id'])->update(['user_id' => $user_id[0]]);
        }


        if(Session::get('user_role') == "manager"){
            $where_map = [];
            $count = Db::table('routes')->count();
        }else{
            $where_map = [['user_id','=',Session::get('user_id')]];
            $count = Db::table('routes')->where('user_id',Session::get('user_id'))->count();
        }
        

        $cursor = Db::table('routes')->alias('r')
            ->join('users u','r.user_id = u.id')
            ->field('r.id,r.prefix,r.machine_id,r.created_at,r.enabled,u.name')
            ->order('id')
            ->where($where_map)
            ->limit($limit)
            ->page($page)
            ->cursor();
        

        $routes = [];
        foreach($cursor as $value){
            $machines = Db::table('machines')->field('given_name')->where('id',$value['machine_id'])->select();
            $route = [
                'id' => $value['id'],
                'name' => $value['name'],
                'machine_id' => $machines[0]['given_name'],
                'route' => $value['prefix'],
                'create_time' => $this->offsetTime($value['created_at']),
                'enable' => $value['enabled']
            ];
            array_push($routes,$route);
        }


        $this->res["code"] = 0;
        $this->res["msg"] = "获取成功";
        $this->res["count"] = $count;
        $this->res["data"] = $routes;
        $this->res["totalRow"] = ["count" => count($routes)];
        $this->resprint($this->res);
    }

    public function route_enable(){
        $route_id = Request::param('route_id');
        $url =  $this->server_url."/api/v1/routes/".$route_id."/enable";  

        $prefix = Db::table('routes')->where('id',$route_id)->column('prefix');
        $count = Db::table('routes')->where('prefix',$prefix[0])->count();
        
        if($count >1){
            $this->res['msg'] = "打开失败,该网段已被使用";
        }else{
            if($this->route_verify($route_id)){
                $this->curl_post($url);
                $this->log_record("路由打开成功，路由id:".$route_id);
                $this->res['code'] = 0;
                $this->res['msg'] = "打开成功";
            }
        }
        $this->resprint($this->res);
    }

    public function route_disable(){
        $route_id = Request::param('route_id');
        $url =  $this->server_url."/api/v1/routes/".$route_id."/disable";  

        if($this->route_verify($route_id)){
            $this->curl_post($url);
            $this->log_record("路由关闭成功，路由id:".$route_id);
            $this->res['code'] = 0;
            $this->res['msg'] = "关闭成功";
        }
        $this->resprint($this->res);
    }




    public function delRoute(){

        $route_id = Request::param('route_id');
        $url = $this->server_url."/api/v1/routes/".$route_id;  

        if($this->machine_route_verify($route_id)){
            $response = $this->curl_delete($url);
            $this->log_record("路由删除成功，路由id:".$route_id);
            $this->res['code'] = 0;
            $this->res['msg'] = "删除成功";
            $this->res['data'] = $response;
            $this->resprint($this->res);
        }else{
            $this->resprint($this->res);
        }
        
    }




// --------------------------- 以下是ACL操作相关api --------------------------------------
    public function getAcls(){

        $page = Request::param('page');
        $limit = Request::param('limit');


        $cursor = Db::table('acls')->alias('a')
            ->join('users u','a.user_id = u.id')
            ->field('a.id,a.acl,a.user_id,u.name')
            ->order('id')
            ->limit($limit)
            ->page($page)
            ->select();
        $count = Db::table('users')->count();

        $acls = [];
        foreach($cursor as $value){

            $acl = [];
            $acl = [
                'id' => $value['id'],
                'acl' => $value['acl'],
                'user_name' => $value['name']

            ];
            array_push($acls,$acl);
        }

        $this->res["code"] = 0;
        $this->res["msg"] = "获取成功";
        $this->res["count"] = $count;
        $this->res["data"] = $acls;
        $this->res["totalRow"] = ["count" => count($acls)];
        $this->resprint($this->res);

        
    }

    public function re_acl(){
        $acl_id = Request::param('acl_id');
        $new_acl = Request::param('new_acl');

        json_decode($new_acl);

        if(json_last_error() === JSON_ERROR_NONE){
            $result = Db::name('acls')->where('id', $acl_id)->update(['acl' => $new_acl ]);
            if ($result == 1){
                $this->res['code'] = 0;
                $this->res['msg'] = "更新成功";
                $this->log_record("ACL修改成功，ACL id:".$acl_id);
            }else{
                $this->res['code'] = 1;
                $this->res['msg'] = "更新失败";
            }
        }else{
            $this->res['code'] = 1;
            $this->res['msg'] = "解析错误";
        }

        
        $this->resprint($this->res);
   
    }

    public function rewrite_acl(){
        //更新acl文件
        $this->update_acl();
        $this->log_record("重写ACL成功");
        $this->res["msg"] = "写入成功";
        $this->res["code"] = 0;
        $this->resprint($this->res);
    }

    public function read_acl(){
        $filePath = $this->acl;
        $fileHandle = fopen($filePath, 'r');
        if ($fileHandle) {
            $fileContent = '';
            while (!feof($fileHandle)) {
                $fileContent.= fread($fileHandle, 8192);
            }
            fclose($fileHandle);
        } else {
            echo "无法打开文件。";
        }

        $this->res["msg"] = "读取成功";
        $this->res["code"] = 0;
        $this->res["data"] = $fileContent;
        $this->resprint($this->res);
    }

    public function reload(){
        //发送headscale重载配置命令                    
        $this->res["msg"] = "成功";
        $this->res["code"] = 0;
        $this->res["data"] = $this->reload_config();
        $this->log_record("重新加载配置成功");
        $this->resprint($this->res);
    }
// --------------------------- 以下是密钥操作相关api --------------------------------------


    public function getPreAuthKey(){
        $page = Request::param('page');
        $limit = Request::param('limit');

        if(Session::get('user_role') == "manager"){
            $where_map = [];
            $count = Db::table('pre_auth_keys')->count();
        }else{
            $where_map = [['user_id','=',Session::get('user_id')]];
            $count = Db::table('pre_auth_keys')->where('user_id',Session::get('user_id'))->count();
        }
        

        $cursor = Db::table('pre_auth_keys')->alias('p')
            ->join('users u','p.user_id = u.id')
            ->field('p.id,p.key,p.created_at,p.expiration,u.name')
            ->order('id')
            ->where($where_map)
            ->limit($limit)
            ->page($page)
            ->select();
        

        $logs = [];
        foreach($cursor as $value){

            $log = [];
            $log = [
                'id' => $value['id'],
                'name' => $value['name'],
                'key' => $value['key'],
                'create_time' => $this->offsetTime($value['created_at']),
                'expiration' => $this->offsetTime($value['expiration']),

            ];
            array_push($logs,$log);
        }

        $this->res["code"] = 0;
        $this->res["msg"] = "获取成功";
        $this->res["count"] = $count;
        $this->res["data"] = $logs;
        $this->res["totalRow"] = ["count" => count($logs)];
        $this->resprint($this->res);
    }


    public function delKey(){
        $key_id = Request::param('key_id');
        if($this->pre_auth_key_verify($key_id)){ 
            Db::table('pre_auth_keys')->where('id',$key_id)->delete();
            $this->res["code"] = 0;
            $this->res["msg"] = "删除成功";
        }

        $this->resprint($this->res);
        
    }


    public function addKey(){
        $user_id = Session::get('user_id');
        $user_name = Session::get('username');
        $after7 = date('Y-m-d\TH:i:s.uP', strtotime('+7 days'));
        dump($after7);

        $url =  $this->server_url."/api/v1/preauthkey";  
        $data = [
            'user' => $user_name,
            'reusable' => true,
            'ephemeral' => false,
            'expiration' => $after7
        ];

        $data = json_encode($data,JSON_UNESCAPED_UNICODE);
        $response = $this->curl_post($url,$data);
        $this->res['code'] = 0;
        $this->res['msg'] = "新建成功";
        $this->res['data'] = $response;
        $this->resprint($this->res);
        
    }
// --------------------------- 以下是日志操作相关api --------------------------------------

    public function getLogs(){
        $page = Request::param('page');
        $limit = Request::param('limit');

        if(Session::get('user_role') == "manager"){
            $where_map = [];
            $count = Db::table('logs')->count();
        }else{
            $where_map = [['user_id','=',Session::get('user_id')]];
            $count = Db::table('logs')->where('user_id',Session::get('user_id'))->count();
        }
        

        $cursor = Db::table('logs')->alias('l')
            ->join('users u','l.user_id = u.id')
            ->field('l.id,l.content,l.create_time,u.name')
            ->order('id')
            ->where($where_map)
            ->limit($limit)
            ->page($page)
            ->select();
        

        $logs = [];
        foreach($cursor as $value){

            $log = [];
            $log = [
                'id' => $value['id'],
                'name' => $value['name'],
                'content' => $value['content'],
                'create_time' => $value['create_time']

            ];
            array_push($logs,$log);
        }

        $this->res["code"] = 0;
        $this->res["msg"] = "获取成功";
        $this->res["count"] = $count;
        $this->res["data"] = $logs;
        $this->res["totalRow"] = ["count" => count($logs)];
        $this->resprint($this->res);
    }


}

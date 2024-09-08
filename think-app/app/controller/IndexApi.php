<?php
namespace app\controller;



use app\validate\User;
use app\validate\Reg;
use app\validate\Password;
use think\facade\Db;
use think\facade\Request;
use think\facade\Session;
use think\captcha\facade\Captcha;
use think\exception\ValidateException;



class IndexApi extends Base
{

    public function __construct()
    {
        $this -> init_data();
    }

    public function update(){
        //更新acl文件
        $this->update_acl();

        //发送headscale重载配置命令                    
        $this->reload_config();
    }

    public function login()
    {
        $message = "";
        $username = mb_strtolower(Request::param('username'));
        $password = Request::param('password');
        $vcode = Request::param('vcode');
 

        //验证器
        try {
            validate(User::class)->check([
                'username'  => $username,
                'password' => $password,
                'vcode' => $vcode
            ]);


             //验证码验证
            if (!captcha_check($vcode)) {
                $message = "验证码错误";
            } else {
                $result = Db::table('users')->where('name',$username)->select()->toArray();
                //判断查询密码是否为空，可能是该用户不存在
                // dump($result[0]["password"]);
                
                if($result == []){
                    $message = "请检查账号和密码";
                }else{
                    if (password_verify($password,$result[0]["password"])){
                        Session::set('username', $username);
                        Session::set('user_id', $result[0]["id"]);
                        Session::set('user_role', $result[0]["role"]);
                        Session::set('login_time', date('Y-m-d H:i:s'));
                        $this->res["code"] = 0;
                        $this->log_record("登录成功");
                    } else {
                        $message = "登录失败";
                    }
                }
            }

        } catch (ValidateException $e) {
            $message = $e->getError();
        }
        

        $this->res["msg"] = $message;
        $this->resprint($this->res);

    }




    public function reg(){
        $message = "";
        $username = mb_strtolower(Request::param('username'));
        $password = Request::param('password');
        $cellphone = Request::param('cellphone');
        $vcode = Request::param('vcode');
 

        
        //验证器
        try {
            validate(Reg::class)->check([
                'username'  => $username,
                'password' => $password,
                'cellphone' => $cellphone,
                'vcode' => $vcode
            ]);


             //验证码验证
            if(!captcha_check($vcode)){
                $message = "验证码错误";
            } else {
                $dbusername = Db::table('users')->where('name',$username)->column('name');
                if ($dbusername){
                    $message = "用户名已存在";
                } else {
                    $prepassword = password_hash($password,PASSWORD_DEFAULT);
                    $now = date('Y-m-d H:i:s.uP');
                    $after7 = date('Y-m-d H:i:s.uP', strtotime('+7 days'));

                    $predata = [
                        'created_at' => $now,
                        'updated_at' => $now,
                        'expire' => $after7,
                        'name' => $username, 
                        'password' => $prepassword,
                        'cellphone' => $cellphone,
                        'role' => 'user',
                        'enable' => true
                    ];
                    
                    // 插入数据并返回自增主键值
                    $user_id = Db::name('users')->insertGetId($predata);
                    

                    // 插入ACL到数据库
                    $newAcl = [
                        "action" => "accept",
                        "src" => [$username,"192.168.0.0/16"],
                        "dst" => ["$username:*","192.168.0.0/16:*"]
                    ];
                    $insert_data = [
                        "user_id" => $user_id,
                        "acl" => json_encode($newAcl,JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)
                    ];
                    Db::table('acls')->save($insert_data);


                    //更新acl文件
                    $this->update_acl();

                    //发送headscale重载配置命令                    
                    $this->reload_config();

                    $this->res["code"] = 0;
                    // $this->res["data"] = $response;
                    $message = "注册成功";
                }
            }

            

        } catch (ValidateException $e) {
            $message = $e->getError();
        }


        $this->res["msg"] = $message;
        $this->resprint($this->res);

    }


}

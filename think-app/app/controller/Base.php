<?php
namespace app\controller;


use think\facade\Db;
use think\facade\View;
use think\facade\Config;
use think\facade\Session;
use think\exception\HttpResponseException;


class Base
{

    public $server_url;
    public $host_url;
    public $headers;
    public $acl;
    public $res;
    public $offsetTime;
    
    // public $username;
    // public $user_id;
    // public $user_role;



    public function init_data(){
        $this->server_url = env('headscale.server');
        $this->host_url = env('headscale.host');
        $this->headers = array("Authorization: Bearer ". env('headscale.token'));
        $this->acl = env('headscale.acl');
        $this->res = [
            "code" => 1,
            "msg" => '非法请求',
            "data" => []
        ];
    }


    public function resprint($preData){
        // 设置响应头为 application/json
        // 清除已有的输出缓冲（如果有）
        ob_end_clean();
        // 设置响应头为 application/json
        header('Content-Type: application/json');
        print_r(json_encode($preData,JSON_UNESCAPED_UNICODE));
    }


    //发送headscale重载配置命令
    public function reload_config(){
        $url = $this->host_url."/reload_acl";  
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPGET, 1); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);   //不显示输出
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }


    function update_acl(){
        // 从数据库中获取全部ACL
        $acls = [];
        $cursor = Db::table('acls')->alias('a')
        ->join('users u','a.user_id = u.id')
        ->field('a.id,a.acl,u.enable')
        ->order('a.id')->cursor();
        foreach($cursor as $acl){
            if($acl['enable']){
                $acls['acls'][] =json_decode($acl['acl']);
            }
        }
        // 更新ACL文件
        $file = fopen($this->acl, "w");
        fwrite($file, json_encode($acls, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
        fclose($file);
    }


    function offsetTime($dateTimeString) {
        if($this->offsetTime){
            $timestamp = strtotime(substr($dateTimeString,0,19));
            $timestamp += $this->offsetTime * 3600;
            return date('Y-m-d H:i:s', $timestamp);
        }else{
            $timestamp = strtotime(substr($dateTimeString,0,19));
            return date('Y-m-d H:i:s', $timestamp);
        }
    }


    function log_record($content){
        $data = ['user_id' => Session::get('user_id'), 'content' => $content,'create_time' => date('Y-m-d H:i:s')];
        Db::name('logs')->save($data);
    }



    function curl_post($url,$data = '{}'){
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);   //不显示输出
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
        $response = curl_exec($ch);
        
        curl_close($ch);
        return $response;
    }


    function curl_delete($url){
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);   //不显示输出
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }

// --------------------------- 以下是id验证实现方法 --------------------------------------
    
    function route_verify($route_id){
        try {
            if (Session::get('user_role')  != "manager"){
                $machine_id = Db::table('routes')->where('id',$route_id)->column('machine_id')[0];
                $user_id = Db::table('machines')->where('id',$machine_id)->column('user_id')[0];
                if ($user_id == Session::get('user_id')){
                    return true;
                }else{
                    return false;
                }
            }else{
                return true;
            }
        } catch (\Exception  $e) {
            return false;
        }
        
    }


    function machine_verify($machine_id){
        try {
            if (Session::get('user_role')  != "manager"){
                $user_id = Db::table('machines')->where('id',$machine_id)->column('user_id')[0];
                if ($user_id == Session::get('user_id')){
                    return true;
                }else{
                    return false;
                }
            }else{
                return true;
            }
        } catch (\Exception  $e) {
            return false;
        }
        
    }


    function machine_route_verify($route_id){
        try {
            if (Session::get('user_role')  != "manager"){
                $machine_id = Db::table('routes')->where('id',$route_id)->column('machine_id')[0];
                $user_id = Db::table('machines')->where('id',$machine_id)->column('user_id')[0];
                if ($user_id == Session::get('user_id')){
                    return true;
                }else{
                    return false;
                }
            }else{
                return true;
            }
        } catch (\Exception  $e) {
            return false;
        }
        
    }

    function pre_auth_key_verify($key_id){
        try {
            if (Session::get('user_role')  != "manager"){
                $user_id = Db::table('pre_auth_keys')->where('id',$key_id)->column('user_id')[0];
                if ($user_id == Session::get('user_id')){
                    return true;
                }else{
                    return false;
                }
            }else{
                return true;
            }
        } catch (\Exception  $e) {
            return false;
        }
        
    }

}
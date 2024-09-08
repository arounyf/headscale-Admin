<?php
namespace app\controller;

use app\BaseController;
use think\facade\View;
use think\facade\Db;
use think\facade\Session;

class Install extends BaseController
{



    public function index()

    {
        if (!Session::has('username')){
            header("location: login");
            exit("未登录系统");
        }





        //查询所有数据
        //dump(Db::table('users')->select());
        
        // Db::name('users')
        //     ->where('id', '>','0')
        //     ->update(['password' => '$2y$10$1oPEl1iKqF/z8igBRbHBn.stOBB/Stl5xqxDp5ujArjPXj/rBdc2S']);

        // echo password_hash("999888",PASSWORD_DEFAULT);

        // dump(password_verify ( "999888" , '$2y$10$1oPEl1iKqF/z8igBRbHBn.stOBB/Stl5xqxDp5ujArjPXj/rBdc2S'));


    }



}

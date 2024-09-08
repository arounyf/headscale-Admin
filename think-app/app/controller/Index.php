<?php
namespace app\controller;

use app\BaseController;
use think\facade\View;
use think\facade\Session;


class Index extends BaseController
{
    public function index()
    {
           return view();
    }


    public function login()
    {
        if (Session::has('username')){
            header("location: admin");
            exit;
        } else {
            return view();
        }      
        
    }

    public function reg()
    {
        return view();
    }




    public function hello($name = 'ThinkPHP6')
    {
        return 'hello,' . $name;
    }
}

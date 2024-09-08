<?php
namespace app\middleware;


use think\facade\Db;
use think\facade\View;
use think\facade\Config;
use think\facade\Session;
use think\exception\HttpResponseException;

class Auth{
	public function handle($request, \Closure $next)
	{
		// $appName = app('http')->getName(); //多应用模式使用
		$controller =  $request->controller();
		$action = $request->action();

		//判断用户是否已经登录
		if ($controller =="Admin" || $controller =="Api"){
			if (!Session::has('username')){
				$this->res = [
					"code" => 1,
					"msg" => '未登录系统或者登录已过期',
					"data" => []
				];
				$this->error("未登录系统或者登录已过期");
			}
		}

		//如果用户已经登录，则判断用户角色，根据角色判断该MENU是否有访问权限 排除index和console，表示任何角色都能访问
		if ($controller =="Admin"){
			$id = Db::name('menus')->where('href',$controller.'/'.$action)->column('id');	
			$hrefs = Db::table('roles')->where([['name','in',Session::get('user_role')],['type','=','menus']])->column('hrefs');
			$hrefs_arr = explode(',',$hrefs[0]);

			if($id == []){
				$this->error("404");
			}else{
				if (!in_array($id[0], $hrefs_arr)) {
					$this->error("404");
				}
			}
		}


		//如果用户已经登录，则判断用户角色，根据角色判断该API是否有访问权限
		if ($controller =="Api"){
			$id = Db::name('apis')->where('href',$controller.'/'.$action)->column('id');	
			$hrefs = Db::table('roles')->where([['name','in',Session::get('user_role')],['type','=','api']])->column('hrefs');
			$hrefs_arr = explode(',',$hrefs[0]);


			if($id == []){
				$this->error("404");
			}else{
				if (!in_array($id[0], $hrefs_arr)) {
					$this->error("404");
				}
			}
		}
		return $next($request);
	}


	//自定义错误模板
	public function error($msg){
        $arr = [
            "code" => 0,
            "msg" => $msg
        ];
        $res = view(Config::get('app.exception_msg_tmpl'),$arr);
        throw new HttpResponseException($res);
    }
}

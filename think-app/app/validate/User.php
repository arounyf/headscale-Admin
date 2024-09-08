<?php
declare (strict_types = 1);

namespace app\validate;

use think\Validate;

class User extends Validate
{
    protected $rule =   [
        'username'  => 'require|min:2',
        'password'   => 'require|min:6',
        'vcode' => 'require',    
    ];
    
    protected $message  =   [
        'name.require' => '名称必须填写',
        'name.maminx'     => '名称最少不能低于2个字符',
        'password.require'   => '密码必须填写',
        'password.min'  => '密码最少不能低于6个字符',
        'vcode'        => '验证码必须填写',    
    ];
}

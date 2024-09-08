<?php
declare (strict_types = 1);

namespace app\validate;

use think\Validate;

class Reg extends Validate
{
    protected $rule =   [
        'username' => 'require|alphaNum|min:2',
        'password' => 'require|min:6',
        'cellphone' => 'require|mobile',
        'vcode' => 'require',    
    ];
    
    protected $message  =   [
        'username.require' => '用户名必须填写',
        'username.alphaNum' => '用户名只能是字母和数字',
        'username.maminx' => '名称最少不能低于2个字符',
        'password.require'   => '密码必须填写',
        'password.min'  => '密码最少不能低于6个字符',
        'cellphone.require'  => '手机号码必须填写',
        'cellphone.mobile'  => '手机号码填写错误',
        'vcode'        => '验证码必须填写',    
    ];
}

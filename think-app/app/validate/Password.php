<?php
declare (strict_types = 1);

namespace app\validate;

use think\Validate;

class Password extends Validate
{
    protected $rule =   [
        'oldPassword'   => 'require|min:6',
        'password'   => 'require|min:6',
    ];
    
    protected $message  =   [
        'oldPassword.require'   => '旧密码必须填写',
        'oldPassword.min'  => '旧密码最少不能低于6个字符',
        'password.require'   => '密码必须填写',
        'password.min'  => '密码最少不能低于6个字符',
    ];
}

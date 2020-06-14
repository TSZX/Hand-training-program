<?php


namespace app\admin\validate;


use think\Validate;

class LoginValidate extends Validate
{
    protected  $rule = [
        "username"=>"require",
        "password"=>"require",
        "code"=>"require",

    ];
    protected  $message=[
        "username.require" => "用户名不能为空",
        "password.require" => "密码不能为空",
        "code.require" => "验证码不能为空",
        "password.length" => "密码介于6到20位之间",
    ];
}

<?php

namespace app\admin\controller;

use app\admin\model\AdminModealidatel;

use app\admin\validate\LoginValidate;
use think\captcha\Captcha;
use think\Controller;
use think\db\exception\DataNotFoundException;
use think\db\exception\ModelNotFoundException;
use think\exception\DbException;
use think\Request;

class Login extends Controller
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        //
        return $this->fetch();
    }
    public  function  verfu(){
        $config =    [
            // 验证码字体大小
            'fontSize'    =>    30,
            // 验证码位数
            'length'      =>    3,
            // 关闭验证码杂点
            'useNoise'    =>    false,
            'useCurve'    =>    false,
        ];
        $captcha = new Captcha($config);
        return $captcha->entry();
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return array
     */
    public function save(Request $request)
    {
        //
        $data  = $request->param();
        $validate = new LoginValidate();
        if (!$validate->check($data)){
            return ['code'=>0,'msg'=>$validate->getError()];
        }


        if(!captcha_check($data["code"])){
            return ['code'=>0,'msg'=>"验证码错误"];
        };

        $db = new AdminModealidatel();
        $ret = $db->login($data);
        if($ret){
            try {
                $db_Semester = db("time")->order("id desc")->select();
            } catch (DataNotFoundException $e) {
            } catch (ModelNotFoundException $e) {
            } catch (DbException $e) {
            }
            session("Semester",$db_Semester[0]['Current_semester']);
            return ['code'=>1,'msg'=>"登录成功"];
        }else{
            return ['code'=>0,'msg'=>"登录失败"];
        }

    }


    public  function  logout(){
        session("id",null);
        session("role_id", null);

        $this->redirect(url("Login/index"));



    }


}

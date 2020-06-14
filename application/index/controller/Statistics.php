<?php

namespace app\index\controller;

use app\index\model\ApplicationData;
use app\index\model\Indexcom;
use app\index\model\IndexSemester;
use app\index\model\IndexStudent;
use think\Controller;
use think\db\exception\DataNotFoundException;
use think\db\exception\ModelNotFoundException;
use think\exception\DbException;
use think\Request;
use think\Session;

class Statistics extends Base
{

    public function index()
    {
        $data  = Request::instance()->param();
        $sem_list = new IndexSemester();
        $re_list = null;
        try {
            $re_list = $sem_list->select();

        } catch (DataNotFoundException $e) {
        } catch (ModelNotFoundException $e) {
        } catch (DbException $e) {
        }
        $page = 0 ;
        if(isset($data['page']))
        {
            $page = $data['page'];
        }
        if(empty($data["com"])){
            $Base = new IndexStudent();
            $data['com'] = null;
        }else{
            $Base = new Indexcom();

        }
        $this->assign("semlist",$re_list);//总页面
        $info = Session::get('info');
        $return =  $Base->get_lsit($info, $data['com'],$page);
        $this->assign("list",$return["data"]);
        $this->assign("last_page",$return["last_page"]);//当前页面
        $this->assign("current_page",$return["current_page"]);//总页面

        return $this->fetch();
    }
}



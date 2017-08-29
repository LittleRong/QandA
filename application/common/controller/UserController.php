<?php
namespace app\common\controller;

use think\Controller;
use app\common\model\PermissionModel;
use think\Session;

class UserController extends Controller{
  public function _initialize(){
    if(!Session::get('user_id')){//用户未登录,进入登录页面
        $this->redirect('index/login/index');//用户未登录,进入登录页面
    }
    $user_id=Session::get('user_id');
    $permission_model = new PermissionModel();//实例化用户模型
    if($permission_model->isManager($user_id)){//管理员
        $this->redirect('index/usermanage/user_manage');//进入普通用户个人中心
    }
  }
}

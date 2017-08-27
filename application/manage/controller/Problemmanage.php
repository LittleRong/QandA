<?php

namespace app\manage\controller;

use think\Controller;
use think\Request;
use think\View;
use app\manage\model\ProblemModel;
use app\manage\model\UserModel;
use think\Session;

class Problemmanage extends Controller{
    public function problem_manage(){
      if(Session::get('user_id')){//用户已经登陆，直接进入用户中心
          $user_id=Session::get('user_id');
          $user_model = new UserModel();//实例化用户模型
          if($user_model->isManager($user_id)){//管理员
              //获取题目信息
              $problem_model = new ProblemModel();
              $data=$problem_model->showAllProblem();
              $this->assign('data',$data);
              return $this->fetch('problem_manage');
          }else{//普通用户
              //注销session
              session(null);
              return $this->fetch('index@login/index');//进入登陆界面
          }
      }else{
          return $this->fetch('index@login/index');//用户未登录，进入登陆界面
      }
    }

    // //新增题目
    // public function add_problem(Request $request){
    //   if($request->isPost()){//判断是否为POST方法
    //       $data=$request->param();
    //       $problem_content=$data['problem_content'];
    //       $problem_class=$data['problem_class'];
    //       $problem_type=$data['problem_type'];
    //       $problem_model = new ProblemModel();
    //       $result = $problem_model->add_problem($problem_content,$problem_class,$problem_type);//插入并返回插入的题目信息
    //       return json_encode($result);
    //   }
    // }
    //
    // //更新题目
    // public function update_problem(Request $request){
    //   if($request->isPost()){//判断是否为POST方法
    //       $data=$request->param();
    //       $problem_id=$data['problem_id'];
    //       $problem_content=$data['problem_content'];
    //       $problem_class=$data['problem_class'];
    //       $problem_type=$data['problem_type'];
    //       $problem_model = new ProblemModel();
    //       $result = $problem_model->update_problem($problem_id,$problem_content,$problem_class,$problem_type);
    //       return json_encode($result);
    //   }
    // }
    //
    // //删除题目
    // public function delete_problem(Request $request){
    //       if($request->isPost()){//判断是否为POST方法
    //         $data=$request->param();
    //         $delete_id=$data['delete_id'];
    //         $problem_model = new ProblemModel();
    //         $result = $problem_model->delete_problem($delete_id);
    //         return json_encode($result);
    //       }
    // }

}

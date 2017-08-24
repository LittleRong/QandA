<?php
namespace app\index\model;
use think\Model;
use think\Db;

class UserModel extends Model{
    protected $table = 'user';// 对应数据库中的user表

    //登录查询
    public function login($username,$password){
        $query=['login_name'=>$username,'pwd'=>md5($password)];
        $result = $this->get($query);
        if (empty($result)) {//获取数据，若不存在则返回空
            return null;
        }
        return $result;   //返回用户信息
    }

    //修改密码操作
    public function change_pwd($user_id,$old_password,$new_password){
        //检查旧密码是否正确
        $query=['id'=>$user_id,'pwd'=>md5($old_password)];
        $result = $this->get($query);
        $data = [];
        if (empty($result)) {//若旧密码不正确，返回错误信息
            $data['result']="原密码不正确";
        }else{//进行修改操作
            $this->save([
                'pwd'  => md5($new_password)
            ],['id' => $user_id]);
            $data['result']="修改成功";
        }
        return $data;
    }

    public function showAllUser(){
        $query=['deleted'=>0];
        $result = $this->where('deleted',0)->field('id,login_name,name,phone_number,job_number,gender')->select();
        return $result;
    }

    //判断是否为管理员
    public function isManager($user_id){
      $query=['id'=>$user_id];
      $result = $this->get($query);
      if($result->getAttr('permission')==1){
          return true;
      }else{
          return false;
      }
    }

    //获取用户信息
    public function getMessageById($user_id){
      $query=['id'=>$user_id];
      $result = $this->get($query);
      if (empty($result)) {//获取数据，若不存在则返回空
          return null;
      }
      return $result;   //返回用户信息
    }

    //增加用户
    public function add_user($user_name,$login_name,$password,$user_phone_number,$user_job_number,$user_gender){
        $this->data([
            'name'  =>  $user_name,
            'login_name' =>  $login_name,
            'pwd'  =>  $password,
            'phone_number' =>  $user_phone_number,
            'job_number'  =>  $user_job_number,
            'permission' => 0,
            'gender' =>  $user_gender,
            'deleted' => 0
        ]);
        $this->save();
        $new_user_id=$this->id;
        //查询新信息
        $query=['id'=>$new_user_id];
        $result = $this->get($query);
        if (empty($result)){
          return null;
        }else{
          return $result;
        }
    }

    //更新用户
    public function update_user($user_id,$user_name,$login_name,$user_phone_number,$user_job_number,$user_gender){
        $this->save([
        'name'  =>  $user_name,
        'login_name' =>  $login_name,
        'phone_number' =>  $user_phone_number,
        'job_number'  =>  $user_job_number,
        'gender' =>  $user_gender
        ],['id' => $user_id]);
        $data['result']="更新成功";
        return $data;
    }

    //删除用户
    public function delete_user($delete_id){
        $this->destroy(['id' => $delete_id]);
        $data['result']="删除成功";
        return $data;
    }

}

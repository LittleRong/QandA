<?php
namespace app\index\model;
use think\Model;
class UserModel extends Model{
    protected $table = 'user';// 对应数据库中的user表

    //登录查询
    public function login($username,$password)
    {
        $query=['login_name'=>$username,'pwd'=>md5($password)];
        $result = $this->get($query);
        if (empty($result)) {//获取数据，若不存在则返回空
            return null;
        }
        return $result;   //返回用户信息
    }

}

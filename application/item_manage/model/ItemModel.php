<?php
namespace app\item_manage\model;
use think\Db;
use think\Model;

class ItemModel extends Model{
    protected $table = 'item';// 对应数据库中的user表
    
    public function show(){
        return Db::table($this->table)->select();
    }
    
    public function findData($id){
        return Db::table($this->table)->where('item_id','=',$id)->find();     
    }
    
    public function updateData($data,$id){
        return Db::table($this->table)->where('item_id','=',$id)->update($data);
    }
    
    public function deleteData($id){
        return Db::table($this->table)->where('item_id','=',$id)->delete();   
    }
    
    public  function  insertData($data){
        return Db::table($this->table)->insertGetId($data);
    }
    
    public function addTodatabase($item_name,
        $item_description,$change_rule,$amount,$team_amount){
        $insertdata = [
            'item_name'=>$item_name,'item_description'=>$item_description,
            'change_rule'=>$change_rule,'amount'=>$amount,
            'team_amount'=>$team_amount];
        $mark = db('item')->insert($insertdata);
        return $mark;
    }
    
}
<?php
namespace app\item_manage\controller;

use app\item_manage\model\ItemModel;
use think\Controller;
use think\Request;
use think\View;
use app\common\controller\ManageController;

class Item extends ManageController{
    public function index(){
       $view = new View();
       $item = new ItemModel();
       $arr = $item->show();
       return $view->fetch('test',['arr' => $arr]);

    }

    public function addindex(){
        $view = new View();
        return $view->fetch('additem');
    }

    public function showAlldata(){
        $item = new ItemModel();
        $arr = $item->show();
        return $this->fetch('show',['arr' => $arr]);
    }

    public function update(Request $request){
        if($request->isPost()){//判断是否为POST方法
            $item = new ItemModel();
            $data = $request->post();
            $id = $data['item_id'];
            $result = $item->updateData($data,$id);
            if ($result) {
                $data = array('result'=>'修改成功');
                return json_encode($data);
            } else {
                $data = array('result'=>'修改失败');
                return json_encode($data);
            }
        }
    }

    public function delete(Request $request){
        if($request->isPost()){//判断是否为POST方法
            $data = $request->param();
            $item_id = $data['item_id'];
            $item = new ItemModel();
            $result = $item->deleteData($item_id);
            if ($result) {
                //$this->success('删除成功', 'item/showAlldata');
                $data = array('result'=>'删除成功');
                return json_encode($data);
            } else {
                //$this->error('删除失败');
                $data = array('result'=>'删除失败');
                return json_encode($data);
            }
        }
    }

    public function save(){
        $id = $_POST['item_id'];
        $request = Request::instance();
        $data = $request->post();
        $item = new ItemModel();
        $result = $item->updateData($data,$id);
        if ($result) {
            $this->success('修改成功', 'item/showAlldata');
        } else {
            $this->error('修改失败');
        }
    }

    public function insert(Request $request)
    {
        if($request->isPost()){//判断是否为POST方法
            $data = $request->post();
            $item = new ItemModel();
            $result = $item->insertData($data);
            if ($result) {
                $data = array('result'=>'新增成功');
                return json_encode($data);
            } else {
                $data = array('result'=>'新增失败');
                return json_encode($data);
            }
        }

    }



}

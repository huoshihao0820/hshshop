<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class Studentcontroller extends Controller
{
    //添加
    public function add(){
        return view('/student/add');
    }
    //执行添加
    public function add_do(request $request){
        $data=$request->all();
        if (empty($data['brand_name'])){
            echo "<script>alert('图书不可无名');location='/student/add'</script>";
        }
        if (empty($data['brand_url'])){
            echo "<script>alert('链接地址不可空白');location='/student/add'</script>";
        }
        unset($data['_token']);
        if ($request->hasFile('brand_img')){
            $data['brand_img']=$this->uplode('brand_img');
        }
//        dd($data);
        $res=DB::table('brand_info')->insert($data);
        if ($res) {
            echo "<script>alert('添加成功');location='/student/show'</script>";
        }else{
            echo "<script>alert('添加失败');location='/student/add'</script>";
        }

    }
    //上传图片
    public function uplode($name){
//        $img=request()->file('$img');
//        $path =$img->store('','public');
        $brand_img = request()->file($name);
        $store_result = $brand_img->store('','public');
        return $store_result;
//        return $path;
    }
    //列表展示
    public function show(){
        $data=DB::table('brand_info')->get();
//        dd($data);
        return view('student/show',['data'=>$data]);
    }
    //修改页面
    public function update($id){
//        dd($id);
        $date=DB::table('brand_info')->where(['brand_id'=>$id])->first();
//        dd($date);
        return view('student/update',['date'=>$date]);
    }
    //修改执行
    public function update_do($id){
        $data=\request()->all();
//        dd($data);
        unset($data['_token']);
        if (request()->hasFile('brand_img')){
            $data['brand_img']=$this->uplode('brand_img');
        }
        $res=DB::table('brand_info')->where(['brand_id'=>$id])->update($data);
        if ($res) {
            echo "<script>alert('修改成功');location='/student/show'</script>";
        }else{
            echo "<script>alert('修改失败');location='/student/show'</script>";
        }

    }
    //删除页面
    public function delete($id){
        $res=DB::table('brand_info')->where(['brand_id'=>$id])->delete();
        if ($res) {
            echo "<script>alert('删除成功');location='/student/show'</script>";
        }else{
            echo "<script>alert('删除失败');location='/student/show'</script>";
        }

    }
}

<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BrandModel;
class BrandController extends Controller
{
    public function add(){
        return view('brand/add');
    }
    public function add_do(request $request){
        $data=$request->all();
        unset($data['_token']);
        if ($request->hasFile('s_img')){
            $data['s_img']=$this->uplode('s_img');
        }
        $res=BrandModel::insert($data);
        if ($res){
            echo "<script>alert('添加成功');location='/brand/show'</script>>";
        }else{
            echo"<script>alert('添加失败');location='/brand/add'</script>";
        }
    }
    public function uplode($name){
        $brand_img = request()->file($name);
        $store_result = $brand_img->store('','public');
        return $store_result;

    }
    public function show(request $request){
        $query=$request->all();
        $s_name=$request->s_name;
        $key=$request->key;
        $keyval=$request->keyval;
        $where=[];
        if ($s_name){
            $where[]=['s_name','like',"%".$s_name."%"];
        }

        if ($key){
            $where[]=[$key,'=',$keyval];
        }
        $pagesize=config('app.pageSize');
        $BrandInfo=BrandModel::where($where)->paginate($pagesize);
        return view('brand/show',['BrandInfo'=>$BrandInfo],compact('query'));
    }
    public function delete(request $request,$id){
        $res=BrandModel::where('s_id','=',$id)->delete();
        if ($res){
            echo "<script>alert('删除成功');location='/brand/show'</script>>";
        }else{
            echo"<script>alert('删除失败');location='/brand/show'</script>";
        }
    }
    public function update(request $request,$id){
        $BrandModel=new BrandModel;
        $data=$BrandModel->where(['s_id'=>$id])->first();
//        dd($data);
        return view('brand/update',['data'=>$data]);
    }
    public function update_do(request $request,$id){
        $data=$request->all();
        unset($data['_token']);
        if ($request->hasFile('s_img')){
            $data['s_img']=$this->uplode('s_img');
        }
        $BrandModel=new BrandModel;
        $res=$BrandModel->where(['s_id'=>$id])->update($data);
        if ($res){
            echo "<script>alert('修改成功');location='/brand/show'</script>>";
        }else{
            echo"<script>alert('修改失败');location='/brand/update/$id'</script>";
        }

    }
    public function checkname(request $request){
        $name=$request->name;
        $id=$request->id;
        $where=[];
        if ($name){
            $where[]=['s_name','=',$name];
        }
        if ($id){
            $where[]=['s_id','<>',$id];
        }
        $count=BrandModel::where($where)->count();
        echo $count;
    }
    public function del(request $request){
        $id=$request->s_id;
//        echo $id;
        $res=BrandModel::where('s_id',$id)->delete();
        if ($res){
            echo "1";
        }else{
            echo"2";
        }
    }
}

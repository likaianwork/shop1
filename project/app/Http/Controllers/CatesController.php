<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\cate;
use DB;

class CatesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //获取分类信息
        //原声sql 语句的写
        $info= self::getcates();
     return view('admin.cate.index',['cates'=>$info,'request'=>$request]);
    }
    //获取分类数据
    public static function  getcates(){
        $info= cate::select(DB::raw('*, concat(path,",",id) as paths'))->orderBy('paths')->get();
      //dd($info);
      //循环遍历$info
      foreach($info as $key=>$value){
         //将字符串拆分成数组 ，在统计数组的个数
         $tmp= count(explode(',',$value->path))-1;
         $prf= str_repeat('--',$tmp);
         $value->name=$prf.$value->name;
      }
      return $info;

    }

    /**
     * 显示一个表单用于创建分类
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //读取所有分类
        $cates=cate::get();
       return view('admin.cate.add',['cates'=>$cates,'request'=>$request]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data= $request->all();
         $cate= new cate;
        if($data['pid']==0){
          $cate['path']="0";
        }else{
            $info=cate::find($data['pid']);
            //分类的path 父级分类的Path,父级的id
            $cate['path']=$info['path'].','.$info['id'];

        }
        $cate->name=$data['name'];
        $cate->pid=$data['pid'];
        if($cate->save()){
            return  redirect('/cate')->with('info','分类添加成功');
        }else{
            return back()->with('info','分类添加失败');
        }

        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //读取当前分类信息
        $info= Cate::findOrFail($id);
        $cate= Cate::get();

        //解析模板
        return view('admin.cate.edit',['info'=>$info,'cates'=>$cate]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $cate=Cate::findOrFail($id);
        $cate->name=$request->name;
        $cate->pid=$request->pid;
        if($cate->save()){
            return redirect('/cate')->with('info','修改分类成功');
        }else{
            return back()->with('info','修改分类失败');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
	public function works(){
		dd(sdfg);
		}
    public dd(user){}

}

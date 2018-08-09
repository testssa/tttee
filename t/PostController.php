<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\post;
class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = post::all();
        return view('adminPanel.post.index'  , compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('adminPanel.post.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data  = $this->validate($request , [
            'name'=>'required',
            'desc'=>'required',
            'image'=>'required|image|mimes:jpeg,bmp,png,jpg'
        ],[]);

        if ($request->hasFile('image')) {
            $data['image'] =  $request->file('image')->store('postImage');
        }

        post::create($data);
        session()->flash('success', 'تم اضافة المقال بنجاح');
        return redirect('adminPanel/posts');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $showPost = post::find($id);
        return view('adminPanel.post.edit' ,compact('showPost'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

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
        $data = $this->validate($request , [
            'name'=>'required',
            'desc'=>'required',
            'image'=>'nullable|image|mimes:jpeg,bmp,png,jpg'
        ]);

        if ($request->hasFile('image')) {
            if (!empty(imagepost()->image)) {
                \Storage::delete(imagepost()->image);
            }
             $data['image'] = $request->file('image')->store('postImage');
        }
        post::where('id', $id)->update($data);
        session()->flash('success' ,'تم تعديل البيانات بنجاح');
        return redirect('adminPanel/posts');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $deleteWimage = post::findOrFail($id);
      $file_path = storage_path('app/public/').$deleteWimage->image;
      if(file_exists($file_path)){
          @unlink($file_path);
      }
      $deleteWimage->delete();
      session()->flash('success' ,'تم حذف البيانات بنجاح');
      return redirect('adminPanel/posts');

    }
}

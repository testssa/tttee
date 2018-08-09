<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::all();
        return view('adminPanel.user.index' , compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('adminPanel.user.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $this->validate($request , [
            'name'=>'required|max:10',
            'email'=>'required|email',
            'password'=>'required',
            'image'=>'image|mimes:mimes:jpeg,bmp,png,jpg',
        ],[
        'name.required' => 'حقل الاسم مطلوب',
        'email.required' => 'حقل الايميل مطلوب',
        'password.required'=>'حقل كلمة المرور مطلوب',
      ]);
       if ($request->hasFile('image')) {
        $data['image'] = $request->file('image')->store('userImage');
      }
        $data['password'] = bcrypt($request->password);
        User::create($data);
        session()->flash('success', 'تم اضافة البيانات بنجاح');
        return redirect('adminPanel/users');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $userEdit  = User::find($id);
        return view('adminPanel.user.edit' , compact('userEdit'));
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
        'name' => 'required',
        'email' => 'required|email|unique:users,email,' .$id,
        'password' => 'sometimes|nullable|min:6',
        ]);
        if ($request->has('password')) {
        $data['password'] = bcrypt($request->password);
        }
        User::where('id', $id)->update($data);
        session()->flash('success' ,'تم تعديل البيانات بنجاح');
        return redirect('adminPanel/users');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $deleteWimage = User::findOrFail($id);
      $file_path = storage_path('app/public/').$deleteWimage->image;
      if(file_exists($file_path)){
          @unlink($file_path);
      }
      $deleteWimage->delete();
      session()->flash('success' ,'تم حذف البيانات بنجاح');
      return redirect('adminPanel/users');

    }
}

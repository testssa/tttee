<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\settings;
class settingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $showData = settings::orderBy('id', 'desc')->first();
      return view('adminPanel.settings.setting'  , compact('showData'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
          'namewebsite'=>'required',
          'namedashborad'=>'required',
          'descwebite'=>'required',
          'icon'=>'sometimes|image|mimes:jpeg,bmp,png,jpg',
          'logo'=>'sometimes|image|mimes:jpeg,bmp,png,jpg'
      ]);

      if ($request->hasFile('icon')) {
          if (!empty(settingImage()->icon)) {
              \Storage::delete(settingImage()->icon);
          }
           $data['icon'] = $request->file('icon')->store('settingImage');
      }
      if ($request->hasFile('logo')) {
          if (!empty(settingImage()->logo)) {
              \Storage::delete(settingImage()->logo);
          }
           $data['logo'] = $request->file('logo')->store('settingImage');
      }
      settings::where('id', $id)->update($data);
      session()->flash('success' ,'تم تعديل البيانات بنجاح');
      return redirect('adminPanel/settings');
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
}

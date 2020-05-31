<?php

namespace App\Http\Controllers\dash;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Message;
use Illuminate\Support\Facades\Session;
class MessageController extends Controller
{
   
    public function index()
    {
        //
    }

  
    public function create()
    {
        //
    }
    public function store(Request $request)
    {
         $rules = 
           [
            'name'     => 'required|string|max:120',
            'email'     => 'required|email',
            'message'     => 'required',
            ];

        $this->validate($request , $rules);
        $data = $request->all();
        $msg = Message::create($data);
        //Session
        Session::flash('message' , ' تم ارسال رسالتك بشكل ناجح ');
        //redirect
        return redirect()->route('welcomeView');
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
        //
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

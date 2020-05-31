<?php

namespace App\Http\Controllers\dash;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use App\Account;
class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $accounts = Account::all();
        
         return view('dashboard.accounts.show',compact('accounts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       return view('dashboard.accounts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = 
           [
            'nameAccount'     => 'required',
            'numberAccount'     => 'required',
            'appearance'     => 'required',
            ];

        $this->validate($request , $rules);
        $data = $request->except('image');
         if ($request->hasFile('image')) {
            $filename = time() . '-' . $request->image->getClientOriginalName();
            $request->image->move(public_path('pictures/accounts'), $filename);
            $data['image'] = $filename;
        }
        $account = Account::create($data);
        Session::flash('message' , 'تم  اضافة  حساب بنجاح ');
        //redirect
        return redirect()->route('accounts.index');
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
         $account = Account::where('id',$id)->first();
        return view('dashboard.accounts.edit',compact('account'));
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
        $account = Account::findOrFail($id);
        $rules = 
           [
            'nameAccount'     => 'required',
            'numberAccount'     => 'required',
            'appearance'     => 'required',
            ];
        $this->validate($request ,$rules );
        $data = $request->except('image');
         if ($request->hasFile('image')) {
            $filename = time() . '-' . $request->image->getClientOriginalName();
            $request->image->move(public_path('pictures/accounts'), $filename);
            $data['image'] = $filename;
        }
        $account->update($data);
        Session::put('message','تم التعديل بشكل ناجح ');
        //redirect
        return redirect()->route('accounts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $account = Account::findOrFail($id);

        $account->delete();

        Session::flash('message','تم  المسح بنجاح');

        return redirect()->back();
    }
}
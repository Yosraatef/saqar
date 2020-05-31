<?php

namespace App\Http\Controllers\dash;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use App\Commission;
use App\User;
use App\Alert;
use App\Notification;
class CommissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $commissions = Commission::all();
        
         return view('dashboard.commissions.show',compact('commissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::all();
      return view('dashboard.commissions.create', compact('users'));
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
            'user_id'     => 'required',
            'price'     => 'required',
           
            ];

        $this->validate($request , $rules);
        $data = $request->all();
        $alert = Alert::create($data);
        $user = User::where('id', $alert->user_id)->first();
         $notification = Notification::create([
                  'user_id' => $alert->user_id,
                  'content' => 'من فضلك   ' . $user->name .  ' قم بسداد العمولة   '. $alert->price ,
                    'type'    => 4,
                  ]);
        if (!empty($user->device_token)) {
                  NotificationsRepository::pushNotification($user->device_token, 'تعليق جديد', $notification->content, ['user_id' => $notification->user_id , 'status' => ' من فضلك قم بسداد عمولة التطبيق ']);
               }
        Session::flash('message' , 'تم  ارسال اشعار للعميل  بنجاح ');
        //redirect
        return redirect()->route('commissions.create');
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
         $commission = Commission::where('id',$id)->first();
        return view('dashboard.commissions.edit',compact('commission'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function update(Request $request, $id)
    // {
    //     $account = Account::findOrFail($id);
    //     $rules = 
    //       [
    //         'nameAccount'     => 'required',
    //         'numberAccount'     => 'required',
    //         'appearance'     => 'required',
    //         ];
    //     $this->validate($request ,$rules );
    //     $data = $request->except('image');
    //      if ($request->hasFile('image')) {
    //         $filename = time() . '-' . $request->image->getClientOriginalName();
    //         $request->image->move(public_path('pictures/accounts'), $filename);
    //         $data['image'] = $filename;
    //     }
    //     $account->update($data);
    //     Session::put('message','تم التعديل بشكل ناجح ');
    //     //redirect
    //     return redirect()->route('accounts.index');
    // }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $commission = Commission::findOrFail($id);

        $commission->delete();

        Session::flash('message','تم  المسح بنجاح');

        return redirect()->back();
    }
}
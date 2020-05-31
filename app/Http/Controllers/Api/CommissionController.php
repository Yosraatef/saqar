<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Commission;
use App\Account;
use App\Services;
use App\User;
use App\Category;
use App\Notification;
class CommissionController extends Controller
{
   public function getAccounts()
    {
        $arr = array();
        $accounts = Account::all();
        foreach($accounts as $account){
            array_push($arr, array(
                  "id"=> $account->id,
                  "nameAccount" => $account->nameAccount,
                  "numberAccount" => $account->numberAccount,
                  "appearance" => $account->appearance,
                  "beneficiary" => $account->beneficiary,
                  "image" => $account->image,
                  
            ));
     }
            
           return response()->json(['msg'=>'success','data' => $arr]);
         
    }
    
     public function addAmountMony(Request $request)
    {
        $user = auth()->guard('api')->user();
         $validator= validator()->make($request->all(),[
            'amountMony'     => 'required|numeric',
            
            ]);
            
           if($validator->fails()){
            //422 not validation
            return response()->json(['msg' =>"false",'data'=>$validator->errors()]);
                                }
        //$commission = Commission::where('service_id',$request->service_id)->first();
        $serviceId = Services::where('user_id', $user->id)->first();
          $data = $request->except('user_id','service_id');
          $data['user_id'] = $user->id;
          $data['service_id'] = $serviceId->id;
          $commission = Commission::create($data);
           return response()->json(['msg'=>'success','data' => $commission]);
         
    }
    public function addCommission(Request $request)
    {
        $user = auth()->guard('api')->user();
         $validator= validator()->make($request->all(),[
            'imageRecepit'     => 'required',
            'accountNumber'     => 'required',
            
            ]);
           if($validator->fails()){
            return response()->json(['msg' =>'false','data'=>$validator->errors()]);}
        $userId = Services::where('user_id', $user->id)->first(); 
        $commission = Commission::where('service_id',$userId->id)->first();
          $data = $request->except('imageRecepit');
          if ($request->hasFile('imageRecepit')) {
            $filename = time() . '-' . $request->imageRecepit->getClientOriginalName();
            $request->imageRecepit->move(public_path('pictures/commissions'), $filename);
            $data['imageRecepit'] = $filename;
        }
        $commission->update($data);
         $userId = Services::where('id', $commission->service_id)->first();
         $userDeviceToken = User::where('id',$userId->user_id)->first();
         $cat = Category::where('id', $userId->category_id)->first();
         //$subCategoryName = SubCategory::where('id', $userId->subCategory_id )->value('name');
         $com = ($commission->amountMony)*($cat->commission / 100);
         $notification = Notification::create([
                  'user_id' => $userId->user_id,
                  'content' => 'قام  ' . $user->name .  ' بسداد عمولة  ' .' ' . $cat->name.' ' .'بقيمة'.' '. $com ,
                  ]);
        if (!empty($userDeviceToken->device_token)) {
                  NotificationsRepository::pushNotification($userDeviceToken->device_token, 'تعليق جديد', $notification->content, ['user_id' => $notification->user_id , 'status' => 'سداد العمولة  ']);
               }
           return response()->json(['msg'=>'success','data' =>[
               "commission" => $commission ,
               "com"=> $com,
               "notification"=> $notification,
               ]]);
         
    }
}
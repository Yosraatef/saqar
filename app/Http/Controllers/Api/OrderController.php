<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order;
use App\Notification;
use DB;
class OrderController extends Controller
{
    
    public function addOrder(Request $request)
    {   
        $user = auth()->guard('api')->user();
         $validator= validator()->make($request->all(),[
            'service_id'     => 'required',
            ]);
            
           if($validator->fails()){
            //422 not validation
            return response()->json(['msg' =>'false','data'=>$validator->errors()]);
                                }
          $data = $request->except('user_id');
          $data['user_id'] = $user->id;
          $order = Order::create($data);
          $service = DB::table('services')->where('id',$order->service_id)->first();
          $subCategoryName = DB::table('sub_categories')->where('id',$service->subCategory_id)->value('name');
          $cat = DB::table('categories')->where('id',$service->category_id)->first();
          $userNoty = DB::table('users')->where('id',$service->user_id)->first();
          //($userNoty->id , $user->id);
            if(is_null($subCategoryName)){
                 $notification = Notification::create([
                          'user_id' => $userNoty->id,
                          'content' => 'قام' . $user->name . 'بطلب خدمة' . $cat->name ,
                          ]);
               
            }else{
               $notification = Notification::create([
                  'user_id' => $userNoty->id,
                  'content' => 'قام  ' . $user->name .  'بطلب خدمه  ' . $subCategoryName.' ' . $cat->name ,
                  'type'    => 1
                  ]); 
            }
               
               if (!empty($userNoty->device_token)) {
                  NotificationsRepository::pushNotification($userNoty->device_token, 'تعليق جديد', $notification->content, ['user_id' => $notification->user_id , 'status' => 'طلب خدمة جديدة']);
               }
       
        //redirect
       return response()->json(['msg'=>'success','data' => [
           'order' => $order,
           'notification' => $notification,
           'subCategoryName'=>$subCategoryName,
           'catName'=>$cat->name,
           ]
           ] );
    }
    public function detailsOrder(Request $request)
    {  
        $order = Order::where('id', $request->order_id)->first();
        $user = DB::table('users')->where('id',$order->user_id)->first();
        $service = DB::table('services')->where('id', $order->service_id)->first();
        $subCategoryName = DB::table('sub_categories')->where('id',$service->subCategory_id)->value('name');
        $cat = DB::table('categories')->where('id',$service->category_id)->value('name');
        if(is_null($subCategoryName)){
            return response()->json(['msg'=>'success','data' => [
                            'order' => $order,
                            'userName' => $user->name,
                            'imageProfile' => $user->imageProfile,
                            'phone' => $user->phone,
                            'address' => $service->address,
                            "long" => $service->long,
                            "lat" => $service->lat,
                            "service" => $cat,
                            ]] );
               
            }else{
               return response()->json(['msg'=>'success','data' => [
                'order' => $order,
                'userName' => $user->name,
                'imageProfile' => $user->imageProfile,
                'phone' => $user->phone,
                'address' => $service->address,
                "long" => $service->long,
                "lat" => $service->lat,
                "service" => $subCategoryName,
                ]] );
            }
        
    }
    public function acceptanceOrder(Request $request)
    {  
             $order = Order::where('id', $request->order_id)->first();
             //dd($request->status);
              if($request->status == 1)
              {
                  //dd($request->status);
                $cc = DB::table('orders')->where('id',$request->order_id)->update(['status' => 1]);
               // dd($cc);
                return response()->json(['msg'=>'success','data' => 'تم قبول الطلب وسنرسل اشعار بالقبول لصاحب الطلب'] );
            }
            else 
              {

                 $xx = DB::table('orders')->where('id',$request->order_id)->update(['status' => 0]);
                // dd($xx);
                 return response()->json(['msg'=>'success','data' => 'تم رفض الطلب بنحاح وسنرسل اشعار بالرفض لصاحب الطلب']);
              }
        
      
    }
     public function acceptancePrice(Request $request)
    {  
             $order = Order::where('id', $request->order_id)->first();
             //dd($request->status);
              if($request->acceptPrice == 1)
              {
                  //dd($request->status);
                $orderUpdate = Order::where('id',$request->order_id)->first();
                $orderUpdate->acceptPrice = 1;
                $orderUpdate->save();
               // dd($orderUpdate);
                $service = DB::table('services')->where('id',$order->service_id)->first();
                $user = DB::table('users')->where('id',$service->user_id)->first();
               $notification = Notification::create([
                  'user_id' => $user->id,
                  'content' => ' تمت الموافقه على السعر المقدم من  '. $user->name .'بسعر    ' .  $order->price ,
                  'type'    => 2
                  ]); 
                 if (!empty($user->device_token)) {
                      NotificationsRepository::pushNotification($user->device_token, 'تعليق جديد', $notification->content, ['user_id' => $notification->user_id , 'status' => 'الموافقه على السعر   ']);
                   }
                return response()->json(['msg'=>'success','data' => [
                    
                    "order" => $orderUpdate,
                    "notification" => $notification,
                    
                    ]
                
                ] );
            }
            else 
              {

                 $orderUpdate = DB::table('orders')->where('id',$request->order_id)->update(['acceptPrice' => 0]);
                 $service = DB::table('services')->where('id',$order->service_id)->first();
                $user = DB::table('users')->where('id',$service->user_id)->first();
               $notification = Notification::create([
                  'user_id' => $user->id,
                  'content' => ' تمت الرفض على السعر المقدم من  '. $user->name .'بسعر    ' .  $orderUpdate->price ,
                  'type'    => 2
                  ]); 
                 if (!empty($user->device_token)) {
                      NotificationsRepository::pushNotification($user->device_token, 'تعليق جديد', $notification->content, ['user_id' => $notification->user_id , 'status' => 'الموافقه على السعر   ']);
                   }
                return response()->json(['msg'=>'success','data' => [
                    
                    "order" => $orderUpdate,
                    "notification" => $notification,
                    
                    ]
                
                ] );
              }
        
      
    }
    public function addPriceOrder(Request $request)
    {
        $orderPrice = Order::where('id', $request->order_id)->first();
        if( $orderPrice->status == 1)
        {
             $orderPrice->price = $request->price;
             $orderPrice->save();
            $userNoty = DB::table('users')->where('id',$orderPrice->user_id)->first();
            $service = DB::table('services')->where('id', $orderPrice->service_id)->first();
            $userService = DB::table('users')->where('id',$service->user_id)->value('name');
            $notification = Notification::create([
                  'user_id' => $orderPrice->user_id,
                  'content' => ' تمت الموافقه على طلبك من قبل مقدم الخدمة '. $userService .'بسعر    ' .  $orderPrice->price ,
                  'type'    => 3
                  ]); 
             if (!empty($userNoty->device_token)) {
                  NotificationsRepository::pushNotification($userNoty->device_token, 'تعليق جديد', $notification->content, ['user_id' => $notification->user_id , 'status' => 'الموافقه على طلبك   ']);
               }
            return response()->json(['msg'=>'success','data' => [
                "orderPrice" => $orderPrice,
                "notification" =>$notification,
                
                ]]);
        }
        return response()->json(['msg'=>'success','data' => $order]);
    }
    public function getNotfy(Request $request)
    {
    
        $arr = array();
        $notfications = Notification::with('user')->where(['user_id'=>$request->user_id ])->get();
        foreach($notfications as $notfication){
        	$order = DB::table('orders')->where('user_id', $notfication->user_id)->first();
        	//dd($order);
        	$servce = DB::table('services')->where('id', $order->service_id)->first();
        	//dd($servce);
        	 $catName = DB::table('categories')->where('id', $servce->category_id)->value('name');
        	$subCatName = DB::table('sub_categories')->where('id', $servce->subCategory_id)->value('name');   
        	
        	
        	
            array_push($arr, array(
                  "notfication"=> $notfication,
                  "order" => $order,
                  "servce"=> $servce,
                  "catName" => $catName,
                  "subCatName" => $subCatName,
                 
            ));
     }
            
           return response()->json(['msg'=>'success','data' => $arr]);
         
    }
}
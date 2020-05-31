<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use App\User;
use App\Services;
use App\Contact;
use Validator;
use Hash;
use App\Setting;
use Illuminate\Support\Facades\Auth;
class AuthController extends Controller
{
     public function registerPhone(Request $request)
    {
         $validator= validator()->make($request->all(),[
            'phone'  => 'required|unique:users',
            'name'  => 'required'
            ]);
            
           if($validator->fails()){
            //422 not validation
            return response()->json(['msg' =>false,'data'=>$validator->errors()]);
                                }
            $data =  $request->except('code','api_token','imageProfile','imageId','is_provider','active');
            $data['code'] = mt_rand(1000,9999);
            $data['api_token'] = Str::random(60);
            $data['password'] = Hash::make($request->password);
             if ($request->hasFile('imageProfile')) {
            $filename = time() . '-' . $request->imageProfile->getClientOriginalName();
            $request->imageProfile->move(public_path('pictures/users'), $filename);
            $data['imageProfile'] = $filename;
            }
         if ($request->hasFile('imageId')) {
            $filename = time() . '-' . $request->imageId->getClientOriginalName();
            $request->imageId->move(public_path('pictures/users'), $filename);
            $data['imageId'] = $filename;
           }
           $data['is_provider'] = 0 ;
           $data['active'] = 0 ;
            $user = User::create($data);
            try{
            //dd(UserController::sendSMS('elnawras code :'.$verifyData['code'], $user->phone) );
          AuthController::sendSMS('Saaqr Verify Code :'.$user->code, $user->phone);
            // dd(UserController::sendSMS('elnawras code :'.$verifyData['code'], $user->phone) );
        }catch(\Exception $e){}
             return response()->json([ 'msg'=>'success' , 
                       'data' => [
                      'id'      => $user->id,
                      'name'      => $user->name,
                      'phone'      => $user->phone,
                      'code'    => $user->code ,
                      'api_token' => $user->api_token,
                      'imageId'   => $user->imageId,
                      'imageProfile'   => $user->imageProfile,
                      'is_provider'   => $user->is_provider,
                      'active'   => $user->active,
                      'device_token'   => $user->device_token,
                        ] 
                        
                        ]);
     
    }
     public static function sendSMS($messageContent, $mobileNumber)
    {
        $user       = 'reaity';
        $password   = 'hamdy100200300';
        $sendername = 'MIZ-WORLD';
        $text       = urlencode($messageContent);
        $to         = $mobileNumber;
        // auth call
        $url        = "http://www.oursms.net/api/sendsms.php?username=$user&password=$password&numbers=$to&message=$text&sender=$sendername&unicode=E&return=full";
        
        //لارجاع القيمه json
        //$url = "http://www.oursms.net/api/sendsms.php?username=$user&password=$password&numbers=$to&message=$text&sender=$sendername&unicode=E&return=json";
        // لارجاع القيمه xml
        //$url = "http://www.oursms.net/api/sendsms.php?username=$user&password=$password&numbers=$to&message=$text&sender=$sendername&unicode=E&return=xml";
        // لارجاع القيمه string 
        //$url = "http://www.oursms.net/api/sendsms.php?username=$user&password=$password&numbers=$to&message=$text&sender=$sendername&unicode=E";
        // Call API and get return message
        //fopen($url,"r");
        $ret = file_get_contents($url);
        return $ret;
    }
    public function activcodeuser(Request $request)
     {  
      		$validator= validator()->make($request->all(),[
            'phone'  => 'required|exists:users,phone',
            ]);
            
           if($validator->fails()){
            //422 not validation
            return response()->json(['msg' =>'false','data'=>$validator->errors()]);
                                }
            $useractive = User::where([['code',$request->code],['phone', $request->phone ]])->first();
            if($useractive)
            {   
                $useractive->active = 1 ;
                 $useractive->save();
                return response()->json([ 'msg'=>'success' , 'data' => 'Corecct Code']);
            }
            else 
            {
                $errorarr = array();
                return response()->json([ 'msg'=>'false' , 'data' => 'false Code']);
            }    
        
     }
     public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'phone'  => 'required',
             'password'     => 'required|min:6',
        ]);
        if($validator->fails()){
            return response(['msg' =>'false' ,'data' => $validator->messages()]);
        }else {
            if (auth()->attempt(['phone' =>$request->input('phone'),'password' =>$request->input('password')])){
                $user = auth()->user();
                $user->device_token = $request->device_token;
                $user->onAvailable = 1;
                $user->save();
                 return response()->json([ 'msg'=>'success' , 
                       'data' => [
                            'id'           => $user->id,
                            'name'         => $user->name ,
                            'phone'        => $user->phone ,
                            'device_token' => $user->device_token ,
                            'api_token'    => $user->api_token,
                            'imageId'      => $user->imageId,
                           'imageProfile'  => $user->imageProfile,
                           'is_provider'   => $user->is_provider,
                           'active'        => $user->active,
                            
                        ] 
                        
                        ]);
            }else {
                return response(['msg' =>"false" ,'data' => 'Unauthorised']);

            }
        }
    }//end login function
    public function reset(Request $request){

        $validator = Validator::make($request->all(),[
            'phone' => 'required'
        ]);
        if($validator->fails()){
            return response()->json(['msg' => 'false', 'data'=> $validator->errors()]);
        }
        $user = User::where('phone', $request->phone)->first();
        if($user){
            $code = rand(1111,9999);
            $user->code = $code;
            $user->save();
            try{
            //dd(UserController::sendSMS('elnawras code :'.$verifyData['code'], $user->phone) );
          AuthController::sendSMS('Saaqr Verify Code :'.$user->code, $user->phone);
            // dd(UserController::sendSMS('elnawras code :'.$verifyData['code'], $user->phone) );
        }catch(\Exception $e){}
            return response()->json([   'msg' => 'success',
                         'data' => [
                              'code' => $code,
                              'phone' => $user->phone,
                             ],
                       
                    ]);
        }else{
            return response()->json(['msg' => 'false' , 'data' => ' No phone similar to the one you entered']);
        }
    }
    public function resetPassword(Request $request){

        $validator = Validator::make($request->all(),[
            'phone' => 'required',
            'password'     => 'required|min:6',
        ]);
        if($validator->fails()){
            return response()->json(['msg' => 'false', 'data'=> $validator->errors()]);
        }
        $user = User::where('phone', $request->phone)->first();
        if($user){
            $user->password = Hash::make($request->password);
            $user->save();
            return response()->json([   'msg' => 'success','data' => 'تم تغير الرقم السري ']);
        }else{
            return response()->json(['msg' => 'false' , 'data' => ' No phone similar to the one you entered']);
        }
    }
   public function editUser(Request $request )
    {
       
       
        $user = User::where([ 'id' => $request->user_id])->first();
        if(is_null($user)){
            return response()->json(['msg'=>false ,'data'=>'not found recourd']);
        }
        $user->name  = isset($request->name)? $request->name :  $user->name;
        $user->phone   = isset($request->phone)? $request->phone :  $user->phone;
       
         if ($request->hasFile('imageProfile')) {
            $filename = time() . '-' . $request->imageProfile->getClientOriginalName();
            $request->imageProfile->move(public_path('pictures/users'), $filename);
            $user->imageProfile = $filename;
            }
         if ($request->hasFile('imageId')) {
            $filename = time() . '-' . $request->imageId->getClientOriginalName();
            $request->imageId->move(public_path('pictures/users'), $filename);
            $user->imageId = $filename;
           }
        if($user){
            $user->save(); 
        }
        return response()->json([ 'msg'=>'success' , 'data' => $user ]);
    }
     public function setting(){
      $arr = array();
      $settings0 = Setting::where(['key'=>'aboutApp'])->value('value');
      $settings1 = Setting::where(['key'=>'aboutApp2'])->value('value');
      $settings2 = Setting::where(['key'=>'aboutApp3'])->value('value');
      $settings3 = Setting::where(['key'=>'conditions'])->value('value');
      $settings4 = Setting::where(['key'=>'who'])->value('value');
      //dd($settings); 
          array_push($arr, array(
               "splash–1"=>$settings0,
               "splash–2"=>$settings1,
               "splash–3"=>$settings2,
               "conditions"=>$settings3,
               "who"=>$settings4,
          ));
          return response()->json(['msg'=>'success','data'=>$arr]);
    }  
    public function contact(Request $request){

      $validator= validator()->make($request->all(),[
            'phone'  => 'required|numeric',
            'message'  => 'required|max:250',
            'name'  => 'required|max:120',
            ]);
            
           if($validator->fails()){
            //422 not validation
            return response()->json(['msg' =>'false','data'=>$validator->errors()]);
                                }
            // $data =  $request->all();
            /// dd($request->name);
            // $contact = Contact::create($data);
                $data = new Contact();
                $data->name = $request->name;             
                $data->phone = $request->phone;             
                $data->message = $request->message;
                $data->save();              
            //dd($data);
             return response()->json([ 'msg'=>'success' , 'data' => $data]);
    }
    
     public function profileUser(Request $request)
    {
        
        $user = User::where('id',$request->user_id)->first();
        if( $user->is_provider == 1){
            //dd($user->is_provider);
            $provider = Services::where('user_id',$user->id)->first();
            return response()->json(['msg'=>'success','data' => [
                
                "user" =>$user,
                "provider" =>$provider,
                ]]);
        }else{
            return response()->json(['msg'=>'success','data' => $user]);
        }
        
    }
   public function logout(Request $request)
    {
    	$validator = Validator::make($request->all(), [
          'user_id' => 'required|numeric|exists:users,id',
        ]);

        if($validator->fails())
        {
            return response()->json(['msg' => 'error' , 'data' => $validator->errors()]);        
        }
        $reservation = User::where('id',$request->user_id)->first();
        $reservation->onAvailable = 0 ;
        $reservation->device_token = 'nullll' ;
        $reservation->save();
         return response()->json([
                    'msg' => 'success',
                    'data' =>$reservation
                    
                    
                    ]);
    }
}
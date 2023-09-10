<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;
use DB;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use App\Helpers\Helper;
use App\Models\{Job,JobRequest,JobRating};

class ApiController extends Controller{
  /* SEND NOTIFICATIONS */
  public function send_notification($data){
    DB::table('notifications')->insert($data);
  }
  /* SEND NOTIFICATIONS */

  /* DECODE IMAGE */
  public function decode_image($img , $path_url, $prefix, $random, $postfix){                                   
    $data = base64_decode($img);
    $file_name = $prefix.$random.$postfix.'.jpeg';
    $file = $path_url.$file_name;
    $success = file_put_contents($file, $data);
    return $file_name; 
  }
  /* DECODE IMAGE */

  /* CACLULATE DISTANCE */
  public function calculate_distance($lon1 , $lat1, $lon2 , $lat2, $unit = 'M'){
    $theta = $lon1 - $lon2;
    $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
    $dist = acos($dist);
    $dist = rad2deg($dist);
    $miles = $dist * 60 * 1.1515;
    $unit = strtoupper($unit);

    if ($unit == "K") {
      return ($miles * 1.609344);
    } else if ($unit == "N") {
      return ($miles * 0.8684);
    } else if ($unit == "M") {
      return $miles;
    } else {
      return '1.2 Miles'; 
    }
  }
  /* CACLULATE DISTANCE */

  /* USERS CUSTOMERS DETAILS */
  public function users_customers_profile(Request $req){
    if (isset($req->users_customers_id)) {
      $email = DB::table('users_customers')->where('users_customers_id', $req->users_customers_id)->get()->count();
      if ($email>0) {
        $userDetail=DB::table('users_customers')->where('users_customers_id', $req->users_customers_id)->get()->first();
        if (isset($userDetail) && $userDetail != null) {
          $response["code"] = 200;
          $response["status"] = "success";
          $response["data"] = $userDetail;
        } else{
          $response["code"] = 404;
          $response["status"] = "error";
          $response["message"] = "User do not exist.";
        }
      } else {
        $response["code"] = 404;
        $response["status"] = "error";
        $response["message"] = "Email does not exits.";
      }
    } else {
      $response["code"] = 404;
      $response["status"] = "error";
      $response["message"] = "All fields are needed.";
    }

    return response()
    ->json(array( 'status' => $response["status"], isset($response["message"]) ? 'message' : 'data' => isset($response["message"]) ? $response["message"] : $response["data"]))
    ->header('Content-Type', 'application/json');
  }
  /* USERS CUSTOMERS DETAILS */

  /* LOGIN USERS CUSTOMERS */
  public function users_customers_login(Request $req){
    if (isset($req->email) && isset($req->password)) {
      $email = DB::table('users_customers')->where('email', $req->email)->get()->count();
      if ($email>0) {
        $data=DB::table('users_customers')->where('email', $req->email)->get();
        $password=$data[0]->password;
        $id = $data[0]->users_customers_id;
        if (md5($req->password) == $password) {
          if($data[0]->status == 'Active'){
            if($req->one_signal_id){
              $update=DB::table('users_customers')->where('email', $req->email)->update(['one_signal_id'=>$req->one_signal_id]);
            }

            $userDetail=DB::table('users_customers')->where('users_customers_id', $id)->get()->first();
            if (isset($userDetail) && $userDetail != null) {
              $response["code"] = 200;
              $response["status"] = "success";
              $response["data"] = $userDetail;
            } else{
              $response["code"] = 404;
              $response["status"] = "error";
              $response["message"] = "User do not exist.";
            }
          } else {
            $response["code"] = 404;
            $response["status"] = "error";
            $response["message"] = "Your account is in ".$data[0]->status." status. Please contact admin.";
          }
        } else {
          $response["code"] = 404;
          $response["status"] = "error";
          $response["message"] = "Password do not match.";
        }
      }else{
        $response["code"] = 404;
        $response["status"] = "error";
        $response["message"] = "Email does not exits.";
      }
    } else {
      $response["code"] = 404;
      $response["status"] = "error";
      $response["message"] = "All fields are needed.";
    }

    return response()
    ->json(array( 'status' => $response["status"], isset($response["message"]) ? 'message' : 'data' => isset($response["message"]) ? $response["message"] : $response["data"]))
    ->header('Content-Type', 'application/json');
  }
  /* LOGIN USERS CUSTOMERS */

  /* SIGNUP USERS CUSTOMERS */
  public function users_customers_signup(Request $req){
    if (isset($req->first_name) && isset($req->last_name) && isset($req->phone) && isset($req->email) && isset($req->password) && isset($req->country_code)) {
      $email = DB::table('users_customers')->where('email', $req->email)->get()->count();

      if($email == 0) {
        if(isset($req->one_signal_id)){
        	$saveData['one_signal_id']        = $req->one_signal_id;
        }

        $saveData['users_customers_type'] = $req->users_customers_type;
        $saveData['first_name']            = $req->first_name;
        $saveData['last_name']            = $req->last_name;
        $saveData['phone']                = $req->phone;
        $saveData['email']                = $req->email;
        $saveData['password']             = md5($req->password);
        $saveData['notifications']        = 'Yes';
        $saveData['status']        = 'Pending';

        if(isset($req->profile_pic)){
          $profile_pic = $req->profile_pic;
          $prefix = time();
          $img_name = $prefix . '.jpeg';
          $image_path = public_path('uploads/users_customers/') . $img_name;

          file_put_contents($image_path, base64_decode($profile_pic));
          $saveData['profile_pic'] = 'uploads/users_customers/'. $img_name;
        }

        if(isset($req->proof_document)){
          $proof_document = $req->proof_document;
          $prefix = time();
          $img_name = $prefix.'.jpeg';
          $image_path = public_path('uploads/users_documents/').$img_name;

          file_put_contents($image_path, base64_decode($proof_document));
          $saveData['proof_document'] = 'uploads/users_documents/'.$img_name;
        }

        if(isset($req->valid_document)){
          $valid_document = $req->valid_document;
          $prefix = time();
          $img_name = $prefix.'.jpeg';
          $image_path = public_path('uploads/users_documents/').$img_name;

          file_put_contents($image_path, base64_decode($valid_document));
          $saveData['valid_document'] = 'uploads/users_documents/'.$img_name;
        }

        if(isset($req->account_type)){
	        $saveData['account_type']     = $req->account_type;
	      }

        $saveData['social_acc_type']      = 'None';
        $saveData['google_access_token']  = '';

        $saveData['verified_badge']       = 'No';
        $saveData['country_code']       	= $req->country_code;
        $saveData['date_expiry']       	  = $req->date_expiry;
        $saveData['date_added']           = date('Y-m-d H:i:s');

        $users_customers_id   = DB::table('users_customers')->insertGetId($saveData);
        $onlyEmail = $req->email;
        $data = DB::table('users_customers')->where('email', $req->email)->first();
        $otp = rand(1000,9999);
        $details = [
            "title"=>"Email Verification Code",
            "data"=>$data,
            "body"=> $otp
        ];
        $otpSended= Mail::to($onlyEmail)->send(new SendMail($details));
        $otpData=array(
         'verify_code'=>$otp
        );
        $UserotpUpdate=DB::table('users_customers')->where('users_customers_id', $users_customers_id)->update($otpData);
        
        $otpdetails = array('otp' => $otp, 'message' => 'Admin will Approve you account soon.');
        if($users_customers_id){
          $response["code"]     = 200;   
          $response["status"]   = "success";
          $response["data"]     = ["message"=>"OTP sent in the email.","otpdetails"=>$otpdetails];
        }else{
          $response["code"]     = 401;
          $response["status"]   = "error";
          $response["message"]  = 'Oops! Something went wrong.';
        }

      } else {
        $response["code"]     = 401;
        $response["status"]   = "error";
        $response["message"]  = "Email already exists.";
      }
    } else {
      $response["code"] = 404;
      $response["status"] = "error";
      $response["message"] = "All fields are needed.";
    }
    
    return response()
     ->json(array( 'status' => $response["status"], isset($response["message"]) ? 'message' : 'data' => isset($response["message"]) ? $response["message"] : $response["data"]))
     ->header('Content-Type', 'application/json');
  }
  /* SIGNUP USERS CUSTOMERS */

  /* UPDATE PROFILE */
  public function update_profile(Request $req){
    if(isset($req->users_customers_id) && isset($req->first_name) && isset($req->last_name) && isset($req->phone) && isset($req->notifications) && isset($req->country_code)) {
      $updateData['users_customers_id'] = $req->users_customers_id;
      $saveData['users_customers_type']           = $req->users_customers_type;

      if($req->users_customers_type == 'Company'){
        $saveData['company_name']           = $req->company_name;
      }

      $updateData['first_name']         = $req->first_name;
      $updateData['last_name']         = $req->last_name;
      $updateData['phone']              = $req->phone;
      $updateData['notifications']      = $req->notifications;
      $updateData['country_code']      = $req->country_code;

      if(isset($req->profile_pic)){
        $profile_pic = $req->profile_pic;
        $prefix = time();
        $img_name = $prefix . '.jpeg';
        $image_path = public_path('uploads/users_customers/') . $img_name;

        file_put_contents($image_path, base64_decode($profile_pic));
        $updateData['profile_pic'] = 'uploads/users_customers/'. $img_name;
      }

      if(isset($req->proof_document)){
        $proof_document = $req->proof_document;
        $prefix = time();
        $img_name = $prefix . '.jpeg';
        $image_path = public_path('uploads/users_documents/') . $img_name;

        file_put_contents($image_path, base64_decode($proof_document));
        $updateData['proof_document'] = 'uploads/users_documents/'. $img_name;
      }

      if(isset($req->valid_document)){
        $valid_document = $req->valid_document;
        $prefix = time();
        $img_name = $prefix . '.jpeg';
        $image_path = public_path('uploads/users_documents/') . $img_name;

        file_put_contents($image_path, base64_decode($valid_document));
        $updateData['valid_document'] = 'uploads/users_documents/'. $img_name;
      }

      DB::table('users_customers')->where('users_customers_id', $req->users_customers_id)->update($updateData);
      $updatedData = DB::table('users_customers')->where('users_customers_id', $req->users_customers_id)->get();
 
      $response["code"] = 200;
      $response["status"] = "success";
      $response["data"] = $updatedData;
    } else {
      $response["code"] = 404;
      $response["status"] = "error";
      $response["message"] = "All fields are needed.";
    }

    return response()
      ->json(array( 'status' => $response["status"], isset($response["message"]) ? 'message' : 'data' => isset($response["message"]) ? $response["message"] : $response["data"]))
      ->header('Content-Type', 'application/json');
  }
  /* UPDATE PROFILE */

  /* FORGETPASSWORD API */
  public function forgot_password(Request $req){
    if (isset($req)) {
      $email=DB::table('users_customers')->where('email', $req->email)->get()->count();
      if ($email>0) {
        $data = DB::table('users_customers')->where('email', $req->email)->first();
        $id = $data->users_customers_id;
        $onlyEmail = $req->email;
        $otp = rand(1000,9999);
        $details = [
            "title"=>"Email Verification Code",
            "data"=>$data,
            "body"=> $otp
        ];
        $otpSended= Mail::to($onlyEmail)->send(new SendMail($details));
        $otpData=array(
         'verify_code'=>$otp
        );
        $UserotpUpdate=DB::table('users_customers')->where('users_customers_id', $id)->update($otpData);

        $details = array('otp' => $otp, 'message' => 'OTP sent in the email.');
        $response["code"] = 200;
        $response["status"] = "success";
        $response["data"] = $details;
      }else{
        $response["code"] = 404;
        $response["status"] = "error";
        $response["message"] = "Email does not exists.";
      }
    }else{
      $response["code"] = 404;
      $response["status"] = "error";
      $response["message"] = "Please enter email address.";
    }
    
    return response()
      ->json(array( 'status' => $response["status"], isset($response["message"]) ? 'message' : 'data' => isset($response["message"]) ? $response["message"] : $response["data"]))
      ->header('Content-Type', 'application/json');
  }
  /* FORGETPASSWORD API */

  /* MODIFY PASSWORD */
  public function modify_my_password(Request $req){
    if (isset($req->email) && isset($req->otp) && isset($req->password) && isset($req->confirm_password)) {
      $forgetOtp = DB::table('users_customers')->select('verify_code')->where('email', $req->email)->get();
      $otpforgetdb = $forgetOtp[0]->verify_code;
      if ($otpforgetdb == $req->otp) {
        if ($req->confirm_password == $req->password) {
          $otpData=array(
           'verify_code'=>'',
           'password' => md5($req->password)
          );
          
          $UserotpUpdate =DB::table('users_customers')->where('email', $req->email)->update($otpData);
          $users_customers = DB::table('users_customers')->where('email', $req->email)->get();
          
          $response["code"] = 200;
          $response["status"] = "success";
          $response["data"] = $users_customers;
        } else {
          $response["code"] = 404;
          $response["status"] = "error";
          $response["message"] = "Password and confirm password do not match.";
        }
      } else {
        $response["code"] = 404;
        $response["status"] = "error";
        $response["message"] = "Otp do not match.";
      }
    }else{
      $response["code"] = 404;
      $response["status"] = "error";
      $response["message"] = "All fields are required.";
    }
    
    return response()
     ->json(array( 'status' => $response["status"], isset($response["message"]) ? 'message' : 'data' => isset($response["message"]) ? $response["message"] : $response["data"]))
     ->header('Content-Type', 'application/json');
  }
  /* MODIFY PASSWORD */

  /* CHANGE PASSWORD */
  public function change_my_password(Request $req){
    if (isset($req->email) && isset($req->old_password) && isset($req->password) && isset($req->confirm_password)) {
      $old_password = DB::table('users_customers')->select('password')->where('email', $req->email)->get();
      $old_passwordDB = $old_password[0]->password;
      if ($old_passwordDB == md5($req->old_password)) {
        if ($req->confirm_password == $req->password) {
          $otpData=array('password' => md5($req->password));          
          $UserotpUpdate =DB::table('users_customers')->where('email', $req->email)->update($otpData);
          $users_customers = DB::table('users_customers')->where('email', $req->email)->get();
          
          $response["code"] = 200;
          $response["status"] = "success";
          $response["data"] = $users_customers;
        } else {
          $response["code"] = 404;
          $response["status"] = "error";
          $response["message"] = "Password and confirm password do not match.";
        }
      } else {
        $response["code"] = 404;
        $response["status"] = "error";
        $response["message"] = "Old password is not correct.";
      }
    }else{
      $response["code"] = 404;
      $response["status"] = "error";
      $response["message"] = "All fields are required.";
    }
    
    return response()
     ->json(array( 'status' => $response["status"], isset($response["message"]) ? 'message' : 'data' => isset($response["message"]) ? $response["message"] : $response["data"]))
     ->header('Content-Type', 'application/json');
  }
  /* CHANGE PASSWORD */

  /* DELETE ACCOUNT API */
  public function delete_account(Request $req){
    if (isset($req->user_email) && isset($req->delete_reason) && isset($req->comments)) {
      $users_customers = DB::table('users_customers')->where('email', $req->user_email)->get()->count();
      if ($users_customers>0) {
        $users_customers_delete = DB::table('users_customers_delete')->where('email', $req->user_email)->get()->count();
        if ($users_customers_delete == 0) { 
          $data = array(
            'email'=>$req->user_email,
            'delete_reason'=> $req->delete_reason,
            'comments'=> $req->comments,
            'date_added'=>date('Y-m-d H:i:s'),
            'status'=>'Pending'
          );
          $users_customers_id   = DB::table('users_customers_delete')->insertGetId($data);

          $response["code"] = 200;
          $response["status"] = "success";
          $response["message"] = "Delete account request recieved successfully.";
        }else{
          $response["code"] = 404;
          $response["status"] = "error";
          $response["message"] = "Delete account request already sent. Please wait out team will get back to you in 24 hours.";
        }
      }else{
        $response["code"] = 404;
        $response["status"] = "error";
        $response["message"] = "Email does not exists.";
      }
    }else{
      $response["code"] = 404;
      $response["status"] = "error";
      $response["message"] = "All fields are required.";
    }
    
    return response()
      ->json(array( 'status' => $response["status"], isset($response["message"]) ? 'message' : 'data' => isset($response["message"]) ? $response["message"] : $response["data"]))
      ->header('Content-Type', 'application/json');
  }
  /* DELETE ACCOUNT API */

  /* GET SYSTEM SETTINGS */
  public function system_settings(){
    $fetch_data   =  DB::table('system_settings')->get();
    
    if (!empty($fetch_data)) {
      $response["code"] = 200;
      $response["status"] = "success";
      $response["data"] = $fetch_data;
    } else {
      $response["code"] = 404;
      $response["status"] = "error";
      $response["message"] = "no data found.";
    }
    return response()
      ->json(array( 'status' => $response["status"], isset($response["message"]) ? 'message' : 'data' => isset($response["message"]) ? $response["message"] : $response["data"]))
      ->header('Content-Type', 'application/json');
  }
  /* GET SYSTEM SETTINGS */

  /* MESSAGES PERMISSION */
  public function messages_permission(Request $req){
    if(isset($req->users_customers_id) && isset($req->messages)) {
      $updateData['messages']      = $req->messages;

      DB::table('users_customers')->where('users_customers_id', $req->users_customers_id)->update($updateData);
      $updatedData = DB::table('users_customers')->where('users_customers_id', $req->users_customers_id)->get();
 
      $response["code"] = 200;
      $response["status"] = "success";
      $response["data"] = $updatedData;
    } else {
      $response["code"] = 404;
      $response["status"] = "error";
      $response["message"] = "All fields are needed.";
    }

    return response()
      ->json(array( 'status' => $response["status"], isset($response["message"]) ? 'message' : 'data' => isset($response["message"]) ? $response["message"] : $response["data"]))
      ->header('Content-Type', 'application/json');
  }
  /* MESSAGES PERMISSION */

  /* NOTIFICATION PERMISSION */
  public function notification_permission(Request $req){
    if(isset($req->users_customers_id) && isset($req->notifications)) {
      $updateData['notifications']      = $req->notifications;

      DB::table('users_customers')->where('users_customers_id', $req->users_customers_id)->update($updateData);
      $updatedData = DB::table('users_customers')->where('users_customers_id', $req->users_customers_id)->get();
 
      $response["code"] = 200;
      $response["status"] = "success";
      $response["data"] = $updatedData;
    } else {
      $response["code"] = 404;
      $response["status"] = "error";
      $response["message"] = "All fields are needed.";
    }

    return response()
      ->json(array( 'status' => $response["status"], isset($response["message"]) ? 'message' : 'data' => isset($response["message"]) ? $response["message"] : $response["data"]))
      ->header('Content-Type', 'application/json');
  }
  /* NOTIFICATION PERMISSION */

  /* NOTIFICATIONS API */
  public function notifications(Request $req){
    if (isset($req->users_customers_id)) {
      $notifications  = DB::table('notifications')->where('receivers_id', $req->users_customers_id)->orderBy('notifications_id', 'desc')->get();
      $data=[];
      foreach($notifications as $notification){
        $notification->date_added = Carbon::parse($notification->date_added)->format('F d, Y');
        $notification->date_age=Helper::get_day_difference($notification->date_added);
        $notification->notification_sender= DB::table('users_customers')->where('users_customers_id', $notification->senders_id)->select("first_name","last_name","profile_pic")->first();
        $data[]=$notification;
      }

      $response["code"] = 200;
      $response["status"] = "success";
      $response["data"] = $data;
    } else {
      $response["code"] = 404;
      $response["status"] = "error";
      $response["message"] = "All fields are required.";
    }
    
    return response()
      ->json(array( 'status' => $response["status"], isset($response["message"]) ? 'message' : 'data' => isset($response["message"]) ? $response["message"] : $response["data"]))
      ->header('Content-Type', 'application/json');
  }
  /* NOTIFICATIONS API */

  /* UNREAD NOTIFICATIONS API */
  public function notifications_unread(Request $req){
    if (isset($req->users_customers_id)) {
      $notifications  = DB::table('notifications')->where('receivers_id', $req->users_customers_id)->where('notifications.status', 'Unread')->get();

      $data = array("status"=>'Read');
      $updateProfile=DB::table('notifications')->where('receivers_id', $req->users_customers_id)->where('status', 'Unread')->update($data);

      $response["code"] = 200;
      $response["status"] = "success";
      $response["data"] = $notifications;
    } else {
      $response["code"] = 404;
      $response["status"] = "error";
      $response["message"] = "All fields are required.";
    }
    
    return response()
      ->json(array( 'status' => $response["status"], isset($response["message"]) ? 'message' : 'data' => isset($response["message"]) ? $response["message"] : $response["data"]))
      ->header('Content-Type', 'application/json');
  }
  /* UNREAD NOTIFICATIONS API */

   /*** UNREADED  MESSAGES ***/
   public function unreaded_messages(Request $req){  
    if (isset($req->users_customers_id)){
      $unread_chat = DB::table('chat_messages')->where(['receiver_id'=>$req->users_customers_id,'status'=>'Unread'])->get()->count();
      $response["code"] = 200;
      $response["status"] = "success";
      $response["data"] = $unread_chat;
    } else {
      $response["code"] = 404;
      $response["status"] = "error";
      $response["message"] = "All fields are required.";
    }
    
    return response()
      ->json(array( 'status' => $response["status"], isset($response["message"]) ? 'message' : 'data' => isset($response["message"]) ? $response["message"] : $response["data"]))
      ->header('Content-Type', 'application/json');
  }
  /*** UNREADED  MESSAGES ***/

  /*** CHAT HEADS ADMIN ***/
  public function getAllChatLive(Request $req){  
      if (isset($req->users_customers_id)){
        $final_chat_array = array();
        $chat_list = DB::table('chat_list_live')->where('sender_id', $req->users_customers_id)->get();

        foreach($chat_list as $key => $chat){
          $chat_array = array();
          $chat_array['sender_id'] = $chat->sender_id;
          $chat_array['receiver_id'] = $chat->receiver_id;

          $receiver_data = DB::table('users_system')->where('users_system_id',$chat->receiver_id)->get();
          $chat_array['first_name'] = $receiver_data[0]->first_name;
          $chat_array['user_image'] = $receiver_data[0]->user_image;
            
          $chat_message = DB::table('chat_messages_live')
            ->where([['sender_id', $req->appUserId],['receiver_id', $chat->receiver_id]])
            ->orWhere([['sender_id', $chat->receiver_id], ['receiver_id', $req->appUserId]])
            ->get()->last();
          if (!empty($chat_message)) {
            $date_request = Helper::get_day_difference($chat_message->send_date);
            $chat_array['date'] = $date_request;
            $chat_array['last_message'] = $chat_message;
          } else {
            $date_request = Helper::get_day_difference($chat->date_request);
            $chat_array['date'] = $date_request;
            $chat_array['last_message'] = 'No Message sent or recieved.';
          }

          $final_chat_array[] = $chat_array;
        }

        if (!empty($final_chat_array)) {
          $response["code"] = 200;
          $response["status"] = "success";
          $response["data"] = $final_chat_array;
        } else{
          $response["code"] = 404;
          $response["status"] = "error";
          $response["message"] = "No chat found.";
        }
      } else {
        $response["code"] = 404;
        $response["status"] = "error";
        $response["message"] = "Enter All Fields.";
      }

      return response()
      ->json(array( 'status' => $response["status"], isset($response["message"]) ? 'message' : 'data' => isset($response["message"]) ? $response["message"] : $response["data"]))
      ->header('Content-Type', 'application/json');
  }
  /*** CHAT HEADS ***/

  /*** CHAT MESSAGES ***/
  public function user_chat_live(Request $req){
      if (isset($req->requestType)) {
        $request_type = $req->requestType;
        switch ($request_type) {
          case "startChat":
            if(isset($req->users_customers_id) && isset($req->other_users_customers_id)){
              $check_request = DB::table('chat_list_live')->where([ ['sender_id', $req->users_customers_id], ['receiver_id', $req->other_users_customers_id]])->orWhere([ ['sender_id', $req->other_users_customers_id], ['receiver_id', $req->users_customers_id]])->count();
              if($check_request > 0){
                $response["code"] = 200;
                $response["status"] = "success";
                $response["message"] = 'chat already started';    
              } else {
                $data_save = array(
                    'sender_id'=> $req->users_customers_id,
                    'receiver_id'=> $req->other_users_customers_id,
                    'date_request'=> date('Y-m-d'),
                    'created_at' => Carbon::now()
                );
                $requestSend = DB::table('chat_list_live')->insert($data_save);
                
                if($requestSend){
                    $response["code"] = 200;
                    $response["status"] = "success";
                    $response["message"] = 'Chat Started!';
                  } else {
                    $response["code"] = 404;
                    $response["status"] = "error";
                    $response["message"] = 'Error in starting chat';
                  }
              }
            } else {
              $response["code"] = 404;
              $response["status"] = "error";
              $response["message"] = 'All fields are required';      
            }
          break;   
          
          case "sendMessage":
            if(isset($req->users_customers_id) && isset($req->other_users_customers_id) && isset($req->content) && isset($req->messageType) && isset($req->sender_type)){
              $message_details = array(
                'sender_type'=> $req->sender_type,
                'sender_id'=> $req->users_customers_id,
                'receiver_id'=> $req->other_users_customers_id,
                'message'=>  json_encode($req->content) ,
                'message_type'=> $req->messageType,
                'send_date'=> date('Y-m-d'),
                'send_time'=> date('H:i:s'),
                'created_at'=> date('Y-m-d H:i:s'),
                'status'=> 'Unread'
              );

              $insertedId = DB::table('chat_messages_live')->insertGetId($message_details);
              if($insertedId){

                //NEW MESSAGE Notifications
                $dataInsert=array(
                  'bookings_id'=>0,
                  'senders_id'=>$req->users_customers_id,
                  'receivers_id'=>$req->other_users_customers_id,
                  'message'=> 'sent a message.',
                  'date_added'=>date('Y-m-d H:i:s'),
                  'date_modified'=>date('Y-m-d H:i:s'),
                  'status'=>'Unread'
                );
                $this->send_notification($dataInsert);
                //NEW MESSAGE Notifications

                $messageDetails =  DB::table('chat_messages_live')->where('chat_messages_live_id', $insertedId)->first();
                $messageDetails->message = json_decode($messageDetails->message);
                if($messageDetails->message_type == 'attachment'){
                  $messageDetails->message = config('base_urls.chat_attachments_base_url').$messageDetails->message;
                }

                $response["code"] = 200;
                $response["status"] = "success";
                $response["message"] = 'Message sent successfully.';  
              } else {
                $response["code"] = 404;
                $response["status"] = "error";
                $response["message"] = 'Oops! Something went wrong.';  
              }
            } else {
              $response["code"] = 404;
              $response["status"] = "error";
              $response["message"] = 'All fields are required';  
            }
          break;
                                         
          case "getMessages":
            if(isset($req->users_customers_id) && isset($req->other_users_customers_id)){
              $chat_array =array();
              $day_array =array();
              $result = DB::table('chat_messages_live')->where([
                ['sender_id',$req->other_users_customers_id],    
                ['receiver_id', $req->users_customers_id]
              ])->update(array('status' => 'Read'));  
              
              $all_chat = DB::table('chat_messages_live')->where([
                  ['sender_id',$req->users_customers_id],
                  ['receiver_id',$req->other_users_customers_id],
              ])->orWhere([
                  ['sender_id',$req->other_users_customers_id],
                  ['receiver_id',$req->users_customers_id],
              ])->orderBy('chat_messages_live_id','ASC')->get();

              if(sizeof($all_chat) > 0){
                foreach($all_chat as $key => $chat){

                  $get_data['sender_type'] = $chat->sender_type;

                  $chat->message = json_decode($chat->message);
                  $day = Helper::get_day_difference($chat->send_date);

                  if (in_array($day, $day_array, TRUE)){
                    $get_data['date']= '';
                  } else {
                    array_push($day_array, $day);
                    $get_data['date']= $day;
                  } 
                  
                  $get_data['time'] =  date('h:i A',strtotime($chat->send_time));
                  $get_data['msgType'] = $chat->message_type;

                  if($chat->message_type=='attachment'){
                    $attachment =  $chat->message;
                    $get_data['message'] = $attachment;
                  } else {
                    $get_data['message'] = $chat->message;
                  }

                  if($chat->sender_type == 'Admin'){
                    $receiver_data = DB::table('users_system')->where('users_system_id',$req->other_users_customers_id)->get();
                    $get_data['users_data'] = $receiver_data[0];
                  } else {
                    $sender_data = DB::table('users_customers')->where('users_customers_id',$req->users_customers_id)->get();
                    $get_data['users_data'] = $sender_data[0];
                  }
                  array_push($chat_array, $get_data);
                  
                  if(!empty($chat_array)){
                    $result =  DB::table('chat_messages_live')->where([
                      ['sender_id',$req->other_users_customers_id],
                      ['receiver_id',$req->users_customers_id]
                    ])->update(array('status'=>'Read'));
                  }
                }
                
                if($chat_array){
                  $response["code"] = 200;
                  $response["status"] = "success";
                  $response["data"] = $chat_array; 
                } else {
                  $response["code"] = 404;
                  $response["status"] = "error";
                  $response["message"] = 'Error in chat array'; 
                }
              } else {
                $response["code"] = 404;
                $response["status"] = "error";
                $response["message"] = 'no chat history'; 
              }                       
            } else {
              $response["code"] = 404;
              $response["status"] = "error";
              $response["message"] = 'All fields are needed'; 
            }
          break;

          case "updateMessages":
            if(isset($req->users_customers_id) && isset($req->other_users_customers_id)){
              $user_id = $req->users_customers_id;
              $other_user_id  = $req->other_users_customers_id;
              $chat_array =array();
              $all_chat =  DB::table('chat_messages_live')->where([
                    ['sender_id', $other_user_id],
                    ['receiver_id',$user_id],
                    ['status','Unread']
              ])->orderBy('chat_messages_live_id', 'ASC')->get();
              
              if(sizeof($all_chat) > 0){
                foreach($all_chat as $chat){
                  $get_data['chat_messages_live_id'] = $chat->chat_messages_live_id;
                  $get_data['sender_type'] = $chat->sender_type;

                  $chat->message = json_decode($chat->message);                
                  $get_data['time'] =  date('h:i A',strtotime($chat->send_date));
                  $get_data['msgType'] = $chat->message_type;
                  if($chat->message_type =='attachment'){
                    $image =  $chat->message;
                    $get_data['message'] = $image;
                  } else { 
                    $get_data['message'] = $chat->message;
                  } 

                  if($chat->sender_type == 'Admin'){
                    $receiver_data = DB::table('users_system')->where('users_system_id',$other_user_id)->get();
                    $get_data['users_data'] = $receiver_data[0];
                  } else {
                    $sender_data = DB::table('appUsers')->where('appUserId',$other_user_id)->get();
                    $get_data['users_data'] = $sender_data[0];
                  }   

                  if(!empty($chat_array)){
                    $result =  DB::table('chat_messages_live')->where([
                      ['sender_id',$other_user_id],
                      ['receiver_id',$user_id]
                      ])->update(array('status'=>'Read'));
                  }
                  array_push($chat_array, $get_data);
                             
                  $chat_length   =  DB::table('chat_messages_live')->where([
                    ['sender_id', $user_id],
                    ['receiver_id',$other_user_id]
                    ])->orderBy('chat_messages_live_id','ASC')->count();

                  if($chat_array){
                    $finalDataset = array(
                        "chat_length" => $chat_length,
                        "unread_messages" => $chat_array,
                    );

                    $response["code"] = 200;
                    $response["status"] = "success";
                    $response["data"] = $finalDataset; 
                  } else {
                    $response["code"] = 404;
                    $response["status"] = "error";
                    $response["message"] = "Un Updated Chat Not Found!"; 
                  }
                }
              } else {
                $response["code"] = 404;
                $response["status"] = "error";
                $response["message"] = "No New Message Found!"; 
              }
            } else {
              $response["code"] = 404;
              $response["status"] = "error";
              $response["message"] = "All fields are required!"; 
            }
          break;    
        }
      } else {
        $response["code"] = 404;
        $response["status"] = "error";
        $response["message"] = "Request type not found"; 
      }

      return response()
       ->json(array( 'status' => $response["status"], isset($response["message"]) ? 'message' : 'data' => isset($response["message"]) ? $response["message"] : $response["data"]))
       ->header('Content-Type', 'application/json');
    }
    /*** CHAT MESSAGES ***/

    /* GET ADMIN LIST */
    public function get_admin_list(Request $req){
      $admin_list = DB::table('users_system')->where('status', 'Active')->get();
      if ($admin_list) {
        $response["code"] = 200;
        $response["status"] = "success";
        $response["data"] = $admin_list;
      } else {
        $response["code"] = 404;
        $response["status"] = "error";
        $response["message"] = "No active admin found.";
      }
      
      return response()
        ->json(array( 'status' => $response["status"], isset($response["message"]) ? 'message' : 'data' => isset($response["message"]) ? $response["message"] : $response["data"]))
        ->header('Content-Type', 'application/json');
  }
  /* GET ADMIN LIST */

  /*** CHAT HEADS ***/
  public function getAllChat(Request $req){  
    if (isset($req->users_customers_id)){
      $final_chat_array = array();
      $chat_list = DB::table('chat_list')->where('sender_id', $req->users_customers_id)->orWhere('receiver_id', $req->users_customers_id)->get();
      foreach($chat_list as $key => $chat){
        $chat_array = array();
        $chat_array['sender_id'] = $chat->sender_id;
        $chat_array['receiver_id'] = $chat->receiver_id;

        $chat_message = DB::table('chat_messages') 
        ->whereIn('sender_id',[$chat->receiver_id,$chat->sender_id])
        ->whereIn('receiver_id',[$chat->receiver_id,$chat->sender_id])
        ->orderBy('chat_message_id', 'desc')
        ->first();
        if ($chat_message) {
          $date_request = Helper::get_day_difference($chat_message->send_date);
          $chat_array['date'] = $date_request;
          $chat_array['status'] = $chat_message->status;
          $chat_array['message_type'] = $chat_message->message_type;
          $chat_array['last_message'] = $chat_message->message;
        } else {
          $date_request = Helper::get_day_difference($chat->date_request);
          $chat_array['date'] = $date_request;
          $chat_array['last_message'] = 'No Message sent or recieved.';
        }
        if($chat->sender_id==$req->users_customers_id){
            $receiver_data = DB::table('users_customers')->where('users_customers_id',$chat->receiver_id)->first();
            $chat_array['user_data'] = $receiver_data;
        }
        if($chat->receiver_id==$req->users_customers_id){
          // $chat_message = DB::table('chat_messages')->whereIn('sender_id',  [$chat->receiver_id,$chat->sender_id])->orderBy('chat_message_id','DESC')->first();
          $sender_data = DB::table('users_customers')->where('users_customers_id',$chat->sender_id)->first();
          $chat_array['user_data'] = $sender_data;
        
          // if ($chat_message) {
          //   $date_request = Helper::get_day_difference($chat_message->send_date);
          //   $chat_array['date'] = $date_request;
          //   $chat_array['status'] = $chat_message->status;
          //   $chat_array['last_message'] = $chat_message->message;
          // } else {
          //   $date_request = Helper::get_day_difference($chat->date_request);
          //   $chat_array['date'] = $date_request;
          //   $chat_array['last_message'] = 'No Message sent or recieved.';
          // }
        }
        $final_chat_array[] = $chat_array;
      }

      if (count($final_chat_array)>0) {
        $response["code"] = 200;
        $response["status"] = "success";
        $response["data"] = $final_chat_array;
      } else{
        $response["code"] = 404;
        $response["status"] = "error";
        $response["message"] = "chat unavailable.";
      }
    } else {
      $response["code"] = 404;
      $response["status"] = "error";
      $response["message"] = "Enter All Fields.";
    }

    return response()
    ->json(array( 'status' => $response["status"], isset($response["message"]) ? 'message' : 'data' => isset($response["message"]) ? $response["message"] : $response["data"]))
    ->header('Content-Type', 'application/json');
  }
  /*** CHAT HEADS ***/

  /*** CHAT MESSAGES ***/
  public function user_chat(Request $req){
    if (isset($req->requestType)) {
      $request_type = $req->requestType;
      switch ($request_type) {
        case "startChat":
          if(isset($req->users_customers_id) && isset($req->other_users_customers_id)){
            $check_request = DB::table('chat_list')->where([ ['sender_id', $req->users_customers_id], ['receiver_id', $req->other_users_customers_id]])->orWhere([ ['sender_id', $req->other_users_customers_id], ['receiver_id', $req->users_customers_id]])->count();
            if($check_request > 0){
              $response["code"] = 200;
              $response["status"] = "success";
              $response["message"] = 'chat already started';    
            } else {
              $data_save = array(
                  'sender_id'=> $req->users_customers_id,
                  'receiver_id'=> $req->other_users_customers_id,
                  'date_request'=> date('Y-m-d'),
                  'created_at' => Carbon::now()
              );
              $requestSend = DB::table('chat_list')->insert($data_save);
              
              if($requestSend){
                  $response["code"] = 200;
                  $response["status"] = "success";
                  $response["message"] = 'chat started';
                } else {
                  $response["code"] = 404;
                  $response["status"] = "error";
                  $response["message"] = 'Error in starting chat';
                }
            }
          } else {
            $response["code"] = 404;
            $response["status"] = "error";
            $response["message"] = 'All fields are required';      
          }
        break;   
        
        case "sendMessage":
          if(isset($req->users_customers_id) && isset($req->other_users_customers_id) && isset($req->messageType)){
            $message_details = array(
              'sender_id'=> $req->users_customers_id,
              'receiver_id'=> $req->other_users_customers_id,
              'sender_type'=> $req->sender_type,
              'message_type'=> $req->messageType,
              'send_date'=> date('Y-m-d'),
              'send_time'=> date('H:i:s'),
              'created_at'=> date('Y-m-d H:i:s'),
              'status'=> 'Unread'
            );
            if(isset($req->content)){
              $message_details['message']=  json_encode($req->content);
            }
            if($req->messageType=='attachment'){
              if(isset($req->image)){
                $image = $req->image;
                $prefix = time();
                $img_name = $prefix . '.jpeg';
                $image_path = public_path('uploads/users_customers/') . $img_name;
        
                file_put_contents($image_path, base64_decode($image));
                $message_details['message'] = json_encode('uploads/users_customers/'. $img_name);
                $message_details['message_type'] = $req->messageType;
              }
            }
            $insertedId = DB::table('chat_messages')->insertGetId($message_details);
            if($insertedId){
              //NEW MESSAGE Notifications
              $dataInsert=array(
                'bookings_id'=>0,
                'senders_id'=>$req->users_customers_id,
                'receivers_id'=>$req->other_users_customers_id,
                'message'=> 'A new message has been recieved.',
                'date_added'=>date('Y-m-d H:i:s'),
                'date_modified'=>date('Y-m-d H:i:s')
              );
              $this->send_notification($dataInsert);
              //NEW MESSAGE Notifications

              $messageDetails =  DB::table('chat_messages')->where('chat_message_id', $insertedId)->first();
              $messageDetails->message = json_decode($messageDetails->message);
              if($messageDetails->message_type == 'attachment'){
                $messageDetails->message = $messageDetails->message;
              }

              $response["code"] = 200;
              $response["status"] = "success";
              $response["message"] = 'Message sent successfully.';  
            } else {
              $response["code"] = 404;
              $response["status"] = "error";
              $response["message"] = 'Oops! Something went wrong.';  
            }
          } else {
            $response["code"] = 404;
            $response["status"] = "error";
            $response["message"] = 'All fields are required';  
          }
        break;
                                       
        case "getMessages":
          if(isset($req->users_customers_id) && isset($req->other_users_customers_id)){
            $chat_array =array();
            $day_array =array();
            $result = DB::table('chat_messages')->where([['sender_id',$req->other_users_customers_id], ['receiver_id', $req->users_customers_id]])->update(array('status' => 'Read'));  
            
            $all_chat = DB::table('chat_messages')->where([['sender_id',$req->users_customers_id],['receiver_id',$req->other_users_customers_id]])->orWhere([['sender_id',$req->other_users_customers_id], ['receiver_id',$req->users_customers_id]])->orderBy('chat_message_id','ASC')->get();

            if(sizeof($all_chat) > 0){
              foreach($all_chat as $key => $chat){
                $get_data['sender_type'] = $chat->sender_type;

                $chat->message = json_decode($chat->message);
                $day = Helper::get_day_difference($chat->send_date);

                if (in_array($day, $day_array, TRUE)){
                  $get_data['date']= '';
                } else {
                  array_push($day_array, $day);
                  $get_data['date']= $day;
                } 
                
                $get_data['time'] =  date('h:i A',strtotime($chat->send_time));
                $get_data['msgType'] = $chat->message_type;

                if($chat->message_type=='attachment'){
                  $attachment =  $chat->message;
                  $get_data['message'] = $attachment;
                } else {
                  $get_data['message'] = $chat->message;
                }

                $sender_data = DB::table('users_customers')->where('users_customers_id',$req->users_customers_id)->get();
                $get_data['users_data'] = $sender_data[0];
              
                array_push($chat_array, $get_data);
                
                if(!empty($chat_array)){
                  $result =  DB::table('chat_messages')->where([
                    ['sender_id',$req->other_users_customers_id],
                    ['receiver_id',$req->users_customers_id]
                  ])->update(array('status'=>'Read'));
                }
              }

              if($chat_array){
                $response["code"] = 200;
                $response["status"] = "success";
                $response["data"] = $chat_array; 
              } else {
                $response["code"] = 404;
                $response["status"] = "error";
                $response["message"] = 'Error in chat array'; 
              }
            } else {
              $response["code"] = 404;
              $response["status"] = "error";
              $response["message"] = 'no chat history'; 
            }                       
          } else {
            $response["code"] = 404;
            $response["status"] = "error";
            $response["message"] = 'All fields are needed'; 
          }
        break;

        case "updateMessages":
          if(isset($req->users_customers_id) && isset($req->other_users_customers_id)){
            $user_id = $req->users_customers_id;
            $other_user_id  = $req->other_users_customers_id;
            $chat_array =array();
  
            $all_chat =  DB::table('chat_messages')
              ->where([['sender_id', $other_user_id], ['receiver_id',$user_id],['status','Unread']])
              ->orderBy('chat_message_id', 'ASC')->get();
            
            if(sizeof($all_chat) > 0){
              foreach($all_chat as $chat){
                $get_data['chat_message_id'] = $chat->chat_message_id;
                $get_data['sender_type'] = $chat->sender_type;

                $chat->message = json_decode($chat->message);                
                $get_data['time'] =  date('h:i A',strtotime($chat->send_date));
                $get_data['msgType'] = $chat->message_type;
                if($chat->message_type =='attachment'){
                  $image =  $chat->message;
                  $get_data['message'] = $image;
                } else { 
                  $get_data['message'] = $chat->message;
                } 

                $sender_data = DB::table('users_customers')->where('users_customers_id',$req->other_users_customers_id)->get();
                $get_data['users_data'] = $sender_data[0];
                array_push($chat_array, $get_data);
              }
               
              if(!empty($chat_array)){
                $result =  DB::table('chat_messages')->where([
                  ['sender_id',$other_user_id],
                  ['receiver_id',$user_id]
                  ])->update(array('status'=>'Read'));
              }
                         
              $chat_length   =  DB::table('chat_messages')->where([
                ['sender_id', $user_id],
                ['receiver_id',$other_user_id]
                ])->orWhere([
                    ['sender_id', $other_user_id],
                ['receiver_id',$user_id]
              ])->orderBy('chat_messages_id','ASC')->count();
            
              $finalDataset = array(
                  "chat_length" => $chat_length,
                  "unread_messages" => $chat_array,
              );

              $response["code"] = 200;
              $response["status"] = "success";
              $response["data"] = $finalDataset; 
            } else {
              $response["code"] = 404;
              $response["status"] = "error";
              $response["message"] = "no chat found"; 
            }
          } else {
            $response["code"] = 404;
            $response["status"] = "error";
            $response["message"] = "All fields are needed"; 
          }
        break;    
      }
    } else {
      $response["code"] = 404;
      $response["status"] = "error";
      $response["message"] = "Request type not Found"; 
    }

    return response()
     ->json(array( 'status' => $response["status"], isset($response["message"]) ? 'message' : 'data' => isset($response["message"]) ? $response["message"] : $response["data"]))
     ->header('Content-Type', 'application/json');
  }
  /*** CHAT MESSAGES ***/

  /* EMAIL EXIST API */
  public function email_exist(Request $req){
    if (isset($req->email)) {
      $email=DB::table('users_customers')->where('email', $req->email)->first();
      if ($email) {
        $response["code"] = 200;
        $response["status"] = "error";
        $response["message"]  ="Email already exists.";
      }else{
        $response["code"] = 404;
        $response["status"] = "success";
        $response["message"] = "Email does not exists.";
      }
    }else{ 
      $response["code"] = 404;
      $response["status"] = "error";
      $response["message"] = "Please enter email address.";
    }
    
    return response()
      ->json(array( 'status' => $response["status"], isset($response["message"]) ? 'message' : 'data' => isset($response["message"]) ? $response["message"] : $response["data"]))
      ->header('Content-Type', 'application/json');
  }
  /* EMAIL EXIST API */

  function calculatePriceAndEarnings($startTime, $endTime) {
    $system_settings     = DB::table('system_settings')->get();

    $baseRate = $system_settings[22]->description; // $21/hour
    $serviceFeePercentage = $system_settings[24]->description/100;
    $taxPercentage = $system_settings[20]->description/100; // 13%
    
    $start = Carbon::parse($startTime);
    $end = Carbon::parse($endTime);

    // Calculate the total time in minutes
    $totalTime = $end->diffInMinutes($start);

    // Apply the rules for charging
    if ($totalTime < 60) {
        $totalTime = 60; // Minimum booking time of 1 hour (60 minutes)
    }

    // Calculate the fare without service fee
    $fareWithoutServiceFee = ($totalTime / 60) * $baseRate;
    
    // Calculate the service fee
    $serviceFee = $fareWithoutServiceFee * $serviceFeePercentage;
    
    // Calculate the fare without tax
    $fareWithoutTax = $fareWithoutServiceFee + $serviceFee;
    
    // Calculate the fare with tax
    $fareWithTax = $fareWithoutTax * (1 + $taxPercentage);
    
    // Calculate StandMan's earnings
    $serviceFeeWithTax = $serviceFee * (1 + $taxPercentage);
    $earningsWithoutServiceFee = $fareWithoutServiceFee * (1 + $taxPercentage);
    $earningsAfterServiceFee = $earningsWithoutServiceFee - $serviceFeeWithTax;
    $taxOnEarnings = $earningsAfterServiceFee * $taxPercentage;
    $earningsWithTax = $earningsAfterServiceFee + $taxOnEarnings;
    
    // Format the amounts to two decimal places
    $fareWithoutServiceFee = number_format($fareWithoutServiceFee, 2);
    $serviceFee = number_format($serviceFee, 2);
    $fareWithTax = number_format($fareWithTax, 2);
    $serviceFeeWithTax = number_format($serviceFeeWithTax, 2);
    $earningsWithoutServiceFee = number_format($earningsWithoutServiceFee, 2);
    $earningsAfterServiceFee = number_format($earningsAfterServiceFee, 2);
    $taxOnEarnings = number_format($taxOnEarnings, 2);
    $earningsWithTax = number_format($earningsWithTax, 2);
    
    // Return the calculated values
    $data=[
      'fareWithoutServiceFee' => $fareWithoutServiceFee,
      'serviceFee' => $serviceFee,
      'fareWithoutTax' => $fareWithoutTax,
      'fareWithTax' => $fareWithTax,
      'serviceFeeWithTax' => $serviceFeeWithTax,
      'earningsWithoutServiceFee' => $earningsWithoutServiceFee,
      'earningsAfterServiceFee' => $earningsAfterServiceFee,
      'taxOnEarnings' => $taxOnEarnings,
      'earningsWithTax' => $earningsWithTax,
    ];
    return $data;
  }


  /* JOB PREICE */
  public function jobs_price(Request $req){
    if (isset($req->start_time) && isset($req->end_time)) {
      
      $startTime = $req->start_time;
      $endTime = $req->end_time;
      $job_price=$this->calculatePriceAndEarnings($startTime, $endTime);
      $data['price']                  = $job_price["fareWithoutServiceFee"];
      $data['service_charges']        = $job_price["serviceFee"];
      $data['tax']                     = number_format($job_price["fareWithTax"]-$job_price["fareWithoutTax"],2);
      $data['total_price']            = number_format($job_price["fareWithoutServiceFee"]+$job_price["serviceFee"]+$data['tax'],2);

      $response["code"]     = 200;   
      $response["status"]   = "success";
      $response["data"]     = $data;
    } else {
      $response["code"] = 404;
      $response["status"] = "error";
      $response["message"] = "All fields are needed.";
    }
    
    return response()
     ->json(array( 'status' => $response["status"], isset($response["message"]) ? 'message' : 'data' => isset($response["message"]) ? $response["message"] : $response["data"]))
     ->header('Content-Type', 'application/json');
  }
  /* JOB PREICE */

  /* JOB CREATE */
  public function jobs_create(Request $req){
    if (isset($req->users_customers_id) && isset($req->location) && isset($req->longitude) && isset($req->lattitude) && isset($req->start_date) && isset($req->start_time) && isset($req->end_time) && isset($req->payment_gateways_name) && isset($req->payment_status) && isset($req->price) && isset($req->service_charges) && isset($req->tax)) {
      
      $saveData['users_customers_id']     = $req->users_customers_id;
      $saveData['name']                   = $req->name;
      $saveData['location']               = $req->location;
      $saveData['longitude']               = $req->longitude;
      $saveData['lattitude']               = $req->lattitude;
      $saveData['start_date']             = $req->start_date;
      $saveData['start_time']             = $req->start_time;
      $saveData['end_time']               = $req->end_time;
      $saveData['payment_gateways_name']  = $req->payment_gateways_name;
      $saveData['payment_status']         = $req->payment_status;
      $saveData['price']                  = $req->price;
      $saveData['service_charges']        = $req->service_charges;
      $saveData['tax']                     = $req->tax;
      $saveData['total_price']            = $req->price+$req->service_charges+$req->tax;
      
      if(isset($req->description)){
        $saveData['description']            = $req->description;
      }
      if(isset($req->name)){
        $saveData['name']            = $req->name;
      }else{
        $saveData['name']            = 'Wait in line';
      }
        
      if(isset($req->image)){
        $profile_pic = $req->image;
        $prefix = time();
        $img_name = $prefix . '.jpeg';
        $image_path = public_path('uploads/jobs_images/') . $img_name;

        file_put_contents($image_path, base64_decode($profile_pic));
        $saveData['image']    = 'uploads/jobs_images/'. $img_name;
      }else{
        $saveData['image']            = 'uploads/jobs_images/job.jpg';
      }

      $saveData['date_added']       = date('Y-m-d H:i:s');
      $saveData['date_modified']    = date('Y-m-d H:i:s');
      $saveData['status']           = 'Pending';

      $jobs_id   = DB::table('jobs')->insertGetId($saveData);
      $jobs      = DB::table('jobs')->where('jobs_id', $jobs_id)->first();
      $jobs->total_price = intval($jobs->total_price);
      $all_employees=DB::table('users_customers')->where(['users_customers_type'=>'Employee','status'=>'Active'])->get();
      foreach ($all_employees as $key => $employee) {
        //NEW MESSAGE Notifications
        $dataInsert=array(
          'bookings_id'=>0,
          'senders_id'=>$req->users_customers_id,
          'receivers_id'=>$employee->users_customers_id,
          'message'=> 'A job is created.',
          'date_added'=>date('Y-m-d H:i:s'),
          'date_modified'=>date('Y-m-d H:i:s'),
          'status'=>'Unread'
        );
        $this->send_notification($dataInsert);
        //NEW MESSAGE Notifications
      }

      $jobs->users_customers_data = DB::table('users_customers')->where('users_customers_id', $req->users_customers_id)->first();
      $jobs->users_employee_data = DB::table('jobs_requests')->where('jobs_id', $jobs_id)->where('users_customers_id', $req->users_customers_id)->get();

      $response["code"]     = 200;   
      $response["status"]   = "success";
      $response["data"]     = $jobs;
    } else {
      $response["code"] = 404;
      $response["status"] = "error";
      $response["message"] = "All fields are needed.";
    }
    
    return response()
     ->json(array( 'status' => $response["status"], isset($response["message"]) ? 'message' : 'data' => isset($response["message"]) ? $response["message"] : $response["data"]))
     ->header('Content-Type', 'application/json');
  }
  /* JOB CREATE */

  /* GET JOBS CUSTOMERS */
  public function get_pending_jobs(Request $req){
    if (isset($req->users_customers_id)){
      $all_jobs = DB::table('jobs')
                  ->where('users_customers_id', $req->users_customers_id)
                  ->where('start_date', '>=', date('Y-m-d'))
                  ->where('start_time','>=',date('H:i:s'))
                  ->where('status', 'Pending')
                  ->Orwhere('status', 'Accepted')
                  ->get();
      $jobs = [];
      foreach($all_jobs as $jobslist){
        //if($jobslist->distance <= $job_radius->description){
          $jobslist->date_added = Carbon::parse($jobslist->date_added)->format('F d, Y');
          $jobslist->users_customers_data = DB::table('users_customers')->where('users_customers_id', $req->users_customers_id)->first();
          $jobslist->users_employee_data = DB::table('jobs_requests')->where('jobs_id', $jobslist->jobs_id)->where('users_customers_id', $req->users_customers_id)->get();
          $jobs[] = $jobslist;
        //}
      }

      if ($jobs) {
        $response["code"] = 200;
        $response["status"] = "success";
        $response["data"] = $jobs;
      } else {
        $response["code"] = 404;
        $response["status"] = "error";
        $response["message"] = "No jobs found.";
      }
    } else {
      $response["code"] = 404;
      $response["status"] = "error";
      $response["message"] = "All fields are needed.";
    }

    return response()
      ->json(array( 'status' => $response["status"], isset($response["message"]) ? 'message' : 'data' => isset($response["message"]) ? $response["message"] : $response["data"]))
      ->header('Content-Type', 'application/json');
  }
  /* GET JOBS CUSTOMERS */
  /* GET JOBS CUSTOMERS */
  public function get_ongoing_jobs(Request $req){
    if (isset($req->users_customers_id)){
      $all_jobs      = DB::table('jobs')->where('users_customers_id', $req->users_customers_id)
      ->where('start_date', date('Y-m-d'))
      ->where('start_time','<=',date('H:i:s'))->where('status', 'Ongoing')->get();
      $jobs = [];
      foreach($all_jobs as $jobslist){
        //if($jobslist->distance <= $job_radius->description){
          $jobslist->date_added = Carbon::parse($jobslist->date_added)->format('F d, Y');
          $jobslist->users_customers_data = DB::table('users_customers')->where('users_customers_id', $req->users_customers_id)->first();
          $jobs_requests_data = DB::table('jobs_requests')->where(['jobs_id'=>$jobslist->jobs_id,'status'=>'Accepted'])->first();

          $jobslist->users_employee_data = DB::table('users_customers')->where('users_customers_id', $jobs_requests_data->users_customers_id)->first();
          $jobs[] = $jobslist;
        //}
      }

      if ($jobs) {
        $response["code"] = 200;
        $response["status"] = "success";
        $response["data"] = $jobs;
      } else {
        $response["code"] = 404;
        $response["status"] = "error";
        $response["message"] = "No jobs found.";
      }
    } else {
      $response["code"] = 404;
      $response["status"] = "error";
      $response["message"] = "All fields are needed.";
    }

    return response()
      ->json(array( 'status' => $response["status"], isset($response["message"]) ? 'message' : 'data' => isset($response["message"]) ? $response["message"] : $response["data"]))
      ->header('Content-Type', 'application/json');
  }
  /* GET JOBS CUSTOMERS */

  /* GET PREVIOUS JOBS CUSTOMERS */
  public function get_previous_jobs(Request $req){
    if (isset($req->users_customers_id)){
      $all_jobs      = DB::table('jobs')->where('users_customers_id', $req->users_customers_id)->where('start_date', '<=', date('Y-m-d'))->Where('status', 'Completed')->get();

      $jobs = [];
      foreach($all_jobs as $jobslist){
        //if($jobslist->distance <= $job_radius->description){
          $jobslist->date_added = Carbon::parse($jobslist->date_added)->format('F d, Y');
          $jobslist->users_customers_data = DB::table('users_customers')->where('users_customers_id', $req->users_customers_id)->first();
          $jobs_requests_data = DB::table('jobs_requests')->where(['jobs_id'=>$jobslist->jobs_id])->first();
          $jobslist->users_employee_data = DB::table('users_customers')->where('users_customers_id', $jobs_requests_data->users_customers_id)->first();
          $jobs_ratings= DB::table('jobs_ratings')->where('jobs_id',$jobslist->jobs_id)->first();
          if($jobs_ratings){
            $jobslist->jobs_ratings =$jobs_ratings;
          }
          $jobs[] = $jobslist;
        //}
      }

      if ($jobs) {
        $response["code"] = 200;
        $response["status"] = "success";
        $response["data"] = $jobs;
      } else {
        $response["code"] = 404;
        $response["status"] = "error";
        $response["message"] = "No jobs found.";
      }
    } else {
      $response["code"] = 404;
      $response["status"] = "error";
      $response["message"] = "All fields are needed.";
    }

    return response()
      ->json(array( 'status' => $response["status"], isset($response["message"]) ? 'message' : 'data' => isset($response["message"]) ? $response["message"] : $response["data"]))
      ->header('Content-Type', 'application/json');
  }
  /* GET PREVIOUS JOBS CUSTOMERS */

  /* GET JOBS EMPLOYEES */
  public function get_jobs_employees(Request $request){
    if (isset($request->users_customers_id) && isset($request->employee_longitude) && isset($request->employee_lattitude)){

      $job_radius     = DB::table('system_settings')->where('type', 'job_radius')->first();
      $my_jobs_ids        = DB::table('jobs_requests')->select('jobs_id')->where('users_customers_id',$request->users_customers_id)
                            ->where('status','Cancelled')->orWhere('status', 'Rejected')->get();
      $my_jobs_array      = json_decode(json_encode($my_jobs_ids), true);
      $currentTime = Carbon::now();
      //DB::enableQueryLog();
       $all_jobs = DB::table('jobs')
                  ->whereNotIn('jobs_id', $my_jobs_array)
                  ->where(function ($query) {
                    $query->where('start_date', '>', date('Y-m-d'))
                        ->orWhere(function ($q) {
                            $q->where('start_date', date('Y-m-d'))
                                ->where('start_time', '>=', date('H:i:s'));
                        })
                        ->where('status', 'Pending');
                  })
                  ->orWhere(function ($query) use ($currentTime) {
                      $query->where(function ($query) use ($currentTime) { 
                          $query->where('start_date', '>', date('Y-m-d'))
                              ->orWhere(function ($query) use ($currentTime) {
                                  $query->where('start_date', date('Y-m-d'))
                                  ->whereRaw('TIMESTAMPDIFF(MINUTE, CONCAT(start_date, " ", start_time), ?) <= 20', [$currentTime->format('Y-m-d H:i:s')]);
                              })
                          ->where('status', 'Accepted');
                      });
                  })
                  ->get();
              //$query= DB::getQueryLog();
              //return $query;
              // return $all_jobs;
      // $all_jobs             = DB::table('jobs')->whereNotIn('jobs_id', $my_jobs_array)
      //                       ->where('start_date','>=',date('Y-m-d'))
      //                       ->where('start_time','>=',date('H:i:s'))
      //                       ->where('status', 'Pending')
      //                     ->get();
      $jobs = [];
      foreach($all_jobs as $jobslist){
        $job_longitude      = $jobslist->longitude;
        $job_lattitude      = $jobslist->lattitude;

        $employee_longitude = $request->employee_longitude;
        $employee_lattitude = $request->employee_lattitude;

        $jobslist->distance = $this->calculate_distance($request->employee_longitude, $request->employee_lattitude, $jobslist->longitude, $jobslist->lattitude);
        $jobslist->date_added = Carbon::parse($jobslist->date_added)->format('F d, Y');
        if($jobslist->distance <= $job_radius->description){
          $jobslist->users_customers_data = DB::table('users_customers')->where('users_customers_id', $jobslist->users_customers_id)->first();
          // $jobslist->users_employee_data = DB::table('jobs_requests')->where('jobs_id', $jobslist->jobs_id)->where('users_customers_id', $request->users_customers_id)->get();
          $jobslist->users_employee_data = DB::table('jobs_requests')->where('jobs_id', $jobslist->jobs_id)->get();
          $jobs[] = $jobslist;
        }
      }

      if (!empty($jobs)) {
        $response["code"] = 200;
        $response["status"] = "success";
        $response["data"] = $jobs;
      } else {
        $response["code"] = 404;
        $response["status"] = "error";
        $response["message"] = "No jobs found.";
      }
    } else {
      $response["code"] = 404;
      $response["status"] = "error";
      $response["message"] = "All fields are needed.";
    }

    return response()
      ->json(array( 'status' => $response["status"], isset($response["message"]) ? 'message' : 'data' => isset($response["message"]) ? $response["message"] : $response["data"]))
      ->header('Content-Type', 'application/json');
  }
  /* GET JOBS EMPLOYEES */

  /* GET ONGOING JOBS EMPLOYEES */
  public function get_ongoing_jobs_employees(Request $request){
    if (isset($request->users_customers_id) && isset($request->employee_longitude) && isset($request->employee_lattitude)){

      $my_jobs            = number_format(DB::table('jobs_requests')->select('jobs_id')->where('users_customers_id', $request->users_customers_id)->count());
      $my_jobs_ids        = DB::table('jobs_requests')->select('jobs_id')->where(['users_customers_id'=>$request->users_customers_id,'status'=>'Accepted'])->get();
      $my_jobs_array      = json_decode(json_encode($my_jobs_ids), true);
      $all_jobs               = DB::table('jobs')->whereIn('jobs_id', $my_jobs_array)
                                  ->where('start_date', date('Y-m-d'))                            
                                  ->where('start_time','<=',date('H:i:s'))
                                  ->where('status','Ongoing')->get();

      $jobs = [];
      foreach($all_jobs as $jobslist){
        $job_longitude      = $jobslist->longitude;
        $job_lattitude      = $jobslist->lattitude;

        $employee_longitude = $request->employee_longitude;
        $employee_lattitude = $request->employee_lattitude;

        $jobslist->distance = $this->calculate_distance($request->employee_longitude, $request->employee_lattitude, $jobslist->longitude, $jobslist->lattitude);
        $jobslist->date_added = Carbon::parse($jobslist->date_added)->format('F d, Y');
        //if($jobslist->distance <= $job_radius->description){
          $jobslist->users_customers_data = DB::table('users_customers')->where('users_customers_id', $jobslist->users_customers_id)->first();
          $jobslist->employee_data = DB::table('users_customers')->where('users_customers_id', $request->users_customers_id)->first();
          $jobs[] = $jobslist;
        //}
      }

      if ($jobs) {
        $response["code"] = 200;
        $response["status"] = "success";
        $response["data"] = $jobs;
      } else {
        $response["code"] = 404;
        $response["status"] = "error";
        $response["message"] = "No jobs found.";
      }
    } else {
      $response["code"] = 404;
      $response["status"] = "error";
      $response["message"] = "All fields are needed.";
    }

    return response()
      ->json(array( 'status' => $response["status"], isset($response["message"]) ? 'message' : 'data' => isset($response["message"]) ? $response["message"] : $response["data"]))
      ->header('Content-Type', 'application/json');
  }
  /* GET ONGOING JOBS EMPLOYEES */

  /* GET PREVIOUS JOBS EMPLOYEES */
  public function get_previous_jobs_employees(Request $request){
    if (isset($request->users_customers_id) && isset($request->employee_longitude) && isset($request->employee_lattitude)){

      $my_jobs            = number_format(DB::table('jobs_requests')->select('jobs_id')->where('users_customers_id', $request->users_customers_id)->count());
      $my_jobs_ids        = DB::table('jobs_requests')->select('jobs_id')->where('users_customers_id', $request->users_customers_id)->get();
      $my_jobs_array      = json_decode(json_encode($my_jobs_ids), true);
      $all_jobs               = DB::table('jobs')->whereIn('jobs_id', $my_jobs_array)->where('start_date', '<=', date('Y-m-d'))
                                ->where('status', 'Completed')
                                ->orWhere('status', 'Cancelled')
                                ->get();

      $jobs = [];
      foreach($all_jobs as $key=>$jobslist){
        $job_longitude      = $jobslist->longitude;
        $job_lattitude      = $jobslist->lattitude;

        $employee_longitude = $request->employee_longitude;
        $employee_lattitude = $request->employee_lattitude;

        $jobslist->distance = $this->calculate_distance($request->employee_longitude, $request->employee_lattitude, $jobslist->longitude, $jobslist->lattitude);
        $jobslist->date_added = Carbon::parse($jobslist->date_added)->format('F d, Y');
        //if($jobslist->distance <= $job_radius->description){
          $jobslist->users_customers_data = DB::table('users_customers')->where('users_customers_id', $jobslist->users_customers_id)->first();
          $jobslist->employee_data = DB::table('jobs_requests')->where('jobs_id', $my_jobs_ids[$key]->jobs_id)->where('users_customers_id', $request->users_customers_id)->get();
          $jobs_ratings= DB::table('jobs_ratings')->where('jobs_id',$jobslist->jobs_id)->first();
          if($jobs_ratings){
            $jobslist->jobs_ratings =$jobs_ratings;
          }
          $jobs[] = $jobslist;
        //}
      }

      if ($jobs) {
        $response["code"] = 200;
        $response["status"] = "success";
        $response["data"] = $jobs;
      } else {
        $response["code"] = 404;
        $response["status"] = "error";
        $response["message"] = "No jobs found.";
      }
    } else {
      $response["code"] = 404;
      $response["status"] = "error";
      $response["message"] = "All fields are needed.";
    }

    return response()
      ->json(array( 'status' => $response["status"], isset($response["message"]) ? 'message' : 'data' => isset($response["message"]) ? $response["message"] : $response["data"]))
      ->header('Content-Type', 'application/json');
  }
  /* GET PREVIOUS JOBS EMPLOYEES */

  /* ACTION JOBS EMPLOYEES */
  public function jobs_action_employees(Request $request){
    if (isset($request->users_customers_id) && isset($request->jobs_id) && isset($request->status)){
      /* UPDATE JOB STATUS */
      if($request->status=='Accepted'){
        $update_job_status                = DB::table('jobs')->where('jobs_id', $request->jobs_id)->update(['status'=>"Accepted",'date_modified'=>date('Y-m-d H:i:s')]);
      }else{
        $update_job_status                = DB::table('jobs')->where('jobs_id', $request->jobs_id)->update(['status'=>'Pending']);
      }
      /* UPDATE JOB STATUS */

        //NEW JOB Status Notifications
        $job  = DB::table('jobs')->where('jobs_id', $request->jobs_id)->first();
        $job_creater = DB::table('users_customers')->where('users_customers_id', $job->users_customers_id)->first();
        $dataInsert=array(
          'bookings_id'=>0,
          'senders_id'=>$request->users_customers_id,
          'receivers_id'=>$job_creater->users_customers_id,
          'message'=> 'Job is '.$request->status.'.',
          'date_added'=>date('Y-m-d H:i:s'),
          'date_modified'=>date('Y-m-d H:i:s'),
          'status'=>'Unread'
        );
        $this->send_notification($dataInsert);
        //NEW JOB Status Notifications

      /* CHECK JOB ALREADY ASSIGNED */
      $job_status                     = DB::table('jobs_requests')->where('jobs_id', $request->jobs_id)->where('status', 'Accepted')->count();
      
      $job_status_view                = DB::table('jobs_requests')->where('jobs_id', $request->jobs_id)->where('status', 'Accepted')->first();
      if($job_status_view &&  $request->status=='Accepted' && $job_status_view->users_customers_id == $request->users_customers_id){
        $response["code"] = 200;
        $response["status"] = "success";
        $response["message"] = "This job is already assigned to you.";
      } else if($job_status_view &&  $request->status=='Cancelled' ){
        $job_request=DB::table('jobs_requests')->where(['users_customers_id'=>$request->users_customers_id,'jobs_id'=>$request->jobs_id,])->update(['status'=>$request->status]);
        $response["code"] = 200;
        $response["status"] = "success";
        $response["message"] = "Job " .$request->status. " successfully.";
      } else{
        if($job_status == 0){
          /* CHECK JOB APPLIED ALREADY */
          $job_applied_status                = DB::table('jobs_requests')->where('jobs_id', $request->jobs_id)->where('users_customers_id', $request->users_customers_id)->count();
          if($job_applied_status == 0){
            /* ASSIGN JOB TO EMPLOYEE */
            $saveData['users_customers_id']   = $request->users_customers_id;
            $saveData['jobs_id']              = $request->jobs_id;
            $saveData['date_added']           = date('Y-m-d H:i:s');
            $saveData['status']               = $request->status;
            $jobs_requests_id                 = DB::table('jobs_requests')->insertGetId($saveData);
            /* ASSIGN JOB TO EMPLOYEE */

            $response["code"] = 200;
            $response["status"] = "success";
            $response["message"] = "Job " .$request->status. " successfully.";
          } else {
            $response["code"] = 200;
            $response["status"] = "success";
            $response["message"] = "You have already taken action on this Job.";
          }
          /* CHECK JOB APPLIED ALREADY */
        } else {
          $response["code"] = 200;
          $response["status"] = "success";
          $response["message"] = "This job is already assigned to someone else. Thank you for your interest.";
        }
      }
    } else {
      $response["code"] = 404;
      $response["status"] = "error";
      $response["message"] = "All fields are needed.";
    }

    return response()
      ->json(array( 'status' => $response["status"], isset($response["message"]) ? 'message' : 'data' => isset($response["message"]) ? $response["message"] : $response["data"]))
      ->header('Content-Type', 'application/json');
  }
  /* ACTION JOBS EMPLOYEES */


  /* COMPLETE JOBS CUSTOMER */
  public function jobs_customers_complete(Request $request){
    if (isset($request->users_customers_id) && isset($request->employee_users_customers_id) && isset($request->jobs_id)){
      $job_applied_status                = DB::table('jobs_requests')->where('jobs_id',$request->jobs_id)->where('status', 'Accepted')->where('users_customers_id', $request->employee_users_customers_id)->first();
      if($job_applied_status){
        /* UPDATE JOB STATUS */
        $update_job_status              = DB::table('jobs')->where('jobs_id', $request->jobs_id)->update(['status'=>'Completed']);
        /* UPDATE JOB STATUS */
        
        /* UPDATE EMPLOYEE WALLET */
        $job              = DB::table('jobs')->where('jobs_id', $request->jobs_id)->first();
        $employee              = DB::table('users_customers')->where('users_customers_id', $request->employee_users_customers_id)->first();
        $totalamount     = $job->price+$job->extra_time_price+$employee->wallet_amount;
        
        $update_employee_wallet = DB::table('users_customers')->where('users_customers_id', $request->employee_users_customers_id)->update(['wallet_amount'=>$totalamount]);
        /* UPDATE EMPLOYEE WALLET  */
        
        /* UPDATE JOB STATUS */
        $update_job_request_status      = DB::table('jobs_requests')->where('jobs_id', $request->jobs_id)->where('users_customers_id', $request->employee_users_customers_id)->update(['status'=>'Completed']);
        /* UPDATE JOB STATUS */

        /* WALLET TXN */
        $txnData=[
          'users_customers_id'  =>  $request->users_customers_id,
          'employee_users_customers_id'  =>  $request->employee_users_customers_id,
          'jobs_id'             =>  $request->jobs_id,
          'txn_type'            =>  'In',
          'total_amount'        =>  $job->total_price,
          'tax'                 =>  $job->tax,
          'service_charges'     =>  $job->service_charges,
          'standman_amount'     =>  $job->price,
          'date_time'           =>  date('Y-m-d H:i:s'),
          'date_added'          =>  date('Y-m-d H:i:s'),
          'narration'           =>  'Job Completed'
        ];
        
        $wallet_txn = DB::table('wallet_txns')->insertGetId($txnData);
        /* WALLET TXN  */
        $job->total_price=intval($job->total_price);
        $job->date_added=Carbon::parse($job->date_added)->format('F d, Y');
        $data=[
          'job'=>$job,
          'customer'=>DB::table('users_customers')->where('users_customers_id', $request->users_customers_id)->first(),
          'employee'=>$employee
        ];

        if($wallet_txn){
          $response["code"] = 200;
          $response["status"] = "success";
          $response["data"] = $data;
        }else {
          $response["code"] = 200;
          $response["status"] = "error";
          $response["message"] = "Oops! Something went wrong.";
        }
      } else {
        $response["code"] = 200;
        $response["status"] = "success";
        $response["message"] = "Job Not assigned to you or you have not accepted the job. Invalid Information.";
      }
    } else {
      $response["code"] = 200;
      $response["status"] = "success";
      $response["message"] = "All fields are required.";
    }

    return response()
      ->json(array( 'status' => $response["status"], isset($response["message"]) ? 'message' : 'data' => isset($response["message"]) ? $response["message"] : $response["data"]))
      ->header('Content-Type', 'application/json');
  }
  /* COMPLETE JOBS CUSTOMER */

  /* SEARCH JOBS CUSTOMERS */
  public function search_jobs_customers(Request $req){
    if (isset($req->users_customers_id) && isset($req->job_name)){
      $startDate = Carbon::now()->subDays(7);
      $endDate = Carbon::now();
      $all_jobs      = DB::table('jobs')->where('users_customers_id', $req->users_customers_id)->where('name', 'like', '%' . $req->job_name . '%')->whereBetween('date_added', [$startDate, $endDate])->get();

      $jobs = [];
      foreach($all_jobs as $jobslist){
        //if($jobslist->distance <= $job_radius->description){
          $jobslist->date_added = Carbon::parse($jobslist->date_added)->format('F d, Y');
          $jobslist->users_customers_data = DB::table('users_customers')->where('users_customers_id', $req->users_customers_id)->first();;
          $jobslist->users_employee_data = DB::table('jobs_requests')->where('jobs_id', $jobslist->jobs_id)->where('users_customers_id', $req->users_customers_id)->get();
          $jobs[] = $jobslist;
        //}
      }

      if ($jobs) {
        $response["code"] = 200;
        $response["status"] = "success";
        $response["data"] = $jobs;
      } else {
        $response["code"] = 404;
        $response["status"] = "error";
        $response["message"] = "No jobs found.";
      }
    } else {
      $response["code"] = 404;
      $response["status"] = "error";
      $response["message"] = "All fields are needed.";
    }

    return response()
      ->json(array( 'status' => $response["status"], isset($response["message"]) ? 'message' : 'data' => isset($response["message"]) ? $response["message"] : $response["data"]))
      ->header('Content-Type', 'application/json');
  }
  /* SEARCH JOBS CUSTOMERS */

  /* SEARCH JOBS EMPLOYEES */
  public function search_jobs_employees(Request $request){
    if (isset($request->users_customers_id) && isset($request->job_name) && isset($request->employee_longitude) && isset($request->employee_lattitude)){

      $my_jobs            = number_format(DB::table('jobs_requests')->select('jobs_id')->where('users_customers_id', $request->users_customers_id)->count());
      $my_jobs_ids        = DB::table('jobs_requests')->select('jobs_id')->where(['users_customers_id'=>$request->users_customers_id,'status'=>'Accepted'])->get();
      $my_jobs_array      = json_decode(json_encode($my_jobs_ids), true);
      $startDate = Carbon::now()->subDays(7);
      $endDate = Carbon::now();
      $all_jobs               = DB::table('jobs')->whereIn('jobs_id', $my_jobs_array)->where('name', 'like', '%' . $request->job_name . '%')->whereBetween('date_added', [$startDate, $endDate])->get();

      $jobs = [];
      foreach($all_jobs as $jobslist){
        $job_longitude      = $jobslist->longitude;
        $job_lattitude      = $jobslist->lattitude;

        $employee_longitude = $request->employee_longitude;
        $employee_lattitude = $request->employee_lattitude;

        $jobslist->distance = $this->calculate_distance($request->employee_longitude, $request->employee_lattitude, $jobslist->longitude, $jobslist->lattitude);

        //if($jobslist->distance <= $job_radius->description){
          $jobslist->date_added = Carbon::parse($jobslist->date_added)->format('F d, Y');
          $jobslist->users_customers_data = DB::table('users_customers')->where('users_customers_id', $jobslist->users_customers_id)->first();
          $jobslist->employee_data = DB::table('users_customers')->where('users_customers_id', $request->users_customers_id)->first();
          $jobs[] = $jobslist;
        //}
      }

      if ($jobs) {
        $response["code"] = 200;
        $response["status"] = "success";
        $response["data"] = $jobs;
      } else {
        $response["code"] = 404;
        $response["status"] = "error";
        $response["message"] = "No jobs found.";
      }
    } else {
      $response["code"] = 404;
      $response["status"] = "error";
      $response["message"] = "All fields are needed.";
    }

    return response()
      ->json(array( 'status' => $response["status"], isset($response["message"]) ? 'message' : 'data' => isset($response["message"]) ? $response["message"] : $response["data"]))
      ->header('Content-Type', 'application/json');
  }
  /* SEARCH JOBS EMPLOYEES */

  function calculateExtraPriceAndEarnings($startTime, $endTime) {
    $system_settings     = DB::table('system_settings')->get();

    $baseRate = $system_settings[22]->description; // $21/hour
    $serviceFeePercentage = $system_settings[24]->description/100;
    $taxPercentage = $system_settings[20]->description/100; // 13%
    
    $start = Carbon::parse($startTime);
    $end = Carbon::parse($endTime);
    if($start <= $end){
      $totalTime = $end->diffInMinutes($start);
      if($totalTime==0 || $totalTime < 0){
        $data=[
          'totalTime' => 0,
          'fareWithoutServiceFee' => 0,
          'serviceFee' => 0,
          'fareWithoutTax' => 0,
          'fareWithTax' => 0,
          'serviceFeeWithTax' => 0,
          'earningsWithoutServiceFee' => 0,
          'earningsAfterServiceFee' => 0,
          'taxOnEarnings' => 0,
          'earningsWithTax' => 0,
        ];
        return $data;
      }
      // Calculate the fare without service fee
      $fareWithoutServiceFee = ($totalTime / 60) * $baseRate;
      
      // Calculate the service fee
      $serviceFee = $fareWithoutServiceFee * $serviceFeePercentage;
      
      // Calculate the fare without tax
      $fareWithoutTax = $fareWithoutServiceFee + $serviceFee;
      
      // Calculate the fare with tax
      $fareWithTax = $fareWithoutTax * (1 + $taxPercentage);
      
      // Calculate StandMan's earnings
      $serviceFeeWithTax = $serviceFee * (1 + $taxPercentage);
      $earningsWithoutServiceFee = $fareWithoutServiceFee * (1 + $taxPercentage);
      $earningsAfterServiceFee = $earningsWithoutServiceFee - $serviceFeeWithTax;
      $taxOnEarnings = $earningsAfterServiceFee * $taxPercentage;
      $earningsWithTax = $earningsAfterServiceFee + $taxOnEarnings;
      
      // Format the amounts to two decimal places
      $fareWithoutServiceFee = number_format($fareWithoutServiceFee, 2);
      $serviceFee = number_format($serviceFee, 2);
      $fareWithTax = number_format($fareWithTax, 2);
      $serviceFeeWithTax = number_format($serviceFeeWithTax, 2);
      $earningsWithoutServiceFee = number_format($earningsWithoutServiceFee, 2);
      $earningsAfterServiceFee = number_format($earningsAfterServiceFee, 2);
      $taxOnEarnings = number_format($taxOnEarnings, 2);
      $earningsWithTax = number_format($earningsWithTax, 2);
      // Return the calculated values

      $hours = floor($totalTime / 60);
      $minutes = $totalTime % 60;
      $formattedTime = gmdate('H:i', ($hours * 3600) + ($minutes * 60));
      $data=[
        'totalTime' => $formattedTime,
        'fareWithoutServiceFee' => $fareWithoutServiceFee,
        'serviceFee' => $serviceFee,
        'fareWithoutTax' => $fareWithoutTax,
        'fareWithTax' => $fareWithTax,
        'serviceFeeWithTax' => $serviceFeeWithTax,
        'earningsWithoutServiceFee' => $earningsWithoutServiceFee,
        'earningsAfterServiceFee' => $earningsAfterServiceFee,
        'taxOnEarnings' => $taxOnEarnings,
        'earningsWithTax' => $earningsWithTax,
      ];
      return $data;
      
    }else{
      $data=[
        'totalTime' => 0,
        'fareWithoutServiceFee' => 0,
        'serviceFee' => 0,
        'fareWithoutTax' => 0,
        'fareWithTax' => 0,
        'serviceFeeWithTax' => 0,
        'earningsWithoutServiceFee' => 0,
        'earningsAfterServiceFee' => 0,
        'taxOnEarnings' => 0,
        'earningsWithTax' => 0,
      ];
      return $data;
  }
  }
    /* JOBS EXTRA AMOUNT */
    public function jobs_extra_amount(Request $request){
      if (isset($request->job_completion_time) && isset($request->employee_users_customers_id) && isset($request->jobs_id)){
        $job_applied_status                = DB::table('jobs_requests')->where('jobs_id', $request->jobs_id)->where('status', 'Accepted')->where('users_customers_id', $request->employee_users_customers_id)->first();
        if($job_applied_status){
          
          $job = DB::table('jobs')->where('jobs_id', $request->jobs_id)->first();

          $startTime = $job->end_time;
          $endTime = $request->job_completion_time;
          
          $job_extra_price=$this->calculateExtraPriceAndEarnings($startTime, $endTime);
          
          $previous_amount=number_format($job->price+$job->tax+$job->service_charges,2);
          $extra_time_price                 = $job_extra_price["fareWithoutServiceFee"];
          $job_extra_service_charges        = $job_extra_price["serviceFee"];
          $job_extra_tax                     = number_format($job_extra_price["fareWithTax"]-$job_extra_price["fareWithoutTax"],2);
          $payment=number_format($previous_amount+$extra_time_price+$job_extra_service_charges+$job_extra_tax ,2);
          $extra_time=$job_extra_price["totalTime"];
          $booked_time=$job->start_time.'-'.$job->end_time;
          $booked_close=$request->job_completion_time;

          $date_end_job = Carbon::parse($booked_close);
          $updateData=[
            "extra_time_price"=>$extra_time_price,
            "extra_time_service_charges"=>$job_extra_service_charges,
            "extra_time_tax"=>$job_extra_tax,
            "extra_time"=>$extra_time,
            "total_price"=>$payment,
            "date_end_job"=>$date_end_job,
          ];
          $job_extra_tax=$job_extra_tax+$job->tax;
          $job_extra_service_charges=$job_extra_service_charges+$job->service_charges;
          $data=[
            "payment"=>number_format($payment-$previous_amount,2),
            "previous_amount"=>number_format($previous_amount,2),
            "extra_amount"=>number_format($extra_time_price,2),
            "service_charges"=>number_format($job_extra_service_charges,2),
            "tax"=>number_format($job_extra_tax,2),
            "booked_time"=>$booked_time,
            "booked_close"=>$booked_close,
            "extra_time"=>$extra_time,
            "users_customers_id"=>$job->users_customers_id,
            "employee_users_customers_id"=>$job_applied_status->users_customers_id,
            "jobs_id"=>$job->jobs_id
          ];
          /* UPDATE JOB*/
            $update_job    = DB::table('jobs')->where('jobs_id', $request->jobs_id)->update($updateData);
          /* UPDATE JOB*/

          if($update_job){
            $response["code"] = 200;
            $response["status"] = "success";
            $response["data"] = $data;
          }else {
            $response["code"] = 200;
            $response["status"] = "error";
            $response["message"] = "Oops! Something went wrong.";
          }
        } else {
          $response["code"] = 200;
          $response["status"] = "success";
          $response["message"] = "Job Not assigned to you or you have not accepted the job. Invalid Information.";
        }
      } else {
        $response["code"] = 200;
        $response["status"] = "success";
        $response["message"] = "All fields are required.";
      }
  
      return response()
        ->json(array( 'status' => $response["status"], isset($response["message"]) ? 'message' : 'data' => isset($response["message"]) ? $response["message"] : $response["data"]))
        ->header('Content-Type', 'application/json');
    }
    /* JOBS EXTRA AMOUNT */

  /* CUSTOMERS WALLET TXN */
  public function customer_wallet_txn(Request $req){
    if (isset($req->users_customers_id)) {
      $user = DB::table('users_customers')->where(['users_customers_id'=> $req->users_customers_id,'status'=>'Active'])->first();
      if ($user) {
        $wallet_txns=DB::table('wallet_txns')->where('users_customers_id', $req->users_customers_id)->get();
        $get_data=[];
        $expenses=0;
        foreach ($wallet_txns as $key => $txn) {
          $expenses+=$txn->total_amount;
          $txn->date_added = Carbon::parse($txn->date_added)->format('F d, Y');
          $txn->user_data= DB::table('users_customers')->where(['users_customers_id'=> $txn->users_customers_id])->first();
          $job= DB::table('jobs')->where(['jobs_id'=> $txn->jobs_id])->first();
          $booked_time=$job->start_time.'-'.$job->end_time;
          $date_end_job = Carbon::parse($job->date_end_job)->format('H:i');
          $extra_time = $job->extra_time;
          $txn->txn_detail=[
            "user_name"=>$txn->user_data->first_name.' '.$txn->user_data->last_name,
            "data"=>$txn->date_added,
            "total_price"=>$job->total_price,
            "previous_price"=>number_format($job->price+$job->tax+$job->service_charges,2),
            "extra_service_charges"=>$job->extra_time_service_charges,
            "booked_time"=>$booked_time,
            "booked_close"=>$date_end_job,
            "extra_time"=>$extra_time,
            "extra_price"=>$job->extra_time_price,
          ];
          $get_data[]=$txn;
        }
        $data=[
          'expenses'=>number_format($expenses,2),
          'transaction_history'=>$get_data
        ];


        if (count($data) >0) {
          $response["code"] = 200;
          $response["status"] = "success";
          $response["data"] = $data;
        } else{
          $response["code"] = 404;
          $response["status"] = "error";
          $response["message"] = "Data not Found.";
        }
      } else {
        $response["code"] = 404;
        $response["status"] = "error";
        $response["message"] = "User does not exits.";
      }
    } else {
      $response["code"] = 404;
      $response["status"] = "error";
      $response["message"] = "All fields are needed.";
    }

    return response()
    ->json(array( 'status' => $response["status"], isset($response["message"]) ? 'message' : 'data' => isset($response["message"]) ? $response["message"] : $response["data"]))
    ->header('Content-Type', 'application/json');
  }
  /* CUSTOMERS WALLET TXN */

  /* EMPLOYEE WALLET TXN */
  public function employee_wallet_txn(Request $req){
    if (isset($req->users_customers_id)) {
      $user = DB::table('users_customers')->where(['users_customers_id'=> $req->users_customers_id,'status'=>'Active'])->first();
      if ($user) {
        $wallet_txns=DB::table('wallet_txns')->where('employee_users_customers_id', $req->users_customers_id)->get();
        $get_data=[];
        $earning=0;
        foreach ($wallet_txns as $key => $txn) {
          $txn->date_added = Carbon::parse($txn->date_added)->format('F d, Y');
          $txn->user_data= DB::table('users_customers')->where(['users_customers_id'=> $txn->users_customers_id])->first();
          $job= DB::table('jobs')->where(['jobs_id'=> $txn->jobs_id])->first();
          $earning+=$job->price;
          $booked_time=$job->start_time.'-'.$job->end_time;
          $date_end_job = Carbon::parse($job->date_end_job)->format('H:i');
          $extra_time = $job->extra_time;
          $txn->txn_detail=[
            "user_name"=>$txn->user_data->first_name.' '.$txn->user_data->last_name,
            "date"=>$txn->date_added,
            "total_price"=>number_format($job->price+$job->extra_time_price,2),
            "previous_price"=>$job->price,
            "extra_price"=>$job->extra_time_price,
            "booked_time"=>$booked_time,
            "booked_close"=>$date_end_job,
            "extra_time"=>$extra_time,
          ];
          $get_data[]=$txn;
        }
        $data=[
          'earning'=>number_format($earning,2),
          'withdraw'=>$user->wallet_amount,
          'transaction_history'=>$get_data
        ];


        if (count($data) >0) {
          $response["code"] = 200;
          $response["status"] = "success";
          $response["data"] = $data;
        } else{
          $response["code"] = 404;
          $response["status"] = "error";
          $response["message"] = "Data not Found.";
        }
      } else {
        $response["code"] = 404;
        $response["status"] = "error";
        $response["message"] = "User does not exits.";
      }
    } else {
      $response["code"] = 404;
      $response["status"] = "error";
      $response["message"] = "All fields are needed.";
    }

    return response()
    ->json(array( 'status' => $response["status"], isset($response["message"]) ? 'message' : 'data' => isset($response["message"]) ? $response["message"] : $response["data"]))
    ->header('Content-Type', 'application/json');
  }
  /* EMPLOYEE WALLET TXN */

  /* ADD JOB RATING  */
  public function add_job_rating(Request $req){
    if (isset($req->users_customers_id) && isset($req->employee_users_customers_id) && isset($req->jobs_id)  && isset($req->rating)){
      $job             = DB::table('jobs')->where('jobs_id', $req->jobs_id)->first();
      if($job){
        $saveData=[
          'users_customers_id'  =>  $req->users_customers_id,
          'employee_users_customers_id'  =>  $req->employee_users_customers_id,
          'jobs_id'             =>  $req->jobs_id,
          'rating'             =>  $req->rating,
        ];
        if(isset($req->comment)){
          $saveData['comment']  = $req->comment;
        }
        
        $job_rating=JobRating::updateorCreate([
            'users_customers_id'  =>  $req->users_customers_id,
            'employee_users_customers_id'  =>  $req->employee_users_customers_id,
            'jobs_id'             =>  $req->jobs_id,
        ],$saveData);
        $job_rated = JobRating::where([
              'users_customers_id'  =>  $req->users_customers_id,
              'employee_users_customers_id'  =>  $req->employee_users_customers_id,
              'jobs_id'             =>  $req->jobs_id,
          ])->first();
        $jobs_ratings = JobRating::where('employee_users_customers_id',$req->employee_users_customers_id)->get();
        $total_rating=0;
        foreach ($jobs_ratings as $key => $jobs_rating) {
          $total_rating += $jobs_rating->rating;
        }
        if(count($jobs_ratings)>0){
          $avarge_rating=$total_rating/count($jobs_ratings);
        }else{
          $avarge_rating=$total_rating;
        }

        $update_user_rating = DB::table('users_customers')->where('users_customers_id',$req->employee_users_customers_id)->update(['rating'=>$avarge_rating]);
        $user_data = DB::table('users_customers')->where('users_customers_id',$req->employee_users_customers_id)->first();
        $data=[
          "job_rated"=>$job_rated,
          "user_data"=>$user_data
        ];
        if($job_rating){
          $response["code"] = 200;
          $response["status"] = "success";
          $response["data"] = $data;
        }else {
          $response["code"] = 200;
          $response["status"] = "error";
          $response["message"] = "Oops! Something went wrong.";
        }
      } else {
        $response["code"] = 200;
        $response["status"] = "error";
        $response["message"] = "Job does not exist.";
      }
    } else {
      $response["code"] = 200;
      $response["status"] = "success";
      $response["message"] = "All fields are required.";
    }

    return response()
      ->json(array( 'status' => $response["status"], isset($response["message"]) ? 'message' : 'data' => isset($response["message"]) ? $response["message"] : $response["data"]))
      ->header('Content-Type', 'application/json');
  }
  /* ADD JOB RATING */

  /* ALL RATINGS  */
  public function all_ratings(Request $req){
    if (isset($req->users_customers_id)){
      $user             = DB::table('users_customers')->where(['users_customers_id'=> $req->users_customers_id,'status'=>'Active'])->first();
      if($user){
        $data=[];
        $ratings = DB::table('jobs_ratings')->where('employee_users_customers_id',$req->users_customers_id)
                          ->orWhere('users_customers_id',$req->users_customers_id)->get();
        foreach ($ratings as $key => $rate) {
          if($rate->users_customers_id==$req->users_customers_id){
            $rate->customer_data=DB::table('users_customers')->where(['users_customers_id'=> $rate->employee_users_customers_id])->first();
          }
          if($rate->employee_users_customers_id==$req->users_customers_id){
            $rate->customer_data=DB::table('users_customers')->where(['users_customers_id'=> $rate->users_customers_id])->first();
          }
          $data[] = $rate;
        }

        if(count($data)>0){
          $response["code"] = 200;
          $response["status"] = "success";
          $response["data"] = $data;
        } else{
          $response["code"] = 404;
          $response["status"] = "error";
          $response["message"] = "Data not Found.";
        }
      } else {
        $response["code"] = 200;
        $response["status"] = "success";
        $response["message"] = "User does not exist.";
      }
    } else {
      $response["code"] = 200;
      $response["status"] = "success";
      $response["message"] = "All fields are required.";
    }

    return response()
      ->json(array( 'status' => $response["status"], isset($response["message"]) ? 'message' : 'data' => isset($response["message"]) ? $response["message"] : $response["data"]))
      ->header('Content-Type', 'application/json');
  }
  /* ALL RATINGS */

   /* UPDATE JOB RADIUS */
   public function update_job_radius(Request $req){
    if(isset($req->users_customers_id) && isset($req->job_radius) ) {
      $updateData['job_radius']         = $req->job_radius;

      DB::table('users_customers')->where('users_customers_id', $req->users_customers_id)->update($updateData);
      $updatedData = DB::table('users_customers')->where('users_customers_id', $req->users_customers_id)->first();
 
      $response["code"] = 200;
      $response["status"] = "success";
      $response["data"] = $updatedData;
    } else {
      $response["code"] = 404;
      $response["status"] = "error";
      $response["message"] = "All fields are needed.";
    }

    return response()
      ->json(array( 'status' => $response["status"], isset($response["message"]) ? 'message' : 'data' => isset($response["message"]) ? $response["message"] : $response["data"]))
      ->header('Content-Type', 'application/json');
  }
  /* UPDATE JOB RADIUS */

   /* JOB CREATION PAYMENT */
   public function job_creation_payment(Request $req){
    if(isset($req->users_customers_id) && isset($req->transaction_id) && isset($req->jobs_id) ) {
       
        /* JOB DATA */
        $job     = DB::table('jobs')->where('jobs_id', $req->jobs_id)->first();
        /* JOB DATA */
        if($job){
          
          /* WALLET TXN */
          $txnData=[
            'users_customers_id'  =>  $req->users_customers_id,
            'transaction_id'  =>  $req->transaction_id,
            'jobs_id'             =>  $req->jobs_id,
            'txn_type'            =>  'In',
            'total_amount'        =>  $job->total_price,
            'tax'                 =>  $job->tax,
            'service_charges'     =>  $job->service_charges,
            'standman_amount'     =>  $job->price,
            'date_time'           =>  date('Y-m-d H:i:s'),
            'date_added'          =>  date('Y-m-d H:i:s'),
            'narration'           =>  'Job Created'
          ];
          
          $wallet_txn_id = DB::table('wallet_txns')->insertGetId($txnData);
          $data = DB::table('wallet_txns')->where('wallet_txns_id', $wallet_txn_id)->first();
          /* WALLET TXN  */
        $response["code"] = 200;
        $response["status"] = "success";
        $response["data"] = $data;
      } else {
        $response["code"] = 404;
        $response["status"] = "error";
        $response["message"] = "job not exist.";
      }
    } else {
      $response["code"] = 404;
      $response["status"] = "error";
      $response["message"] = "All fields are needed.";
    }

    return response()
      ->json(array( 'status' => $response["status"], isset($response["message"]) ? 'message' : 'data' => isset($response["message"]) ? $response["message"] : $response["data"]))
      ->header('Content-Type', 'application/json');
  }
  /* JOB CREATION PAYMENT */
    
  
  /* EMPLOYEE ARRIVED */
  public function employee_arrived(Request $req){
    if (isset($req->users_customers_id) && isset($req->jobs_id)){

      $job_radius     = DB::table('system_settings')->where('type', 'job_radius')->first();
      $jobs_requests  = DB::table('jobs_requests')->where(['users_customers_id'=>$req->users_customers_id,"jobs_id"=>$req->jobs_id,"status"=>"Accepted"])->first();
      if($jobs_requests){
        $job = DB::table('jobs')->where(["jobs_id"=>$req->jobs_id,"status"=>"Accepted"])->first();
        if($job){
            $update_job=DB::table('jobs')->where("jobs_id",$req->jobs_id)->update(['status'=>"Ongoing"]);
            $data = DB::table('jobs')->where(["jobs_id"=>$req->jobs_id,"status"=>"Ongoing"])->first();
            if ($data) {
              $response["code"] = 200;
              $response["status"] = "success";
              $response["data"] = $data;
            } else {
              $response["code"] = 404;
              $response["status"] = "error";
              $response["message"] = "No jobs found.";
            }
        } else {
          $response["code"] = 404;
          $response["status"] = "error";
          $response["message"] = "Job not found.";
        }
      } else {
        $response["code"] = 404;
        $response["status"] = "error";
        $response["message"] = "You didn't accept this job.";
      }      
    } else {
      $response["code"] = 404;
      $response["status"] = "error";
      $response["message"] = "All fields are needed.";
    }

    return response()
      ->json(array( 'status' => $response["status"], isset($response["message"]) ? 'message' : 'data' => isset($response["message"]) ? $response["message"] : $response["data"]))
      ->header('Content-Type', 'application/json');
  }
  /* EMPLOYEE ARRIVED */
  
  /* CUSTOMER EDITABLE JOBS */
  public function customer_editable_jobs(Request $req){
    if (isset($req->users_customers_id)){
        $jobs = DB::table('jobs')
                ->where(["users_customers_id"=>$req->users_customers_id,"status"=>"Accepted"])
                ->where(function ($query) {
                  $query->where('start_date', '<', date('Y-m-d'))
                      ->orWhere(function ($q) {
                          $q->where('start_date', date('Y-m-d'))
                              ->where('start_time', '<', date('H:i:s'));
                      });
                })
                ->get();
              $get_data=[];
            foreach($jobs as $job){
              $job->user_data= DB::table('users_customers')->where(['users_customers_id'=> $job->users_customers_id])->first();
              $get_data[]=$job;
            }
        if(count($get_data)>0){
          $response["code"] = 200;
          $response["status"] = "success";
          $response["data"] = $get_data;
        } else {
          $response["code"] = 404;
          $response["status"] = "error";
          $response["message"] = "No jobs found.";
        }
    } else {
      $response["code"] = 404;
      $response["status"] = "error";
      $response["message"] = "All fields are needed.";
    }

    return response()
      ->json(array( 'status' => $response["status"], isset($response["message"]) ? 'message' : 'data' => isset($response["message"]) ? $response["message"] : $response["data"]))
      ->header('Content-Type', 'application/json');
  }
  /* CUSTOMER EDITABLE JOBS */

 /* JOBS COMPLETE WITHOUT EXTRA TIME */
  public function jobs_complete_without_extra_time(Request $request) {
    if (isset($request->users_customers_id) && isset($request->employee_users_customers_id) && isset($request->jobs_id)){
      $job_applied_status                = DB::table('jobs_requests')->where('jobs_id',$request->jobs_id)->where('status', 'Accepted')->where('users_customers_id', $request->employee_users_customers_id)->first();
      if($job_applied_status){
        /* UPDATE JOB STATUS */
        $update_job_status              = DB::table('jobs')->where('jobs_id', $request->jobs_id)->update(['status'=>'Completed']);
        /* UPDATE JOB STATUS */
        
        /* UPDATE EMPLOYEE WALLET */
        $job   = DB::table('jobs')->where('jobs_id', $request->jobs_id)->first();
        if ($job) {
          $end_time = $job->end_time;
          $now_time = date("H:i:s");

          $end = Carbon::parse($end_time);
          $now = Carbon::parse($now_time);

          if ($now < $end) {
        
            $employee              = DB::table('users_customers')->where('users_customers_id', $request->employee_users_customers_id)->first();
            $totalamount     = $job->price+$employee->wallet_amount;
            
            $update_employee_wallet = DB::table('users_customers')->where('users_customers_id', $request->employee_users_customers_id)->update(['wallet_amount'=>$totalamount]);
            /* UPDATE EMPLOYEE WALLET  */
            
            /* UPDATE JOB STATUS */
            $update_job_request_status      = DB::table('jobs_requests')->where('jobs_id', $request->jobs_id)->where('users_customers_id', $request->employee_users_customers_id)->update(['status'=>'Completed']);
            /* UPDATE JOB STATUS */

            /* WALLET TXN */
            $txnData=[
              'users_customers_id'  =>  $request->users_customers_id,
              'employee_users_customers_id'  =>  $request->employee_users_customers_id,
              'jobs_id'             =>  $request->jobs_id,
              'txn_type'            =>  'In',
              'total_amount'        =>  $job->total_price,
              'tax'                 =>  $job->tax,
              'service_charges'     =>  $job->service_charges,
              'standman_amount'     =>  $job->price,
              'date_time'           =>  date('Y-m-d H:i:s'),
              'date_added'          =>  date('Y-m-d H:i:s'),
              'narration'           =>  'Job Completed'
            ];
            
            $wallet_txn = DB::table('wallet_txns')->insertGetId($txnData);
            /* WALLET TXN  */
            $job->total_price=intval($job->total_price);
            $job->date_added=Carbon::parse($job->date_added)->format('F d, Y');
            $data=[
              'job'=>$job,
              'customer'=>DB::table('users_customers')->where('users_customers_id', $request->users_customers_id)->first(),
              'employee'=>$employee
            ];
            $response["code"] = 200;
            $response["status"] = "success";
            $response["data"] = $data;
          } else {
              $response["code"] = 200;
              $response["status"] = "error";
              $response["message"] = "Job completed after end time.";
          }
        } else {
            $response["code"] = 404;
            $response["status"] = "error";
            $response["message"] = "Job not found.";
        }

      } else {
        $response["code"] = 200;
        $response["status"] = "success";
        $response["message"] = "Job Not assigned to you or you have not accepted the job. Invalid Information.";
      }
    } else {
      $response["code"] = 200;
      $response["status"] = "success";
      $response["message"] = "All fields are required.";
    }
    return response()
        ->json([
            'status' => $response["status"],
            isset($response["message"]) ? 'message' : 'data' => isset($response["message"]) ? $response["message"] : $response["data"]
        ])
      ->header('Content-Type', 'application/json');
  }
  /* JOBS COMPLETE WITHOUT EXTRA TIME */

   /* JOB EDIT */
   public function jobs_edit(Request $req){
    if (isset($req->users_customers_id) && isset($req->start_date) && isset($req->start_time) && isset($req->end_time) && isset($req->jobs_id)) {
      $job              = DB::table('jobs')->where(['jobs_id'=>$req->jobs_id,"status"=>"Accetped"])->first();
      if ($job) {
        $startTime = $req->start_time;
        $endTime = $req->end_time;
        $job_price=$this->calculatePriceAndEarnings($startTime, $endTime);
        $data['price']                  = $job_price["fareWithoutServiceFee"];
        $data['service_charges']        = $job_price["serviceFee"];
        $data['tax']                     = number_format($job_price["fareWithTax"]-$job_price["fareWithoutTax"],2);
        $data['total_price']            = number_format($job_price["fareWithoutServiceFee"]+$job_price["serviceFee"]+$data['tax'],2);
        // job price equal 
        if($job->total_price == $data['total_price']){

          $updateData['start_date']             = $req->start_date;
          $updateData['start_time']             = $req->start_time;
          $updateData['end_time']               = $req->end_time;
          $updateData['price']                  = $data['price'];
          $updateData['service_charges']        = $data['service_charges'];
          $updateData['tax']                     =$data['tax'] ;
          $updateData['total_price']            = $data['total_price'];
          
          $updatejob      = DB::table('jobs')->where('jobs_id', $req->jobs_id)->update($updateData);
          
          $response["code"]     = 200;   
          $response["status"]   = "success";
          $response["message"]     = "Job Updated";
        } elseif($job->total_price > $data['total_price']){
          $users_customers_data=DB::table('users_customers')->where('users_customers_id', $job->users_customers_id)->first();
          $extra_paid_amount=$job->total_price - $data['total_price'];
          $wallet_amount=$extra_paid_amount+$users_customers_data->wallet_amount;
          $update_customers_wallet = DB::table('users_customers')->where('users_customers_id', $job->users_customers_id)->update(['wallet_amount'=>$wallet_amount]);

          $updateData['start_date']             = $req->start_date;
          $updateData['start_time']             = $req->start_time;
          $updateData['end_time']               = $req->end_time;
          $updateData['price']                  = $data['price'];
          $updateData['service_charges']        = $data['service_charges'];
          $updateData['tax']                     =$data['tax'] ;
          $updateData['total_price']            = $data['total_price'];          
          
          $updatejob      = DB::table('jobs')->where('jobs_id', $req->jobs_id)->update($updateData);
            
          $response["code"]     = 200;   
          $response["status"]   = "success";
          $response["message"]     = "Job Updated";
        }elseif ($job->total_price < $data['total_price']) {
          $jobUpdateData=[
            'start_date'       => $req->start_date,
            'start_time'       => $req->start_time,
            'end_time'         => $req->end_time,
            'price'            => $data['price'],
            'service_charges'  => $data['service_charges'],
            'tax'              => $data['tax'],
            'total_price'      => $data['total_price']
          ];
          $payment=[            
            'price'            => $data['price']-$job->price,
            'service_charges'  => $data['service_charges']-$job->service_charges,
            'tax'              => $data['tax']-$job->tax,
            'total_price'      => $data['total_price']-$job->total_price
          ];
          $get_data=[
            "jobUpdateData"=>$jobUpdateData,
            "payment"=>$payment,
          ];
          $response["code"]     = 200;   
          $response["status"]   = "error";
          $response["data"]     = $get_data;
        }

      } else {
        $response["code"] = 404;
        $response["status"] = "error";
        $response["message"] = "Job not found.";
      }
    } else {
      $response["code"] = 404;
      $response["status"] = "error";
      $response["message"] = "All fields are needed.";
    }
    
    return response()
     ->json(array( 'status' => $response["status"], isset($response["message"]) ? 'message' : 'data' => isset($response["message"]) ? $response["message"] : $response["data"]))
     ->header('Content-Type', 'application/json');
  }
  /* JOB EDIT */
} 

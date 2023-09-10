<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use App\Models\Event_post;
use App\Models\Tag;
use App\Models\Event_tag;

use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use DB;

use Artisan;
use Session;

class AdminController extends Controller{
    public $successStatus = 200;
    public $errorStatus = 401;

    // -------------- CACHE PAGE ------------- //
    public function clear_cache(Request $request){
        $exitCode = Artisan::call('route:clear');
        $exitCode = Artisan::call('config:cache');
        $exitCode = Artisan::call('cache:clear');
        $exitCode = Artisan::call('view:clear');

        Session::flash('success', 'Cache Cleared!'); 
        return redirect('admin/dashboard');
    }
    // -------------- CACHE PAGE ------------- //
    
    // -------------- LOGIN PAGE ------------- //
    public function index(Request $request){
        if ($request->session()->has('id')) {
            return redirect('admin/dashboard');
        } else{
            return view('admin.login');
        }
    }
    // -------------- LOGIN PAGE ------------- //

    // -------------- LOGIN AUTHENTICATION ------------- //
    public function login(Request $request){
        $validateData = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        
        $postData = $request->all();
        $ifExists = DB::table('users_system')->where('email', $postData['email'])->where('password', $postData['password'])->first();
        if (!empty($ifExists)) {
            $request->session()->put([
                'id' => $ifExists->users_system_id,
                'users_system_roles_id'=>$ifExists->users_system_roles_id,
                'user_image' => $ifExists->user_image,
                'fname' => $ifExists->first_name,
                'lname' => '',
                'email' => $ifExists->email,
            ]);
            Session::flash('success', ' Logged in successfully.'); 
            return redirect('admin/dashboard');
        } else {
            Session::flash('error', 'Invalid Email/Password'); 
            return redirect()->back();
        }
    }
    // -------------- LOGIN AUTHENTICATION ------------- //

    // -------------- LOGOUT ------------- //
    public function logout(Request $request){
        $request->session()->flush();
        return redirect('admin/');
    }
    // -------------- LOGOUT ------------- //

    // ------------- DASHBOARD -------------- //
    public function dashboard(){
        if(session()->has('id')){
            $total_users_customers     = number_format(DB::table('users_customers')->count());
            $completed_jobs     = number_format(DB::table('jobs')->where('status','completed')->count());
            $system_currency    = DB::table('system_settings')->select('description')->where('type', 'system_currency')->get()->first();
            
            return view('admin.dashboard', compact('total_users_customers','completed_jobs'));
        } else {
            return redirect('admin/');
        }
    }
    // ------------- DASHBOARD -------------- //

    /*** SUPPORT ***/
    public function support(){
        if (!session()->has('id')) {
          return redirect('admin');
        } else {
          return view('admin.support');
        }
    }
    /*** SUPPORT ***/    

    // ------------- ACCOUNT SETTINGS -------------- //
    public function account_settings(){
        if(session()->has('id')){
            $page_name = 'account_settings';
            $fetch_data = DB::table('users_system')->where('users_system_id',session('id'))->get();
            return view('admin.account_settings',compact('fetch_data','page_name'));
        } else {
            return redirect('admin');
        }
    }
    // ------------- ACCOUNT SETTINGS -------------- //

    // ------------- UPDATE ACCOUNT SETTINGS -------------- //
    public function account_settings_update(Request $req,$id){
        $insert=array();
        $insert['first_name'] = $req->first_name;
        $insert['email'] = $req->email;
        $insert['password'] = $req->password;
        
        $insert['city'] = $req->city;
        $insert['address'] = $req->address;
        $insert['mobile'] = $req->mobile;

        if ($req->hasfile('image')) {
            $file = $req->file('image');
            if ($file->isValid()) {
                $ext = $file->extension();
                $path = public_path('uploads/users_system/');
                $prefix = 'user-' . md5(time());
                $img_name = $prefix . '.' . $ext;
                if ($file->move($path, $img_name)) {
                    $insert['user_image'] = 'uploads/users_system/' . $img_name;
                }
            }
        }

        $a = DB::table('users_system')->where('users_system_id','=',$id)->update($insert);
        if ($a) {
            Session::flash('success', ' Profile Updated successfully'); 
            return redirect('admin/account_settings');
        } else {
            Session::flash('error', ' oops! something went wrong'); 
            return redirect('admin/account_settings');
        }
    }
    // ------------- UPDATE ACCOUNT SETTINGS -------------- //

    // ------------- MANAGE SYSTEM SETTINGS -------------- //
    public function system_settings(Request $request){
        if ($request->session()->has('id')) {
            $page_name = 'system_settings';
            $system_settings = DB::table('system_settings')->get();
            return view('admin.system_settings', compact('system_settings','page_name'));
        } else {
            return redirect('admin');
        }
    }
    // ------------- MANAGE SYSTEM ROLES EDIT -------------- //

    // ------------- MANAGE SYSTEM USERS ROLES DATA -------------- //
    public function system_settings_edit(Request $req){
        $page_name  = $req->page_name;

        if(isset($req->invite_text)){
            $data['description']          = $req->invite_text;
            DB::table('system_settings')->where('type', 'invite_text')->update($data);
        } 

        if(isset($req->admin_share)){
            $data['description']          = $req->admin_share;
            DB::table('system_settings')->where('type', 'admin_share')->update($data);
        } 

        if(isset($req->email)){
            $data['description']          = $req->email;
            DB::table('system_settings')->where('type', 'email')->update($data);
        } 

        if(isset($req->phone)){
            $data['description']          = $req->phone;
            DB::table('system_settings')->where('type', 'phone')->update($data);
        } 

        if(isset($req->system_name)){
            $data['description']          = $req->system_name;
            DB::table('system_settings')->where('type', 'system_name')->update($data);
        } 

        if(isset($req->address)){
            $data['description']          = $req->address;
            DB::table('system_settings')->where('type', 'address')->update($data);
        } 

        if(isset($req->system_currency)){
            $data['description']          = $req->system_currency;
            DB::table('system_settings')->where('type', 'system_currency')->update($data);
        } 

        if(isset($req->social_login)){
            $data['description']          = $req->social_login;
            DB::table('system_settings')->where('type', 'social_login')->update($data);
        } 

        if(isset($req->about_text)){
            $data['description']          = $req->about_text;
            DB::table('system_settings')->where('type', 'about_text')->update($data);
        }

        if(isset($req->terms_text)){
            $data['description']          = $req->terms_text;
            DB::table('system_settings')->where('type', 'terms_text')->update($data);
        }

        if(isset($req->privacy_text)){
            $data['description']          = $req->privacy_text;
            DB::table('system_settings')->where('type', 'privacy_text')->update($data);
        }

        if (isset($req->image)) {
            $image              = $req->file('image');
            $image1_name        = $image->getClientOriginalName();
            $destinationPath    = public_path().'/uploads/system_image' ;
            $image_n            = $image1_name;
            $uploaded           = $image->move($destinationPath, $image1_name);
            
            $data['description'] = $image_n;
            DB::table('system_settings')->where('type', 'system_image')->update($data);
        }   

        session()->flash('success', 'System settings updated successfully!');
        return redirect('admin/'.$page_name);
    }
    // ------------- MANAGE SYSTEM USERS ROLES DATA -------------- //

    // ------------- MANAGE SYSTEM USERS -------------- //
    public function users_system(Request $request){
        if ($request->session()->has('id')) {
            $page_name = 'users_system';
            $users= db::table('users_system')->orderBy('users_system_id', 'DESC')->get();
            return view('admin.users_system', compact('users', 'page_name'));
        } else {
            return redirect('admin');
        }
    }
    // ------------- MANAGE SYSTEM USERS -------------- //

    // ------------- UPDATE SYSTEM USERS -------------- //
    public function users_system_update(Request $req){
        $update_array['status'] = $req->status;        
        $updated = DB::table('users_system')->where('users_system_id', $req->id)->update($update_array);
        if ($updated) {
            Session::flash('success', ' Data Updated successfully'); 
            return redirect('admin/users_system');
        } else {
            Session::flash('error', ' Oops! something went wrong'); 
            return back()->with('errors', 'Oops! something went wrong');
        }
    }
    // ------------- UPDATE SYSTEM USERS -------------- //

    // ------------- DELETE SYSTEM USERS -------------- //
    public function users_system_delete(Request $req){
        if(session()->has('id')){
            if(!empty($req->id)){
                $checkdata = DB::table('users_system')->where('users_system_id', $req->id)->get();

                if(count($checkdata) != 0){
                    $del = DB::table('users_system')->where('users_system_id', $req->id)->delete();
                    if($del){
                        Session::flash('success', ' Data Deleted successfully'); 
                        return redirect('admin/users_system');
                    } else {
                        Session::flash('error', ' Oops! something went wrong'); 
                        return redirect('admin/users_system');
                    }
                } else {
                    Session::flash('error', ' This record is already deleted in status'); 
                    return redirect('admin/users_system');
                }
            } else {
                Session::flash('error', ' No Data Found'); 
                return redirect('admin/users_system');
            }
        } else {
            return redirect('admin');
        }
    }
    // ------------- DELETE SYSTEM USERS -------------- //

    // ------------- MANAGE SYSTEM USERS ADD -------------- //
    public function users_system_add(Request $request){
        if ($request->session()->has('id')) {
            $page_name = 'users_system';
            $roles = DB::table('users_system_roles')->orderBy('users_system_roles_id', 'DESC')->get();
            return view('admin.users_system_add', compact('roles', 'page_name'));
        } else {
            return redirect('admin');
        }
    }
    // ------------- MANAGE SYSTEM USERS ADD -------------- //

    // ------------- MANAGE SYSTEM USERS ADD DATA -------------- //
    public function users_system_add_data(Request $req){
        $save_data['users_system_roles_id']     = $req->users_system_roles_id;
        $save_data['first_name']                = $req->first_name;
        $save_data['email']                     = $req->email;
        $save_data['password']                  = $req->password;
        $save_data['mobile']                    = $req->mobile;
        $save_data['city']                      = $req->city;
        $save_data['address']                   = $req->address;
        $save_data['status']                    = $req->status;
        
        if (isset($req->image)) {
            $image = $req->file('image');
            $image1_name = $image->getClientOriginalName();
            $destinationPath = public_path().'/uploads/users_system' ;
            $image_n=  "uploads/users_system/".$image1_name;
            $image->move($destinationPath, $image1_name);
            
            $save_data['user_image'] = $image_n;
        }   
        $users_system_id = DB::table('users_system')->insertGetId($save_data);

        if($users_system_id > 0){ 
            session()->flash('success', 'User added successfully!');
            return redirect('admin/users_system');
        } else {
            session()->flash('error', 'Oops! Somrthing went wrong. Please try again.');
            return redirect()->back();
        }
    }
    // ------------- MANAGE SYSTEM USERS ADD DATA -------------- //

    // ------------- MANAGE SYSTEM USERS EDIT -------------- //
    public function users_system_edit(Request $request){
        if ($request->session()->has('id')) {
            $page_name = 'users_system';
            $roles = DB::table('users_system_roles')->orderBy('users_system_roles_id', 'DESC')->get();
            $users_system = DB::table('users_system')->where('users_system_id', $request->id)->get()->first();
            return view('admin.users_system_edit', compact('roles', 'users_system', 'page_name'));
        } else {
            return redirect('admin');
        }
    }
    // ------------- MANAGE SYSTEM USERS EDIT -------------- //

    // ------------- MANAGE SYSTEM USERS EDIT DATA -------------- //
    public function users_system_edit_data(Request $req){
        $update_data['users_system_roles_id']     = $req->users_system_roles_id;
        $update_data['first_name']                = $req->first_name;
        $update_data['email']                     = $req->email;
        $update_data['password']                  = $req->password;
        $update_data['mobile']                    = $req->mobile;
        $update_data['city']                      = $req->city;
        $update_data['address']                   = $req->address;
        $update_data['status']                    = $req->status;
        
        if (isset($req->image)) {
            $image = $req->file('image');
            $image1_name = $image->getClientOriginalName();
            $destinationPath = public_path().'/uploads/users_system' ;
            $image_n=  "uploads/users_system/".$image1_name;
            $image->move($destinationPath, $image1_name);
            
            $update_data['user_image'] = $image_n;
        }   
        $updated = DB::table('users_system')->where('users_system_id', $req->users_system_id)->update($update_data);

        if($updated > 0){ 
            session()->flash('success', 'User updated successfully!');
            return redirect('admin/users_system');
        } else {
            session()->flash('error', 'Oops! Somrthing went wrong. Please try again.');
            return redirect()->back();
        }
    }
    // ------------- MANAGE SYSTEM USERS EDIT DATA -------------- //

    // ------------- MANAGE SYSTEM ROLES -------------- //
    public function users_system_roles(Request $request){
        if ($request->session()->has('id')) {
            $page_name = 'users_system_roles';
            $users_system_roles = db::table('users_system_roles')->orderBy('users_system_roles_id', 'DESC')->get();
            return view('admin.users_system_roles', compact('users_system_roles','page_name'));
        } else {
            return redirect('admin');
        }
    }
    // ------------- MANAGE SYSTEM ROLES -------------- //

    // ------------- MANAGE SYSTEM ROLES ADD -------------- //
    public function users_system_roles_add(Request $request){
        if ($request->session()->has('id')) {
            $page_name = 'users_system_roles';
            return view('admin.users_system_roles_add', compact('page_name'));
        } else {
            return redirect('admin');
        }
    }
    // ------------- MANAGE SYSTEM ROLES ADD -------------- //

    // ------------- MANAGE SYSTEM ROLES ADD DATA -------------- //
    public function users_system_roles_add_data(Request $req){
        $data['dashboard']           = $req->dashboard;
        $data['users_customers']     = $req->users_customers;
        $data['users_system']        = $req->users_system;
        $data['users_system_roles']  = $req->users_system_roles;
        $data['system_settings']     = $req->system_settings;
        $data['account_settings']    = $req->account_settings;
        $data['delete_account_req']    = $req->delete_account_req;
        $data['jobs']    = $req->jobs;
        
        $users_system_id = DB::table('users_system_roles')->insertGetId($data);

        if($users_system_id > 0){ 
            session()->flash('success', 'Role added successfully!');
            return redirect('admin/users_system_roles');
        } else {
            session()->flash('error', 'Oops! Somrthing went wrong. Please try again.');
            return redirect()->back();
        }
    }
    // ------------- MANAGE SYSTEM ROLES ADD DATA -------------- //

    // ------------- MANAGE SYSTEM ROLES EDIT -------------- //
    public function users_system_roles_edit(Request $request){
        if ($request->session()->has('id')) {
            $page_name = 'users_system_roles';
            $users_system_roles = DB::table('users_system_roles')->where('users_system_roles_id', $request->id)->get()->first();
            return view('admin.users_system_roles_edit', compact('users_system_roles', 'page_name'));
        } else {
            return redirect('admin');
        }
    }
    // ------------- MANAGE SYSTEM ROLES EDIT -------------- //

    // ------------- MANAGE SYSTEM USERS ROLES DATA -------------- //
    public function users_system_roles_edit_data(Request $req){
        $data['name']                = $req->name;
        $data['status']              = $req->status;
        
        $data['dashboard']           = $req->dashboard;
        $data['users_customers']     = $req->users_customers;
        $data['users_system']        = $req->users_system;
        $data['users_system_roles']  = $req->users_system_roles;
        $data['system_settings']     = $req->system_settings;
        $data['account_settings']    = $req->account_settings;
        $data['delete_account_req']  = $req->delete_account_req;
        $data['jobs']                = $req->jobs;

        $updated = DB::table('users_system_roles')->where('users_system_roles_id', $req->users_system_roles_id)->update($data);

        if($updated > 0){ 
            session()->flash('success', 'Role updated successfully!');
            return redirect('admin/users_system_roles');
        } else {
            session()->flash('error', 'Oops! Somrthing went wrong. Please try again.');
            return redirect()->back();
        }
    }
    // ------------- MANAGE SYSTEM USERS ROLES DATA -------------- //

    // ------------- DELETE SYSTEM USERS ROLES -------------- //
    public function users_system_roles_delete(Request $req){
        if(session()->has('id')){
            if(!empty($req->id)){
                $checkdata = DB::table('users_system')->where('users_system_roles_id', $req->id)->get();

                if(count($checkdata) == 0){
                    $del = DB::table('users_system_roles')->where('users_system_roles_id', $req->id)->delete();
                    if($del){
                        Session::flash('success', ' Data Deleted successfully'); 
                        return redirect('admin/users_system_roles');
                    } else {
                        Session::flash('error', ' Oops! something went wrong'); 
                        return redirect('admin/users_system_roles');
                    }
                } else {
                    Session::flash('error', ' This role is assigned to some users. Delete the users first.'); 
                    return redirect('admin/users_system_roles');
                }
            } else {
                Session::flash('error', ' No Data Found'); 
                return redirect('admin/users_system_roles');
            }
        } else {
            return redirect('admin');
        }
    }
    // ------------- DELETE SYSTEM USERS ROLES -------------- //

    // ------------- MANAGE SYSTEM  ABOUT US -------------- //
    public function system_about_us(Request $request){
        if ($request->session()->has('id')) {
            $page_name = 'system_about_us';
            $system_settings = DB::table('system_settings')->get();
            return view('admin.system_about_us', compact('system_settings','page_name'));
        } else {
            return redirect('admin');
        }
    }
    // ------------- MANAGE SYSTEM ABOUT US -------------- //

    // ------------- MANAGE SYSTEM TERMS -------------- //
    public function system_terms(Request $request){
        if ($request->session()->has('id')) {
            $page_name = 'system_terms';
            $system_settings = DB::table('system_settings')->get();
            return view('admin.system_terms', compact('system_settings','page_name'));
        } else {
            return redirect('admin');
        }
    }
    // ------------- MANAGE SYSTEM TERMS -------------- //

    // ------------- MANAGE SYSTEM PRIVACY -------------- //
    public function system_privacy(Request $request){
        if ($request->session()->has('id')) {
            $page_name = 'system_privacy';
            $system_settings = DB::table('system_settings')->get();
            return view('admin.system_privacy', compact('system_settings','page_name'));
        } else {
            return redirect('admin');
        }
    }
    // ------------- MANAGE SYSTEM PRIVACY -------------- //

    
    // ------------- MANAGE USERS CUSTOMERS -------------- //
    public function users_customers_fetch(Request $req){
        if (session()->has('id')) {
            if(!$req->filter){
                $usersCustomers = DB::table('users_customers')->orderBy('users_customers_id', 'DESC')->get();
                $filter='';
            } else {
                $usersCustomers = DB::table('users_customers')->where('status', $req->filter)->orderBy('users_customers_id', 'DESC')->get();
                $filter = $req->filter;
            }

            return response()->json([
                'usersCustomers'=>$usersCustomers,
                'filter'=>$filter,
            ]);
        } else {
            return redirect('admin');
        }
    }
    // ------------- MANAGE USERS CUSTOMERS -------------- //

    // ------------- MANAGE USERS CUSTOMERS PAGE -------------- //
    public function users_customers(){
        if (session()->has('id')) {
            return view('admin.users_customers');
        } else {
            return redirect('admin');
        }
    }
    // ------------- MANAGE USERS CUSTOMERS PAGE -------------- //

    // ------------- UPDATE USERS CUSTOMERS -------------- //
    public function users_customer_update(Request $req){
        $update_array['status'] = $req->status; 
        $updated = DB::table('users_customers')->where('users_customers_id', $req->users_customers_id)->update($update_array);
            if ($updated) {
                $response["code"] = 200;
                $response["status"] = "success";
                $response["message"] = "Data Updated successfully";
           } else{
                $response["code"] = 404;
                $response["status"] = "error";
                $response["message"] = "Oops! Something went wrong.";
            }
      
          return response()
          ->json(array( 'status' => $response["status"], isset($response["message"]) ? 'message' : 'data' => isset($response["message"]) ? $response["message"] : $response["data"]))
          ->header('Content-Type', 'application/json');
    }
    // ------------- UPDATE USERS CUSTOMERS -------------- //

    // ------------- DELETE USERS CUSTOMERS -------------- //
    public function users_customer_delete(Request $req){
            if($req->users_customers_id){
                $checkdata = DB::table('users_customers')->where('users_customers_id', $req->users_customers_id)->where('status', '!=','Deleted')->first();

                if($checkdata){
                    $del=DB::table('users_customers')->where('users_customers_id', '=', $req->users_customers_id)->update(array( 'status' => 'Deleted'));
                    if($del){
                        $response["code"] = 200;
                        $response["status"] = "success";
                        $response["message"] = "Data Deleted successfully";
                    } else{
                        $response["code"] = 404;
                        $response["status"] = "error";
                        $response["message"] = "Oops! Something went wrong.";
                    }
                } else{
                    $response["code"] = 404;
                    $response["status"] = "error";
                    $response["message"] = "This record is already deleted in status.";
                }
            } else{
                $response["code"] = 404;
                $response["status"] = "error";
                $response["message"] = "No Data Found.";
            }
            return response()
          ->json(array( 'status' => $response["status"], isset($response["message"]) ? 'message' : 'data' => isset($response["message"]) ? $response["message"] : $response["data"]))
          ->header('Content-Type', 'application/json');
    }
    // ------------- DELETE USERS CUSTOMERS -------------- //
    
    // ------------- MANAGE USERS CUSTOMERS -------------- //
    public function users_customer_edit($id){
        if (session()->has('id')) {
            $page_name = 'users_customer_edit';
            $users_customer = DB::table('users_customers')->where('users_customers_id', $id)->first();
            if ($users_customer) {
                $response["code"] = 200;
                $response["status"] = "success";
                $response["data"] = $users_customer;
           } else{
                $response["code"] = 404;
                $response["status"] = "error";
                $response["message"] = "Data not found.";
            }
        } else{
            $response["code"] = 404;
            $response["status"] = "error";
            $response["message"] = "Oops! Something went wrong.";
        }
        return response()
          ->json(array( 'status' => $response["status"], isset($response["message"]) ? 'message' : 'data' => isset($response["message"]) ? $response["message"] : $response["data"]))
          ->header('Content-Type', 'application/json');
    }
    // ------------- MANAGE USERS CUSTOMERS -------------- //
    
    // ------------- MANAGE JOBS -------------- //
    public function jobs_fetch(Request $request){
        if (session()->has('id')) {
            if(empty($request->get('filter'))){
                $jobs = DB::table('jobs')->orderBy('jobs_id', 'DESC')->get();
                $filter='';
            } else {
                $jobs = DB::table('jobs')->where('status', $request->get('filter'))->orderBy('jobs_id', 'DESC')->get();
                $filter = $request->get('filter');
            }

            return response()->json([
                'jobs'=>$jobs,
                'filter'=>$filter,
            ]);
        } else {
            return redirect('admin');
        }
    }
    // ------------- MANAGE JOBS -------------- //

    // ------------- MANAGE JOBS PAGE -------------- //
    public function jobs(){
        if (session()->has('id')) {
            return view('admin.jobs');
        } else {
            return redirect('admin');
        }
    }
    // ------------- MANAGE JOBS PAGE -------------- //

    // ------------- UPDATE JOBS -------------- //
    public function job_update(Request $req){
        $update_array['status'] = $req->status; 
        $updated = DB::table('jobs')->where('jobs_id', $req->jobs_id)->update($update_array);
            if ($updated) {
                $response["code"] = 200;
                $response["status"] = "success";
                $response["message"] = "Data Updated successfully";
           } else{
                $response["code"] = 404;
                $response["status"] = "error";
                $response["message"] = "Oops! Something went wrong.";
            }
      
          return response()
          ->json(array( 'status' => $response["status"], isset($response["message"]) ? 'message' : 'data' => isset($response["message"]) ? $response["message"] : $response["data"]))
          ->header('Content-Type', 'application/json');
    }
    // ------------- UPDATE JOBS -------------- //

    // ------------- DELETE JOBS -------------- //
    public function job_delete(Request $req){
            if($req->jobs_id){
                $checkdata = DB::table('jobs')->where('jobs_id', $req->jobs_id)->where('status', '!=','Deleted')->first();

                if($checkdata){
                    $del=DB::table('jobs')->where('jobs_id', '=', $req->jobs_id)->update(array( 'status' => 'Deleted'));
                    if($del){
                        $response["code"] = 200;
                        $response["status"] = "success";
                        $response["message"] = "Data Deleted successfully";
                    } else{
                        $response["code"] = 404;
                        $response["status"] = "error";
                        $response["message"] = "Oops! Something went wrong.";
                    }
                } else{
                    $response["code"] = 404;
                    $response["status"] = "error";
                    $response["message"] = "This record is already deleted in status.";
                }
            } else{
                $response["code"] = 404;
                $response["status"] = "error";
                $response["message"] = "No Data Found.";
            }
            return response()
          ->json(array( 'status' => $response["status"], isset($response["message"]) ? 'message' : 'data' => isset($response["message"]) ? $response["message"] : $response["data"]))
          ->header('Content-Type', 'application/json');
    }
    // ------------- DELETE JOBS -------------- //
    
    // ------------- MANAGE JOBS -------------- //
    public function job_edit($id){
        if (session()->has('id')) {
            $page_name = 'job_edit';
            $job = DB::table('jobs')->where('jobs_id', $id)->first();
            if ($job) {
                $response["code"] = 200;
                $response["status"] = "success";
                $response["data"] = $job;
           } else{
                $response["code"] = 404;
                $response["status"] = "error";
                $response["message"] = "Data not found.";
            }
        } else{
            $response["code"] = 404;
            $response["status"] = "error";
            $response["message"] = "Oops! Something went wrong.";
        }
        return response()
          ->json(array( 'status' => $response["status"], isset($response["message"]) ? 'message' : 'data' => isset($response["message"]) ? $response["message"] : $response["data"]))
          ->header('Content-Type', 'application/json');
    }
    // ------------- MANAGE JOBS -------------- //

    
    // ------------- MANAGE USERS CUSTOMERS DELETE REQUESTS PAGE -------------- //
    public function users_customers_del_req(){
        if (session()->has('id')) {
            return view('admin.users_customers_del_req');
        } else {
            return redirect('admin');
        }
    }
    // ------------- MANAGE USERS CUSTOMERS DELETE REQUESTS PAGE -------------- //

      // ------------- MANAGE USERS CUSTOMERS -------------- //
      public function users_customers_del_req_fetch(Request $req){
        if (session()->has('id')) {
            if(!$req->filter){
                $usersCustomers = DB::table('users_customers_delete')->orderBy('users_customers_delete_id', 'DESC')->get();
                $filter='';
            } else {
                $usersCustomers = DB::table('users_customers_delete')->where('status', $req->filter)->orderBy('users_customers_delete_id', 'DESC')->get();
                $filter = $req->filter;
            }

            return response()->json([
                'usersCustomers'=>$usersCustomers,
                'filter'=>$filter,
            ]);
        } else {
            return redirect('admin');
        }
    }
    // ------------- MANAGE USERS CUSTOMERS -------------- //

    // ------------- UPDATE USERS CUSTOMERS DELETE REQUESTS -------------- //
    public function users_customer_update_del_req(Request $req){
        $update_array['status'] = $req->status; 
        if($req->status=="Approved"){
            $user = DB::table('users_customers_delete')->where('users_customers_delete_id', $req->users_customers_delete_id)->first();
            $updated_UserAccount = DB::table('users_customers')->where('email', $user->email)->update(["status"=>"Deleted"]);
        }
        $updated = DB::table('users_customers_delete')->where('users_customers_delete_id', $req->users_customers_delete_id)->update($update_array);
            if ($updated) {
                $response["code"] = 200;
                $response["status"] = "success";
                $response["message"] = "Data Updated successfully";
           } else{
                $response["code"] = 404;
                $response["status"] = "error";
                $response["message"] = "Oops! Something went wrong.";
            }
      
          return response()
          ->json(array( 'status' => $response["status"], isset($response["message"]) ? 'message' : 'data' => isset($response["message"]) ? $response["message"] : $response["data"]))
          ->header('Content-Type', 'application/json');
    }
    // ------------- UPDATE USERS CUSTOMERS DELETE REQUESTS -------------- //

}
<?php
use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/* ----------------------------------- WEB API PANEL --------------------------------------------- */
Route::get('/clear', function() {
    // $exitCode = Artisan::call('route:list');
    // echo 'Routes cache cleared'; echo "<br>";
    // exit;
    
    //$exitCode = Artisan::call('route:cache');
    //echo 'Routes cache cleared'; echo "<br>";

    $exitCode = Artisan::call('route:clear');
    echo 'Routes cache cleared'; echo "<br>";
     
    $exitCode = Artisan::call('config:cache');
    echo 'Config cache cleared'; echo "<br>";
    
    $exitCode = Artisan::call('cache:clear');
    echo 'Application cache cleared';  echo "<br>";
    
    $exitCode = Artisan::call('view:clear');
    echo 'View cache cleared';  echo "<br>";

    // $Command = Artisan::call('make:middleware Cors');
    Session::flash('message', 'Cache Cleared!'); 
    Session::flash('alert-class', 'alert-danger'); 
    return redirect('/admin/dashboard');
});

//USER AUTHENTICATION
Route::post('/signin', [ApiController::class, 'users_customers_login']);
Route::post('/signup', [ApiController::class, 'users_customers_signup']);
Route::post('/update_profile', [ApiController::class, 'update_profile']);
Route::post('/email_exist', [ApiController::class, 'email_exist']);
Route::post('/forgot_password', [ApiController::class, 'forgot_password']);
Route::post('/modify_my_password', [ApiController::class, 'modify_my_password']);

Route::post('/change_my_password', [ApiController::class, 'change_my_password']);
Route::post('/delete_account', [ApiController::class, 'delete_account']);
//USER AUTHENTICATION

//LIVE CHAT MESSAGES
Route::post('/getAllChatLive', [ApiController::class, 'getAllChatLive']);
Route::post('/user_chat_live', [ApiController::class, 'user_chat_live']);
Route::get('/get_admin_list', [ApiController::class, 'get_admin_list']);
//LIVE CHAT MESSAGES

//USER CHAT MESSAGES
Route::post('/unreaded_messages', [ApiController::class, 'unreaded_messages']);
Route::post('/getAllChat', [ApiController::class, 'getAllChat']);
Route::post('/user_chat', [ApiController::class, 'user_chat']);
//USER CHAT MESSAGES

//GET NOTIFICATIONS
Route::post('/notifications', [ApiController::class, 'notifications']);
Route::post('/notifications_unread', [ApiController::class, 'notifications_unread']);
Route::post('/messages_permission', [ApiController::class, 'messages_permission']);
Route::post('/notification_permission', [ApiController::class, 'notification_permission']);
//GET NOTIFICATIONS

//GET DATA
Route::post('/users_customers_profile', [ApiController::class, 'users_customers_profile']);
Route::get('/system_settings', [ApiController::class, 'system_settings'])->name('system_settings');
Route::post('/all_users', [ApiController::class, 'all_users']);  
Route::post('/all_users_suggested', [ApiController::class, 'all_users_suggested']);  
Route::get('/all_currencies', [ApiController::class, 'all_currencies']);
Route::get('/all_countries', [ApiController::class, 'all_countries']);
//GET DATA

//JOBS
Route::post('/jobs_price', [ApiController::class, 'jobs_price']);
Route::post('/jobs_create', [ApiController::class, 'jobs_create']);
Route::post('/jobs_edit', [ApiController::class, 'jobs_edit']);
//JOBS

//GET JOBS CUSTOMERS
Route::post('/get_pending_jobs', [ApiController::class, 'get_pending_jobs']);
Route::post('/get_ongoing_jobs', [ApiController::class, 'get_ongoing_jobs']);
Route::post('/get_previous_jobs', [ApiController::class, 'get_previous_jobs']);
Route::post('/search_jobs_customers', [ApiController::class, 'search_jobs_customers']);
Route::post('/customer_editable_jobs', [ApiController::class, 'customer_editable_jobs']);
//GET JOBS CUSTOMERS

//GET JOBS EMPLOYEE
Route::post('/get_jobs_employees', [ApiController::class, 'get_jobs_employees']);
Route::post('/jobs_action_employees', [ApiController::class, 'jobs_action_employees']);
Route::post('/get_ongoing_jobs_employees', [ApiController::class, 'get_ongoing_jobs_employees']);
Route::post('/search_jobs_employees', [ApiController::class, 'search_jobs_employees']);
Route::post('/get_previous_jobs_employees', [ApiController::class, 'get_previous_jobs_employees']);
Route::post('/employee_arrived', [ApiController::class, 'employee_arrived']);
//GET JOBS EMPLOYEE

//COMPLETE JOBS CUSTOMERS
Route::post('/jobs_customers_complete', [ApiController::class, 'jobs_customers_complete']);
//COMPLETE JOBS CUSTOMERS

//JOBS EXTRA AMOUNT
Route::post('/jobs_extra_amount', [ApiController::class, 'jobs_extra_amount']);
//JOBS EXTRA AMOUNT

//JOBS COMPLETE WITHOUT EXTRA TIME
Route::post('/jobs_complete_without_extra_time', [ApiController::class, 'jobs_complete_without_extra_time']);
//JOBS COMPLETE WITHOUT EXTRA TIME

//TXN
Route::post('/customer_wallet_txn', [ApiController::class, 'customer_wallet_txn']);
Route::post('/job_creation_payment', [ApiController::class, 'job_creation_payment']);
Route::post('/employee_wallet_txn', [ApiController::class, 'employee_wallet_txn']);
//TXN

//JOB RATING
Route::post('/add_job_rating', [ApiController::class, 'add_job_rating']);
Route::post('/all_ratings', [ApiController::class, 'all_ratings']);
//JOB RATING

//JOB RADIUS
Route::post('/update_job_radius', [ApiController::class, 'update_job_radius']);
//JOB RADIUS
/* ----------------------------------- WEB API PANEL --------------------------------------------- */
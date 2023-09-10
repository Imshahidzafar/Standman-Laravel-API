<?php
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UsersController;

use Illuminate\Http\Request;
use App\Helpers\Helper;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/* ----------------------------------- WEB PANEL --------------------------------------------- */
// SIGNIN ADMIN
Route::get('/', [AdminController::class, 'index']);
// SIGNIN ADMIN
/* ----------------------------------- WEB PANEL --------------------------------------------- */

/* ----------------------------------- ADMIN PANEL --------------------------------------------- */
// Base Authentication Routes
Route::get('/admin', [AdminController::class, 'index']);
Route::get('/admin/clear_cache', [AdminController::class, 'clear_cache']);

Route::post('/admin/login', [AdminController::class, 'login']);
Route::get('/admin/logout', [AdminController::class, 'logout']);
// Base Authentication Routes

// DASHBOARD
Route::get('/admin/dashboard', [AdminController::class, 'Dashboard']);
// DASHBOARD


// USERS CUSTOMERS
Route::get('/admin/users_customers', [AdminController::class, 'users_customers'])->name('users_customers');
Route::get('/admin/users_customers_fetch', [AdminController::class, 'users_customers_fetch'])->name('users_customers_fetch');
Route::post('/admin/users_customer_update', [AdminController::class, 'users_customer_update'])->name('users_customer_update');
Route::post('/admin/users_customer_delete', [AdminController::class, 'users_customer_delete'])->name('users_customer_delete');
Route::get('/admin/users_customer_edit/{id}', [AdminController::class, 'users_customer_edit'])->name('users_customer_edit');
// USERS CUSTOMERS

//SUPPORT MANAGEMENT
Route::get('/admin/support', [AdminController::class, 'support']);
//SUPPORT MANAGEMENT

// USERS SYSTEM
Route::get('/admin/users_system', [AdminController::class, 'users_system']);
Route::get('/admin/users_system_update/{id}/{status}', [AdminController::class, 'users_system_update'])->name('users_system_update');
Route::get('/admin/users_system_delete/{id}', [AdminController::class, 'users_system_delete'])->name('users_system_delete');

Route::get('/admin/users_system_add', [AdminController::class, 'users_system_add']);
Route::post('/admin/users_system_add_data', [AdminController::class, 'users_system_add_data'])->name('users_system_add_data');

Route::get('/admin/users_system_edit/{id}', [AdminController::class, 'users_system_edit'])->name('users_system_edit');
Route::post('/admin/users_system_edit_data', [AdminController::class, 'users_system_edit_data'])->name('users_system_edit_data');
// USERS SYSTEM

// USERS SYSTEM
Route::get('/admin/users_system_roles', [AdminController::class, 'users_system_roles']);
Route::get('/admin/users_system_roles_delete/{id}', [AdminController::class, 'users_system_roles_delete'])->name('users_system_roles_delete');

Route::get('/admin/users_system_roles_add', [AdminController::class, 'users_system_roles_add']);
Route::post('/admin/users_system_roles_add_data', [AdminController::class, 'users_system_roles_add_data'])->name('users_system_roles_add_data');

Route::get('/admin/users_system_roles_edit/{id}', [AdminController::class, 'users_system_roles_edit'])->name('users_system_roles_edit');
Route::post('/admin/users_system_roles_edit_data', [AdminController::class, 'users_system_roles_edit_data'])->name('users_system_roles_edit_data');
// USERS SYSTEM

//Start GENERAl Settings
Route::get('/admin/account_settings', [AdminController::class, 'account_settings']);
Route::post('/admin/account_settings_update/{id}', [AdminController::class, 'account_settings_update'])->name('account_settings_update');

Route::get('/admin/system_settings', [AdminController::class, 'system_settings']);
Route::post('/admin/system_settings_edit', [AdminController::class, 'system_settings_edit']);

Route::get('/admin/system_about_us', [AdminController::class, 'system_about_us']);
Route::get('/admin/system_terms', [AdminController::class, 'system_terms']);
Route::get('/admin/system_privacy', [AdminController::class, 'system_privacy']);
//End GENERAl Settings

// JOBS
Route::get('/admin/jobs', [AdminController::class, 'jobs'])->name('jobs');
Route::get('/admin/jobs_fetch', [AdminController::class, 'jobs_fetch'])->name('jobs_fetch');
Route::post('/admin/job_update', [AdminController::class, 'job_update'])->name('job_update');
Route::post('/admin/job_delete', [AdminController::class, 'job_delete'])->name('job_delete');
Route::get('/admin/job_edit/{id}', [AdminController::class, 'job_edit'])->name('job_edit');
// JOBS

//USERS CUSTOMERS DELETE REQUESTS
Route::get('/admin/users_customers_del_req', [AdminController::class, 'users_customers_del_req'])->name('users_customers_del_req');
Route::get('/admin/users_customers_del_req_fetch', [AdminController::class, 'users_customers_del_req_fetch'])->name('users_customers_del_req_fetch');
Route::get('/admin/users_customer_update_del_req', [AdminController::class, 'users_customer_update_del_req'])->name('users_customer_update_del_req');
//USERS CUSTOMERS DELETE REQUESTS

/* ----------------------------------- ADMIN PANEL --------------------------------------------- */
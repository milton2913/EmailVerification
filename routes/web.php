<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\PermissionsController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\AuditLogsController;
use App\Http\Controllers\Auth\ChangePasswordController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\GlobalSearchController;
use App\Http\Controllers\Admin\ValidEmailsController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\Buyer\BuyerDashboardController;
use App\Http\Controllers\Buyer\BulkController;
use App\Http\Controllers\Admin\PackagesController;
use App\Http\Controllers\Admin\PurchasesController;
use App\Http\Controllers\Admin\BenefitsController;
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
Auth::routes(['register' => false]);

Route::get('/test',[TestController::class,'index'])->name('test-email');

Route::get('/email-verify', function () {
    return view('layouts.master');
});

Route::post('/email-verify',[HomeController::class,'emailVerifyForm'])->name('email-verify');




//Route::post('/email-verify', [HomeController::class,'emailVerifyForm'])->name('email-verify');



Route::get('/php-info', function() {
    echo phpinfo();
});

Route::get('/update-verify-emails', [HomeController::class,'newJobs']);

Route::get('/email', [HomeController::class, 'verify']);
Route::get('/privacy-policy',function (){
    return view('privacy-policy');
});
Route::get('/terms-condition',function (){
    return view('terms-condition');
});


Route::redirect('/', '/login');
Route::get('/home', function () {
    if (session('status')) {
        return redirect()->route('admin.home')->with('status', session('status'));
    }
    return redirect()->route('admin.home');
});


//customer/buyer controller
Route::get('overview', [BuyerDashboardController::class,'overview'])->name('buyer.overview');
Route::post('singleVerify', [BuyerDashboardController::class,'singleVerify'])->name('buyer.singleVerify');
Route::get('bulk-verify', [BulkController::class,'bulkVerifyForm'])->name('buyer.bulkVerifyForm');
Route::post('bulk-verify', [BulkController::class,'bulkVerify'])->name('buyer.bulkVerify');
Route::get('/bulk-verify-process/{id}/{bulk_type}', [BulkController::class,'startVerify'])->name('buyer.startVerify');
Route::get('/list-of-tasks', [BulkController::class,'listOfTask'])->name('buyer.listOfTask');
Route::get('/tasks-reports/{id}', [BulkController::class,'tasksReport'])->name('buyer.tasksReport');
Route::get('/tasks-emails/{id}', [BulkController::class,'tasksEmails'])->name('buyer.tasksEmails');


Route::get('students/certificate', [StudentController::class,'certificate']);
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth']], function () {

    //admin controller
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::resources([
        'permissions' => PermissionsController::class,
        'roles' => RolesController::class,
        'users' => UsersController::class,
        'valid-emails' => ValidEmailsController::class,
        'packages' => PackagesController::class,
        'benefits' => BenefitsController::class,

    ]);
    // Packages
    Route::delete('packages/destroy',  [PackagesController::class,'massDestroy'])->name('packages.massDestroy');
    // Purchases
    Route::resources(['purchases' => PurchasesController::class], ['except' => ['destroy']]);

    // Benefits
    Route::delete('benefits/destroy',  [BenefitsController::class,'massDestroy'])->name('benefits.massDestroy');
    // Valid Emails
    Route::delete('valid-emails/destroy',  [ValidEmailsController::class,'massDestroy'])->name('valid-emails.massDestroy');
    Route::post('valid-emails/parse-csv-import',  [ValidEmailsController::class,'parseCsvImport'])->name('valid-emails.parseCsvImport');
    Route::post('valid-emails/process-csv-import',  [ValidEmailsController::class,'processCsvImport'])->name('valid-emails.processCsvImport');

    // Permissions
    Route::delete('permissions/destroy', [PermissionsController::class,'massDestroy'])->name('permissions.massDestroy');
    // Roles
    Route::delete('roles/destroy', [RolesController::class, 'massDestroy'])->name('roles.massDestroy');
    // Users
    Route::delete('users/destroy', [UsersController::class,'massDestroy'])->name('users.massDestroy');
    // Audit Logs
    Route::resource('audit-logs', AuditLogsController::class, ['except' => ['create', 'store', 'edit', 'update', 'destroy']]);
    //    Route::resources(['permissions' => SettingsController::class],['except' => ['create', 'store', 'show', 'destroy']]);
    Route::post('settings/media', [SettingsController::class, 'storeMedia'])->name('settings.storeMedia');
    Route::post('settings/ckmedia', [SettingsController::class, 'storeCKEditorImages'])->name('settings.storeCKEditorImages');
    Route::get('settings', [SettingsController::class, 'edit'])->name('settings.edit');
    Route::put('settings', [SettingsController::class, 'update'])->name('settings.update');
//global search controller
    Route::get('global-search', [GlobalSearchController::class,'search'])->name('globalSearch');
});

Route::group(['prefix' => 'profile', 'as' => 'profile.', 'middleware' => ['auth']], function () {
    // Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', [ChangePasswordController::class,'edit'])->name('password.edit');
        Route::post('password', [ChangePasswordController::class,'update'])->name('password.update');
        Route::post('profile', [ChangePasswordController::class,'updateProfile'])->name('password.updateProfile');
        Route::post('profile/destroy', [ChangePasswordController::class,'destroy'])->name('password.destroyProfile');
        Route::get('/edit',[ProfileController::class,'edit'])->name('edit');
        Route::post('/edit',[ProfileController::class,'updateProfile'])->name('updateProfile');
    }
});








Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/htest',[App\Http\Controllers\HomeController::class,'htest'])->name('htest');

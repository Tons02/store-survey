<?php

use Illuminate\Http\Request;
use App\Models\RoleManagement;
use App\Http\Resources\RoleResource;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\LocationController;
use App\Http\Controllers\Api\CompaniesController;
use App\Http\Controllers\Api\ObjectiveController;
use App\Http\Controllers\Api\DepartmentController;
use App\Http\Controllers\Api\RoleManagementController;
use App\Http\Controllers\Api\StoreEngagementFormsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/




Route::group(["middleware" => ["auth:sanctum"]], function () {

//Role Controller
Route::resource("role", RoleManagementController::class);
Route::put('role-archived/{id}',[RoleManagementController::class,'archived']);

//Users Controller
Route::resource("users", UserController::class);
Route::put('user-archived/{id}',[UserController::class,'archived']);

//Auth Controller
Route::patch('changepassword',[AuthController::class,'changedPassword']);
Route::patch('resetpassword/{id}',[AuthController::class,'resetPassword']);
Route::patch('changepassword',[AuthController::class,'changedPassword']);
Route::post('logout',[AuthController::class,'logout']);
   
//Companies Controller
Route::resource("companies", CompaniesController::class);
Route::post('sync_companies',[CompaniesController::class,'sync_companies']);

//Department Controller
Route::resource("department", DepartmentController::class);
Route::post('sync_department',[DepartmentController::class,'sync_department']);

//Location Controller
Route::resource("location", LocationController::class);
Route::post('sync_location',[LocationController::class,'sync_location']);

//Store Engagment Form 
Route::resource("seforms", StoreEngagementFormsController::class);
Route::post('seforms-followup/{id}',[StoreEngagementFormsController::class,'followup']);
Route::put('seforms-archived/{id}',[StoreEngagementFormsController::class,'archived']);

//Location Controller
Route::resource("objective", ObjectiveController::class);

});

Route::post('login',[AuthController::class,'login']);

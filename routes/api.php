<?php

use Illuminate\Http\Request;
use App\Models\RoleManagement;
use App\Http\Resources\RoleResource;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\LocationController;
use App\Http\Controllers\Api\CompaniesController;
use App\Http\Controllers\Api\DepartmentController;
use App\Http\Controllers\Api\RoleManagementController;

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

Route::resource("role", RoleManagementController::class);
Route::put('role-archived/{id}',[RoleManagementController::class,'archived']);

Route::resource("users", UserController::class);
Route::put('user-archived/{id}',[UserController::class,'archived']);

Route::patch('resetpassword/{id}',[AuthController::class,'resetPassword']);
Route::patch('changepassword',[AuthController::class,'changedPassword']);
Route::post('logout',[AuthController::class,'logout']);
   

Route::resource("companies", CompaniesController::class);
Route::post('sync_companies',[CompaniesController::class,'sync_companies']);

Route::resource("department", DepartmentController::class);
Route::post('sync_department',[DepartmentController::class,'sync_department']);

Route::resource("location", LocationController::class);
Route::post('sync_location',[LocationController::class,'sync_location']);

});

Route::post('login',[AuthController::class,'login']);
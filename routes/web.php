<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\kasController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\AuthenticationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'admin'], function () {

    Route::get('/login', [AuthenticationController::class, 'index'])->name('admin.login');
    Route::post('/login', [AuthenticationController::class, 'login_proses'])->name('admin.login.proses');
    Route::get('/logout', [AuthenticationController::class, 'logout'])->name('admin.logout');

        Route::middleware(['auth.admin'])->group(function () {
        // Dashboard
        Route::get('dashboard',[DashboardController::class,'index'])->name('admin.dashboard');
    
        // Users
        Route::get('users',[UserController::class,'index'])->name('admin.users');
        Route::get('users/getdata',[UserController::class,'getdata'])->name('admin.users.getdata');
        Route::get('users/add',[UserController::class,'add'])->name('admin.users.add');
        Route::post('users/uploadImage',[UserController::class,'uploadImage'])->name('admin.users.uploadImage');
        Route::post('users/save',[UserController::class,'save'])->name('admin.users.save');
        Route::get('users/edit/{id}',[UserController::class,'edit'])->name('admin.users.edit');
        Route::put('users/update/{id}',[UserController::class,'update'])->name('admin.users.update');
        Route::delete('users/delete',[UserController::class,'delete'])->name('admin.users.delete');
        Route::get('users/detail/{id}',[UserController::class,'detail'])->name('admin.users.detail');
        Route::post('users/isExistKode',[UserController::class,'isExistKode'])->name('admin.users.isExistKode');
        Route::post('users/isExistEmail',[UserController::class,'isExistEmail'])->name('admin.users.isExistEmail');
    
        // Kas
        Route::get('kas',[kasController::class,'index'])->name('admin.kas.index');
        Route::get('kas/getdata',[kasController::class,'getdata'])->name('admin.kas.getdata');
        Route::get('kas/add',[kasController::class,'add'])->name('admin.kas.add');
        Route::post('kas/save',[kasController::class,'save'])->name('admin.kas.save');
        Route::get('kas/edit/{id}',[kasController::class,'edit'])->name('admin.kas.edit');
        Route::post('kas/update/{id}',[kasController::class,'update'])->name('admin.kas.update');
        Route::get('kas/delete/{id}',[kasController::class,'delete'])->name('admin.kas.delete');
    });
});
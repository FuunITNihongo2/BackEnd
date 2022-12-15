<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\HomeController;
use App\Http\Controllers\API\BoothController;
use App\Http\Controllers\API\ItemController;
use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\API\UserController;
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

Route::controller(AuthController::class)->group(function(){
    Route::get('/allUser', 'getUsers');
    Route::post('login', 'login');
    Route::get('accept/{token}', 'accept')->name('accept');
});

Route::group(['middleware' => ['auth:sanctum']], function() {    
    Route::post('logout',   [AuthController::class, 'logout'])->name('user.logout');
    Route::get('profile', [AuthController::class,'show'])->name('user.show');
    Route::put('profile',   [AuthController::class, 'editProfile'])->name('user.edit');
    Route::delete('profile/{user}',   [AuthController::class, 'deleteProfile'])->name('user.delete');
    Route::post('invite', [AuthController::class, 'invite'])->name('user.invite');
    Route::delete('item/{item}', [ItemController::class,'destroy'])->name('item.delete');
    Route::post('booth', [BoothController::class,'store'])->name('booth.store');
    Route::post('booth/{booth}/owner', [BoothController::class,'changeOwner'])->name('booth.changeOwner');
    Route::post('booth/{booth}/state', [BoothController::class,'changeState'])->name('booth.changeState');
  });

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('home', HomeController::class);
Route::get('v2/home', [HomeController::class,'index_v2']);
// Route::resource('booth', BoothController::class);
Route::post('accepted', [AuthController::class,'accept'])->name('user.accept');
Route::get('booth', [BoothController::class,'index'])->name('booth.index');
Route::get('booth/{booth}', [BoothController::class,'show'])->name('booth.show');
Route::put('booth/{booth}', [BoothController::class,'update'])->name('booth.update');
Route::get('booth/{booth}/item', [BoothController::class,'showItem'])->name('booth.item');
Route::delete('booth/{booth}', [BoothController::class,'destroy'])->name('booth.delete');
Route::post('item', [ItemController::class,'store'])->middleware('auth:sanctum')->name('item.store');
Route::get('item', [ItemController::class,'index'])->name('item.index');
Route::get('item/{item}', [ItemController::class,'show'])->name('item.show');
Route::put('item/{item}', [ItemController::class,'update'])->name('item.update');

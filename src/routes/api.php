<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\HomeController;
use App\Http\Controllers\API\BoothController;
use App\Http\Controllers\API\ItemController;
use App\Http\Controllers\API\RegisterController;

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
    Route::post('invite', 'invite')->name('invite');
    Route::get('accept/{token}', 'accept')->name('accept');
});

Route::group(['middleware' => ['auth:sanctum']], function() {    
    Route::post('logout',   [AuthController::class, 'logout']);
  });

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('home', HomeController::class);
// Route::resource('booth', BoothController::class);
Route::get('booth', [BoothController::class,'index'])->name('booth.index');
Route::get('booth/{booth}', [BoothController::class,'show'])->name('booth.show');
Route::put('booth/{booth}', [BoothController::class,'update'])->name('booth.update');
Route::get('booth/{booth}/item', [BoothController::class,'showItem'])->name('booth.item');
Route::post('item', [ItemController::class,'store'])->middleware('auth:sanctum')->name('item.store');

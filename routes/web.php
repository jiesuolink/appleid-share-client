<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShareController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Apple ID 分享演示页面路由
|
*/

// Apple ID 分享页面
Route::get('/share/appleid', [ShareController::class, 'showAppleId'])
    ->name('share.appleid');

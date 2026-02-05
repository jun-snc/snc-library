<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GenreController;
use App\Http\Controllers\Admin\ImageController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Graphic\HomeController as GraphicHomeController;
use App\Http\Controllers\Graphic\Api\ImageController as GraphicApiImageController;
use App\Http\Controllers\Spatial\HomeController as SpatialHomeController;
use App\Http\Controllers\Spatial\Api\ImageController as SpatialApiImageController;

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

// グラフィックデザイン公開画面
Route::prefix('graphic')->group(function () {
    Route::get('/', [GraphicHomeController::class, 'index'])->name('graphic.index');
    Route::get('/api/images', [GraphicApiImageController::class, 'index'])->name('graphic.api.images.index');
    Route::get('/api/images/{image}', [GraphicApiImageController::class, 'show'])->name('graphic.api.images.show');
});

// 空間デザイン公開画面
Route::prefix('spatial')->group(function () {
    Route::get('/', [SpatialHomeController::class, 'index'])->name('spatial.index');
    Route::get('/api/images', [SpatialApiImageController::class, 'index'])->name('spatial.api.images.index');
    Route::get('/api/images/{image}', [SpatialApiImageController::class, 'show'])->name('spatial.api.images.show');
});

// 管理画面 - 認証
Route::prefix('admin')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AuthController::class, 'login'])->name('admin.login.post');
    Route::post('/logout', [AuthController::class, 'logout'])->name('admin.logout');

    // 認証が必要なルート
    Route::middleware(['admin.auth'])->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');

        // ライブラリタイプごとのルート
        Route::prefix('{libraryType}')->whereIn('libraryType', ['graphic', 'spatial'])->group(function () {
            // ジャンル管理
            Route::resource('genres', GenreController::class)->except(['show'])->names([
                'index' => 'admin.genres.index',
                'create' => 'admin.genres.create',
                'store' => 'admin.genres.store',
                'edit' => 'admin.genres.edit',
                'update' => 'admin.genres.update',
                'destroy' => 'admin.genres.destroy',
            ]);

            // タグ管理
            Route::resource('tags', TagController::class)->except(['show'])->names([
                'index' => 'admin.tags.index',
                'create' => 'admin.tags.create',
                'store' => 'admin.tags.store',
                'edit' => 'admin.tags.edit',
                'update' => 'admin.tags.update',
                'destroy' => 'admin.tags.destroy',
            ]);

            // 画像管理
            Route::resource('images', ImageController::class)->except(['show'])->names([
                'index' => 'admin.images.index',
                'create' => 'admin.images.create',
                'store' => 'admin.images.store',
                'edit' => 'admin.images.edit',
                'update' => 'admin.images.update',
                'destroy' => 'admin.images.destroy',
            ]);
        });
    });
});

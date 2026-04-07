<?php

use App\Http\Controllers\RoleController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\SiteSettingController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PrinterController;
use App\Models\Post;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use \Illuminate\Http\Request;

Route::get('/', action: function () {
    return view('home');
}) -> name('index');
Auth::routes();

//Optionals: Save Theme on reload
Route::post('/theme-set', function(Request $request){
    $request->validate([
        'theme' => 'required|in:light,dark'
    ]);
    session(['theme' => $request->theme]);
    return response()->json(['theme' => session('theme')]);
})->name('theme-set');

// Route::get('login', [HomeController::class, 'login']) -> name('login');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Roles
Route::get('role-index', [RoleController::class, 'index']) -> name('role.index');
Route::get('role-create', [RoleController::class, 'create']) -> name('role.create');
Route::post('role-store', [RoleController::class, 'store']) -> name('role.store');
Route::get('role-edit/{id}', [RoleController::class, 'edit']) -> name('role.edit');
Route::put('role-update/{id}', [RoleController::class, 'update']) -> name('role.update');
Route::get('role-destroy/{id}', [RoleController::class, 'destroy']) -> name('role.delete');

//Menus
Route::get('menu-index', [MenuController::class, 'index']) -> name('menu.index');
Route::get('menu-create', [MenuController::class, 'create']) -> name('menu.create');
Route::post('menu-store', [MenuController::class, 'store']) -> name('menu.store');
Route::get('menu-edit/{id}', [MenuController::class, 'edit']) -> name('menu.edit');
Route::put('menu-update/{id}', [MenuController::class, 'update']) -> name('menu.update');
Route::get('menu-destroy/{id}', [MenuController::class, 'destroy']) -> name('menu.delete');

//Site Settings
Route::get('sites-index', [SiteSettingController::class, 'index']) -> name('site.index');
Route::get('sites-create', [SiteSettingController::class, 'create']) -> name('site.create');
Route::post('sites-store', [SiteSettingController::class, 'store']) -> name('site.store');
Route::get('sites-edit/{id}', [SiteSettingController::class, 'edit']) -> name('site.edit');
Route::put('sites-update/{id}', [SiteSettingController::class, 'update']) -> name('site.update');
Route::get('sites-destroy/{id}', [SiteSettingController::class, 'destroy']) -> name('site.delete');

//Posts
Route::get('posts-index', [PostController::class, 'index']) -> name('post.index');
Route::get('posts-create', [PostController::class, 'create']) -> name('post.create');
Route::post('posts-store', [PostController::class, 'store']) -> name('post.store');
Route::get('posts-edit/{id}', [PostController::class, 'edit']) -> name('post.edit');
Route::put('posts-update/{id}', [PostController::class, 'update']) -> name('post.update');
Route::delete('posts-destroy/{id}', [PostController::class, 'destroy']) -> name('post.delete');

//Banners
Route::get('banners-index', [BannerController::class, 'index']) -> name('banner.index');
Route::get('banners-create', [BannerController::class, 'create']) -> name('banner.create');
Route::post('banners-store', [BannerController::class, 'store']) -> name('banner.store');
Route::get('banners-edit/{id}', [BannerController::class, 'edit']) -> name('banner.edit');
Route::put('banners-update/{id}', [BannerController::class, 'update']) -> name('banner.update');
Route::get('banners-destroy/{id}', [BannerController::class, 'destroy']) -> name('banner.delete');

//Users
Route::get('users-index', [UserController::class, 'index']) -> name('user.index');
Route::get('users-create', [UserController::class, 'create']) -> name('user.create');
Route::post('users-store', [UserController::class, 'store']) -> name('user.store');
Route::get('users-edit/{id}', [UserController::class, 'edit']) -> name('user.edit');
Route::put('users-update/{id}', [UserController::class, 'update']) -> name('user.update');
Route::get('users-destroy/{id}', [UserController::class, 'destroy']) -> name('user.delete');
// Route::resource('roles', 'RoleController');

//Test test
Route::get('/test-print', [PrinterController::class, 'printReceipt']) -> name('test.print');
<?php

use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\CartController as AdminCartController;
use App\Http\Controllers\Admin\MainController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\UploadController;
use App\Http\Controllers\Admin\Users\LoginController;
use App\Http\Controllers\BlogController as ControllersBlogController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\MainController as ControllersMainController;
use App\Http\Controllers\MenuController as ControllersMenuController;
use App\Http\Controllers\ProductController as ControllersProductController;
use Illuminate\Support\Facades\Route;

Route::get('admin/users/login', [LoginController::class, 'index'])->name('login');
Route::post('admin/users/login/store', [LoginController::class, 'store']);

Route::middleware(['auth'])->group(function () {

    Route::prefix('admin')->group(function () {
        Route::get('/', [MainController::class, 'index'])->name('admin');
        Route::get('main', [MainController::class, 'index']);

        #menu
        Route::prefix('menus')->group(function () {
            Route::get('add', [MenuController::class, 'create']);
            Route::post('add', [MenuController::class, 'store']);
            Route::get('list', [MenuController::class, 'index']);
            Route::delete('destroy', [MenuController::class, 'destroy']);
            Route::get('edit/{menu}', [MenuController::class, 'show']);
            Route::post('edit/{menu}', [MenuController::class, 'update']);
        });

        #Product
        Route::prefix('products')->group(function () {
            Route::get('add', [ProductController::class, 'create']);
            Route::post('add', [ProductController::class, 'store']);
            Route::get('list', [ProductController::class, 'index']);
            Route::get('edit/{product}', [ProductController::class, 'show']);
            Route::post('edit/{product}', [ProductController::class, 'update']);
            Route::delete('destroy', [ProductController::class, 'destroy']);
        });

        #Blog
        Route::prefix('blogs')->group(function () {
            Route::get('add', [BlogController::class, 'create']);
            Route::post('add', [BlogController::class, 'store']);
            Route::get('list', [BlogController::class, 'index']);
            Route::get('edit/{blog}', [BlogController::class, 'show']);
            Route::post('edit/{blog}', [BlogController::class, 'update']);
            Route::delete('destroy', [BlogController::class, 'destroy']);
        });

        #Upload
        Route::post('upload/services', [UploadController::class, 'store']);

        #Slider
        Route::prefix('sliders')->group(function () {
            Route::get('add', [SliderController::class, 'create']);
            Route::post('add', [SliderController::class, 'store']);
            Route::get('list', [SliderController::class, 'index']);
            Route::get('edit/{slider}', [SliderController::class, 'show']);
            Route::post('edit/{slider}', [SliderController::class, 'update']);
            Route::delete('destroy', [SliderController::class, 'destroy']);
        });

        #Cart
        Route::get('customers', [AdminCartController::class, 'index']);
        Route::get('customers/view/{customer}', [AdminCartController::class, 'show']);
    });
});

Route::get('/', [ControllersMainController::class, 'index']);

Route::post('/services/load-product', [ControllersMainController::class, 'loadProduct']);

Route::get('/danh-muc/{id}-{slug}.html', [ControllersMenuController::class, 'index']);
Route::get('/san-pham/{id}-{slug}.html', [ControllersProductController::class, 'index']);

Route::post('add-cart', [CartController::class, 'index']);
Route::get('carts', [CartController::class, 'show']);
Route::post('update-cart', [CartController::class, 'update']);
Route::get('carts/delete/{id}', [CartController::class, 'remove']);
Route::post('carts', [CartController::class, 'addCart']);

#UI contact
Route::get('contact', function () {
    return view('contact', [
        'title' => "Contact",
    ]);
});

Route::get('/blog', [ControllersBlogController::class, 'index']);
Route::get('/blog/{id}-{slug}.html', [ControllersBlogController::class, 'show']);

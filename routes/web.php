<?php

use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TourController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ViewController;
use App\Http\Controllers\BookingDetailController;
use App\Http\Controllers\ReviewController;


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

// DÀNH CHO CẢ 2
// https://127.0.0.1/
// Homepage
Route::get('/', [ViewController::class, 'homepage'])->name('homepage');
// Chi tiết tour
Route::get('/tours/{id?}', [ViewController::class, 'tourDetails'])->name('tour_details');

Route::prefix('/')->middleware("auth")->group(function () {
    // Trang cá nhân
    Route::get('/account', [ViewController::class, 'account'])->name('account');
    // Đổi thông tin cá nhân
    Route::post('/change-info', [UserController::class, 'changeInfo'])->name('change-info');
    // Đổi mật khẩu
    Route::post('/change-password', [UserController::class, 'changePassword'])->name('change-password');
    // Trang các tour đã đặt
    Route::get('/my-bookings', [ViewController::class, 'myBookings'])->name('my-bookings');

    // Đăng xuất
    Route::get('/logout', [UserController::class, 'logout'])->name('auth.logout');

    // Đặt tour
    Route::get('/booking/{tour_id?}/{user_id?}', [BookingDetailController::class, 'booking'])->name('booking');

    // Đánh giá
    Route::post('/review/{tour_id?}/{user_id?}', [ReviewController::class, 'review'])->name('review');
});

// Auth
Route::get('/login', [UserController::class, 'loginForm'])->name('login');
Route::post('/login', [UserController::class, 'login'])->name('auth.login');
Route::get('/signup', [UserController::class, 'signupForm'])->name('signup');
Route::post('/signup', [UserController::class, 'signup'])->name('auth.signup');

// DÀNH CHO ADMIN
// https://127.0.0.1/admin
Route::prefix('/admin')->middleware(['auth', 'admin'])->group(function () {
    // /
    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // /tours
    Route::prefix('/tours')->group(function () {
        // /list
        Route::get('/list', [TourController::class, 'list'])->name("list_tours");

        // /add
        Route::get('/add', [TourController::class, 'add_tour'])->name("add_tour");
        Route::post('/save_tour/{id?}', [TourController::class, 'save_tour'])->name("save_tour");

        // /delete_tour
        Route::get('/delete_tour/{id?}', [TourController::class, 'delete_tour'])->name("delete_tour");
    });

    // /users
    Route::prefix('/users')->group(function () {
        // /list
        Route::get('/list', [UserController::class, 'list'])->name("list_users");

        // /add
        Route::get('/add', [UserController::class, 'add_user'])->name("add_user");
        Route::post('/save_user/{id?}', [UserController::class, 'save_user'])->name("save_user");

        // /delete_user
        Route::get('/delete_user/{id?}', [UserController::class, 'delete_user'])->name("delete_user");
    });

    // /bookings
    Route::prefix('/bookings')->group(function () {
        // /list
        Route::get('/list', [BookingDetailController::class, 'list'])->name("list_bookings");

        // /add
        Route::get('/add', [BookingDetailController::class, 'add_booking'])->name("add_booking");
        Route::post('/save_booking/{id?}', [BookingDetailController::class, 'save_booking'])->name("save_booking");

        // /delete_user
        Route::get('/delete_booking/{id?}', [BookingDetailController::class, 'delete_booking'])->name("delete_booking");

        // Duyệt đơn đặt tour
        Route::post('/approve_booking/{id?}', [BookingDetailController::class, 'approve_booking'])->name('approve_booking');

        // Xem các bookings on tour
        Route::get('/bookings_on_tour', [BookingDetailController::class, 'bookings_on_tour'])->name('bookings_on_tour');
    });

    // /reviews
    Route::prefix('/reviews')->group(function () {
        // /list
        Route::get('/list', [ReviewController::class, 'list'])->name("list_reviews");

        // /add
        Route::get('/add', [ReviewController::class, 'add_review'])->name("add_review");
        Route::post('/save_review/{id?}', [ReviewController::class, 'save_review'])->name("save_review");

        // /delete_user
        Route::get('/delete_review/{id?}', [ReviewController::class, 'delete_review'])->name("delete_review");
    });
});

Route::get('/*', function () {
    return view('errors.404');
});

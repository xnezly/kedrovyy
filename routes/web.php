<?php

use App\Http\Controllers\Admin\AdminApplicationController;
use App\Http\Controllers\Admin\AdminMainController;
use App\Http\Controllers\Admin\AdminRoomController;
use App\Http\Controllers\Admin\AdminServiceController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\RoomController;
use Illuminate\Support\Facades\Route;

// Публичные
Route::get('/', [MainController::class, 'index'])->name('home');
Route::get('/about', [MainController::class, 'about'])->name('about');
Route::get('/contacts', [MainController::class, 'contacts'])->name('contacts');
Route::get('/booking', [MainController::class, 'booking'])->name('booking');

// Номера
Route::get('/rooms', [RoomController::class, 'index'])->name('rooms.index');
Route::get('/rooms/{room}', [RoomController::class, 'show'])->name('rooms.show');

// Неавторизованный пользователь
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'registerForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register');

    Route::get('/login', [LoginController::class, 'loginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login');
});

// Авторизованный пользователь
Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    // Заявки
    Route::get('/applications', [ApplicationController::class, 'index'])->name('applications.index');
    Route::get('/applications/{room}/create', [ApplicationController::class, 'create'])->name('applications.create');
    Route::post('/applications/{room}', [ApplicationController::class, 'store'])->name('applications.store');
    Route::post('/applications/{application}/cancel', [ApplicationController::class, 'cancel'])->name('applications.cancel');
    // Отзывы
    Route::post('/rooms/{room}/comment', [RoomController::class, 'comment'])->name('rooms.comment');
});

// Админ
Route::middleware('admin')->group(function () {
    Route::prefix('/admin')->name('admin.')->group(function () {
        // Дашборд
        Route::get('/dashboard', [AdminMainController::class, 'index'])->name('dashboard');
        // Номера - CRUD
        Route::resource('/rooms', AdminRoomController::class);
        // Услуги - CRUD
        Route::resource('/services', AdminServiceController::class);
        // Бронирования
        Route::get('/applications', [AdminApplicationController::class, 'index'])->name('applications.index');
        Route::get('/applications/{application}', [AdminApplicationController::class, 'show'])->name('applications.show');
        Route::patch('/applications/{application}', [AdminApplicationController::class, 'update'])->name('applications.update');
        Route::delete('/applications/{application}', [AdminApplicationController::class, 'destroy'])->name('applications.destroy');
    });
});

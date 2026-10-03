<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminContentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\ConcernReportController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PageController;

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/programs', [PageController::class, 'programs'])->name('programs');
Route::get('/admissions', [PageController::class, 'admissions'])->name('admissions');
Route::get('/faculty', [PageController::class, 'faculty'])->name('faculty');
Route::get('/campus', [PageController::class, 'campus'])->name('campus');
Route::get('/news', [PageController::class, 'news'])->name('news.index');
Route::get('/news/{slug}', [PageController::class, 'article'])->name('news.show');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::post('/contact', [ContactController::class, 'send'])->middleware('throttle:5,1')->name('contact.send');

Route::get('/community', [CommunityController::class, 'index'])->name('community.index');
Route::get('/community/create', [CommunityController::class, 'create'])->name('community.create');
Route::post('/community', [CommunityController::class, 'store'])->middleware('throttle:5,1')->name('community.store');
Route::get('/community/{post}/attachment', [CommunityController::class, 'attachment'])->name('community.attachment');
Route::post('/community/{post}/report', [CommunityController::class, 'report'])->middleware('throttle:5,1')->name('community.report');
Route::post('/community/{post}/replies', [CommunityController::class, 'reply'])->middleware('throttle:8,1')->name('community.reply');

Route::get('/report-a-concern', [ConcernReportController::class, 'create'])->name('concerns.create');
Route::post('/report-a-concern', [ConcernReportController::class, 'store'])->middleware('throttle:3,1')->name('concerns.store');
Route::get('/track-a-report', [ConcernReportController::class, 'trackForm'])->name('concerns.track.form');
Route::post('/track-a-report', [ConcernReportController::class, 'track'])->middleware('throttle:10,1')->name('concerns.track');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:8,1')->name('login.store');
    Route::get('/register', [AuthController::class, 'registerForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->middleware('throttle:5,1')->name('register.store');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin,staff'])->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/posts', [AdminController::class, 'posts'])->name('posts');
    Route::get('/posts/{post}/attachment', [AdminController::class, 'postAttachment'])->name('posts.attachment');
    Route::patch('/posts/{post}', [AdminController::class, 'moderatePost'])->name('posts.moderate');
    Route::patch('/replies/{reply}', [AdminController::class, 'moderateReply'])->name('replies.moderate');
    Route::delete('/posts/{post}', [AdminController::class, 'deletePost'])->name('posts.delete');
    Route::get('/reports', [AdminController::class, 'reports'])->name('reports');
    Route::patch('/reports/{report}', [AdminController::class, 'updateReport'])->name('reports.update');
    Route::patch('/reports/{report}/assignment', [AdminController::class, 'assignReport'])->middleware('role:admin')->name('reports.assign');
    Route::get('/reports/{report}/attachment', [AdminController::class, 'reportAttachment'])->name('reports.attachment');
    Route::get('/users', [AdminController::class, 'users'])->middleware('role:admin')->name('users');
    Route::patch('/users/{user}/role', [AdminController::class, 'updateUserRole'])->middleware('role:admin')->name('users.role');
    Route::middleware('role:admin')->prefix('content')->name('content.')->group(function () {
        Route::get('/{type}', [AdminContentController::class, 'index'])->name('index');
        Route::get('/{type}/create', [AdminContentController::class, 'create'])->name('create');
        Route::post('/{type}', [AdminContentController::class, 'store'])->name('store');
        Route::get('/{type}/{item}/edit', [AdminContentController::class, 'edit'])->whereNumber('item')->name('edit');
        Route::put('/{type}/{item}', [AdminContentController::class, 'update'])->whereNumber('item')->name('update');
        Route::delete('/{type}/{item}', [AdminContentController::class, 'destroy'])->whereNumber('item')->name('delete');
    });
});

<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\MaintenanceTaskController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Home page - redirect to login
Route::get('/', function () {
    return redirect()->route('login');
});

// Guest maintenance report - no login required
Route::get('/guest/report', [MaintenanceController::class, 'guestCreate'])
    ->name('guest.report.create');
Route::post('/guest/report', [MaintenanceController::class, 'guestStore'])
    ->name('guest.report.store');

// Dashboard - requires login
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// All routes that require authentication
Route::middleware('auth')->group(function () {

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ==========================================
    // MAINTENANCE ROUTES
    // ==========================================
    Route::resource('maintenance', MaintenanceController::class);

    Route::get('maintenance/{maintenance}/assign', [MaintenanceController::class, 'assignForm'])
        ->name('maintenance.assign.form');
    Route::post('maintenance/{maintenance}/assign', [MaintenanceController::class, 'assign'])
        ->name('maintenance.assign');

    // ==========================================
    // TASK ROUTES
    // ==========================================
    Route::post('tasks/{task}/start', [MaintenanceTaskController::class, 'start'])
        ->name('tasks.start');
    Route::post('tasks/{task}/complete', [MaintenanceTaskController::class, 'complete'])
        ->name('tasks.complete');

    // ==========================================
    // NOTIFICATION ROUTES
    // ==========================================
    Route::get('notifications', [NotificationController::class, 'index'])
        ->name('notifications.index');
    Route::post('notifications/{notification}/read', [NotificationController::class, 'markAsRead'])
        ->name('notifications.read');
    Route::post('notifications/read-all', [NotificationController::class, 'markAllAsRead'])
        ->name('notifications.read-all');
});

// Authentication routes (from Laravel Breeze)
require __DIR__.'/auth.php';

<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/ticketing', function () {
    return view('ticketing');
});

Route::post('/submit-ticket', [App\Http\Controllers\TicketController::class, 'submitTicket'])->name('submit.ticket');

Route::get('/admin-login', function () {
    if (auth()->check()) {
        return redirect()->route('admin.dashboard');
    }
    return view('admin.login');
})->name('admin.login');

Route::post('/admin-authenticate', [App\Http\Controllers\AdminController::class, 'authenticate'])->name('admin.login.submit');

Route::get('/admin-dashboard', [App\Http\Controllers\AdminController::class, 'dashboard'])->name('admin.dashboard')->middleware('auth');

Route::post('/admin-logout', [App\Http\Controllers\AdminController::class, 'logout'])->name('admin.logout')->middleware('auth');

Route::get('/view-ticket/{type}/{id}', [App\Http\Controllers\AdminController::class, 'viewTicket'])->name('admin.view.ticket')->middleware('auth');

Route::post('/update-ticket-notes/{type}/{id}', [App\Http\Controllers\AdminController::class, 'updateTicketNotes'])->name('admin.update.ticket.notes')->middleware('auth');
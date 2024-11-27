<?php

use App\Models\Contact;
use App\Livewire\ContactManager;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

Route::get('/', ContactManager::class)->name('contacts.index')->middleware('auth');
Route::get('/login', [AdminController::class, 'login'])->name('login');
Route::post('/login', [AdminController::class, 'authenticate'])->name('authenticate');
Route::post('/logout', [AdminController::class, 'logout'])->name('logout');

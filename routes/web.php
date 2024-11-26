<?php

use App\Livewire\ContactManager;
use App\Models\Contact;
use Illuminate\Support\Facades\Route;

Route::get('/', ContactManager::class)->name('contacts.index');

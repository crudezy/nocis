<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\VolunteerController;
use Illuminate\Support\Facades\Route;

// Redirect root to login
Route::get('/', function () {
    return redirect('/login');
});

// Authentication Routes
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', function () {
    // Simple login logic for demo
    $credentials = request()->only('username', 'password');
    
    if ($credentials['username'] === 'admin' && $credentials['password'] === 'admin123') {
        session(['authenticated' => true, 'user' => 'admin']);
        return redirect('/dashboard');
    }
    
    return back()->withErrors(['username' => 'Invalid credentials']);
})->name('login.post');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::get('/password/reset', function () {
    return view('auth.forgot-password');
})->name('password.request');

Route::post('/logout', function () {
    session()->forget(['authenticated', 'user']);
    return redirect('/login');
})->name('logout');

// Protected Routes (require authentication)
Route::middleware(['web'])->group(function () {
    Route::get('/dashboard', function () {
        if (!session('authenticated')) {
            return redirect('/login');
        }
        return view('menu.dashboard.dashboard');
    })->name('dashboard');

    Route::resource('events', EventController::class)->except(['show']);

    Route::get('/volunteers', [VolunteerController::class, 'index'])->name('volunteers.index');

    Route::get('/reviews', function () {
        if (!session('authenticated')) {
            return redirect('/login');
        }
        return view('menu.reviews.index');
    });
});


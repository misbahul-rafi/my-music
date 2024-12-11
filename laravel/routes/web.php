<?php

use App\Http\Controllers\SongController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\MusicController;

Route::get('/', function () {
    return view('index', [
        'title' => "Home"
    ]);
})->name('home');

Route::middleware('guest')->group(function () {
    Route::get('register', [UserController::class, 'showRegisterForm'])->name('register');
    Route::post('register', [UserController::class, 'register']);

    Route::get('login', [UserController::class, 'showLoginForm'])->name('login');
    Route::post('login', [UserController::class, 'login']);
});


Route::middleware('auth')->group(function () {
    Route::get('profile', [UserController::class, 'showProfile'])->name('profile');
    Route::get('edit-profile', [UserController::class, 'showEditForm'])->name('edit');
    Route::post('edit-profile', [UserController::class, 'edit']);
    Route::post('logout', [UserController::class, 'logout'])->name('logout');
});


Route::prefix('notes')->group(function () {
    Route::get('', [NoteController::class, 'index'])->name('notes.index');
    Route::get('show/{id}', [NoteController::class, 'showNote'])->name('notes.show');
    
    Route::middleware('auth')->group(function () {
        Route::get('dashboard', [NoteController::class, 'dashboard'])->name('notes.dashboard');
        Route::get('create', [NoteController::class, 'create'])->name('notes.create');
    
        Route::post('store', [NoteController::class, 'store'])->name('notes.store');
        Route::get('edit/{note}', [NoteController::class, 'edit'])->name('notes.edit');
        Route::put('update/{note}', [NoteController::class, 'update'])->name('notes.update');
        Route::delete('destroy/{note}', [NoteController::class, 'destroy'])->name('notes.destroy');
    });
});

Route::prefix('music')->group(function () {
    Route::get('', [MusicController::class,'index'])
    ->name('music.index');
    Route::get('dashboard', [MusicController::class, 'dashboard'])
    ->middleware('auth')
    ->name('music.dashboard');
});

Route::prefix('songs')->group(function () {
    Route::get('/songs', [SongController::class, 'index'])->name('songs.index');
    Route::get('play/{songid}', [SongController::class, 'playSong'])->name('song.play');

    Route::middleware('auth')->group(function () {
        Route::get('create', [SongController::class, 'create'])->name('song.create');
        Route::post('store', [SongController::class, 'store'])->name('song.store');
        Route::get('update/{songid}', [SongController::class, 'edit'])->name('song.edit');
        Route::post('update/{songid}', [SongController::class, 'update'])->name('song.update');
        Route::delete('destroy/{songid}', [SongController::class, 'destroy'])->name('songs.delete');
    });
});
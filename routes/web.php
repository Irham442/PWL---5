<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\LoanController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::get('/book', [BookController::class, 'index'])->name('book');
});

Route::group(['middleware' => ['role:pustakawan']], function () {
    Route::get('/book/create', [BookController::class, 'create'])->name('book.create');
    Route::get('/book/edit/{id}', [BookController::class, 'edit'])->name('book.edit');
    Route::post('/book/store', [BookController::class, 'store'])->name('book.store');
    Route::patch('/book/{id}/update', [BookController::class, 'update'])->name('book.update');
    Route::post('book/{id}/update-stock', [BookController::class, 'updateStock'])->name('book.update-stock');
    Route::delete('/book/{id}/delete', [BookController::class, 'destroy'])->name('book.destroy');
    
    Route::get('/book/print', [BookController::class, 'print'])->name('book.print');
    Route::get('/book/export', [BookController::class, 'export'])->name('book.export');
    Route::post('/book/import', [BookController::class, 'import'])->name('book.import');
});

Route::group(['middleware' => ['role:mahasiswa']], function () {
    Route::get('/loan', [LoanController::class, 'index'])->name('loan');
    Route::get('/loan/create', [LoanController::class, 'create'])->name('loan.create');
    Route::post('/loan', [LoanController::class, 'store'])->name('loan.store');
});

require __DIR__.'/auth.php';

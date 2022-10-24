<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BackendController;

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

Route::get('/', function () {
    if (Auth::check()) {
       if (auth()->user()->hasRole('librarian')) {
        return view('admin.panel');
       }
       else{
        return view('books.library');
       }
    }
    return view('auth.login');
});

// emails
Route::view('contact-response', 'emails.contact-response');
Route::view('contact-mail', 'emails.contact-form');


Route::get('librarian', [BackendController::class, 'admin'])->name('librarian');
Route::get('library', [BackendController::class, 'library'])->name('library')->middleware('role:student');
Route::get('all-books', [BookController::class, 'index'])->name('admin.book')->middleware('role:librarian');

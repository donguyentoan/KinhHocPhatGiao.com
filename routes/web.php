<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\homeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SutraController;
use App\Http\Controllers\AthorSutraController;

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
    Route::get('/', function () { return view('welcome'); });
    Route::get('/contact', function () { return view('contact'); });
    Route::get('/tacgia', [AthorSutraController::class , 'showAuthor']);
    Route::get('/introduce', function () { return view('introduce'); });
    Route::get('/kinhphat' ,[homeController::class , 'index'] );
    Route::get('/sutraDetail/{id}' ,[homeController::class , 'getByID'] );
    Route::get('/dashboard', [SutraController::class, 'index'])->name('index');
    Route::get('/sutra', [SutraController::class, 'index'])->name('index');
    Route::get('/view/{id}', [SutraController::class, 'getByID']);
    Route::get('/del/{id}', [SutraController::class, 'removeByID']);
    Route::get('/addSutra', [SutraController::class, 'addSutra']);
    Route::post('/addSutras', [SutraController::class, 'store']);
    Route::get('/sutraDetail', [SutraController::class, 'detailById']);
    Route::get('/athor', [AthorSutraController::class, 'index'])->name('author');
  
    Route::get('/addAuthorSutra', [AthorSutraController::class, 'addAuthorSutra']);
    Route::post('/addAuthorSutras', [AthorSutraController::class, 'store']);
    Route::get('/login', [LoginController::class, 'index']);
    Route::get('/information/{id}', [AthorSutraController::class, 'showIF']);


    Route::get('/gallery' , function ()
     {
         return view('Component.Gallery');
     });
     Route::get('/tab' , function ()
     {
         return view('Component.Tabs');
     });
    
    
   


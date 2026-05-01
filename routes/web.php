<?php

use App\Livewire\DashboardPage;
use App\Livewire\HomePage;
use App\Livewire\IntroductionPage;
use App\Http\Controllers\ScriptureReaderController;
use App\Http\Controllers\ToolsController;
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

Route::get('/introduction', IntroductionPage::class)->name('introduction');
Route::get('/', HomePage::class)->name('home');
Route::get('/dashboard', DashboardPage::class)->name('dashboard');
Route::get('/scriptures/{scripture}/read', [ScriptureReaderController::class, 'show'])->name('scriptures.read');
Route::get('/scriptures/{scripture}/pdf', [ScriptureReaderController::class, 'pdf'])->name('scriptures.pdf');
Route::get('/tien-ich/{slug}', [ToolsController::class, 'show'])->name('tools.show');


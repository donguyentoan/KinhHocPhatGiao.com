<?php

use App\Livewire\AccountPage;
use App\Livewire\DashboardPage;
use App\Livewire\HomePage;
use App\Livewire\PostShowPage;
use App\Livewire\LoginPage;
use App\Livewire\RegisterPage;
use App\Http\Controllers\ScriptureReaderController;
use App\Http\Controllers\SeoController;
use App\Http\Controllers\ToolsController;
use Illuminate\Support\Facades\Auth;
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

Route::get('/robots.txt', [SeoController::class, 'robots'])->name('seo.robots');
Route::get('/sitemap.xml', [SeoController::class, 'sitemap'])->name('seo.sitemap');
Route::get('/sitemaps/{type}.xml', [SeoController::class, 'sitemapSection'])
    ->where('type', 'main|kinh|blog|tools')
    ->name('seo.sitemap.section');

Route::get('/', HomePage::class)->name('home');
Route::get('/bai-viet/{post}', PostShowPage::class)->name('posts.show');
Route::redirect('/home', '/');
Route::get('/tai-khoan', AccountPage::class)->name('account');

Route::middleware('guest')->group(function () {
    Route::get('/dang-nhap', LoginPage::class)->name('login');
    Route::get('/dang-ky', RegisterPage::class)->name('register');
});

Route::post('/dang-xuat', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect()->route('home');
})->middleware('auth')->name('logout');

Route::get('/dashboard', DashboardPage::class)->middleware(['auth', 'admin'])->name('dashboard');
Route::get('/scriptures/{scripture}/read', [ScriptureReaderController::class, 'show'])->name('scriptures.read');
Route::get('/scriptures/{scripture}/pdf', [ScriptureReaderController::class, 'pdf'])->name('scriptures.pdf');
Route::get('/tien-ich/{slug}', [ToolsController::class, 'show'])->name('tools.show');
Route::post('/tien-ich/ngoi-thien/start', [ToolsController::class, 'startMeditation'])->name('tools.meditation.start');
Route::post('/tien-ich/ngoi-thien/complete', [ToolsController::class, 'completeMeditation'])->name('tools.meditation.complete');


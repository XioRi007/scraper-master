<?php

use App\Http\Controllers\ScraperJobController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::name('scraper.')->group(function () {
Route::get('/', [ScraperJobController::class, 'index'])->name('index');
Route::post('/', [ScraperJobController::class, 'store'])->name('store');
Route::put('/end', [ScraperJobController::class, 'end'])->name('end');
Route::get('/{id}', [ScraperJobController::class, 'show'])->name('show');
Route::get('/{id}/items', [ScraperJobController::class, 'items'])->name('items');
Route::get('/{id}/stats', [ScraperJobController::class, 'stats'])->name('stats');
});

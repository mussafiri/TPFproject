<?php

use App\Http\Controllers\ContributorController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ZoneController;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/defaultpage', [CommonController::class, 'index']);
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/change/password', [ProfileController::class, 'changePassword'])->name('change.password');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    //::::::::::::::::::::::::::::::::::::::::::::::::ZONES ROUTES :::::::::::::::::::::::::::::::::::::::::
    Route::get('/contributors/zones', [ZoneController::class, 'zones']);



    //START:: Contributor
    Route::get('contributors/category', [ContributorController::class, 'contributorsCategory'])->name('contributors.category');
    Route::post('submit/add/contributor/category', [ContributorController::class, 'submitNewContributorsCategory']);
    Route::post('ajax/get/contri/category/data', [ContributorController::class, 'ajaxGetContributorsCategory']);
    Route::post('submit/edit/contributor/category', [ContributorController::class, 'submitEditContributorsCategory']);
    Route::post('/ajax/change/category/status', [ContributorController::class, 'changeContributorsCategoryStatus']);
    Route::get('/add/contributor', [ContributorController::class, 'addContributors']);
    Route::post('/ajax/get/section/data', [ContributorController::class, 'ajaxGetSectionData']);
    Route::post('/submit/add/contributor', [ContributorController::class, 'SubmitAddContributor']);
    Route::get('contributors', [ContributorController::class, 'contributors'])->name('contributors.list');
    //END:: Contributor
});

require __DIR__.'/auth.php';

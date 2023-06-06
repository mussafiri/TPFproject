<?php

use App\Http\Controllers\MemberController;
use App\Http\Controllers\MemberAuthController;
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

Route::get('/defaultpage', [CommonController::class, 'index']);
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/change/password', [ProfileController::class, 'changePassword'])->name('change.password');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    //:::::::::::::::::::::::::::::::::::::::::::::::: ZONES ROUTES ::::::::::::::::::::::::::::::::::::::::::::::::
    Route::get('/ajax/get/district/old/data', [ZoneController::class, 'ajaxGetDistrictOldData']);
    Route::get('/zones/sections/{status}', [ZoneController::class, 'sections'])->name('sections');
    Route::get('/ajax/get/zone/old/data', [ZoneController::class, 'ajaxGetZoneOldData'])->name('ajaxGetZoneOldData');
    Route::get('/zones/districts/{status}', [ZoneController::class, 'districts']);
    Route::get('/zones/list', [ZoneController::class, 'zones']);
    Route::get('/dormant/zones/list', [ZoneController::class, 'suspendedZones']);
    Route::get('/ajax/get/zone/data', [ZoneController::class, 'zoneUpdateAjax']);
    
    Route::post('/ajax/get/section/data/view', [ZoneController::class, 'ajaxSectionViewData']);
    Route::post('/section/edit', [ZoneController::class, 'submitSectionEdit']);
    Route::post('/ajax/get/section/data/edit', [ZoneController::class, 'ajaxSectionGetData']);
    Route::post('/section/register', [ZoneController::class, 'submitSection']);
    Route::post('/ajax/update/section/status', [ZoneController::class, 'ajaxUpdateSectionStatus']);
    Route::post('/ajax/update/district/status', [ZoneController::class, 'ajaxUpdateDistrictStatus']);
    Route::post('/district/edit', [ZoneController::class, 'submitDistrictEdit']);
    Route::post('/ajax/get/district/data', [ZoneController::class, 'ajaxDistrictGetData']);
    Route::post('/district/register', [ZoneController::class, 'submitDistrict']);
    Route::post('/ajax/update/zone/status', [ZoneController::class, 'ajaxUpdateZoneStatus']);
    Route::post('/ajax/get/zone/data', [ZoneController::class, 'ajaxZoneGetData']);
    Route::post('/zone/register', [ZoneController::class, 'submitZones']);
    Route::post('/zone/edit', [ZoneController::class, 'submitZoneEdit']);



    //START:: Contributor
    Route::get('contributor/categories/{status}', [ContributorController::class, 'contributorsCategory'])->name('contributors.category');
    Route::post('submit/add/contributor/category', [ContributorController::class, 'submitNewContributorsCategory']);
    Route::post('ajax/get/contri/category/data', [ContributorController::class, 'ajaxGetContributorsCategory']);
    Route::post('ajax/change/contri/category/status', [ContributorController::class, 'ajaxUpdateContributorsCategoryStatus']);
    Route::post('submit/edit/contributor/category', [ContributorController::class, 'submitEditContributorsCategory']);
    Route::get('/add/contributors', [ContributorController::class, 'addContributors']);
    Route::get('/edit/contributors/{id}', [ContributorController::class, 'editContributors']);
    Route::post('submit/edit/contributor/{id}', [ContributorController::class, 'submitEditContributor']);
    Route::post('/ajax/get/section/data', [ContributorController::class, 'ajaxGetSectionData']);
    Route::post('/submit/add/contributor', [ContributorController::class, 'SubmitAddContributor']);
    Route::get('contributors/{status}', [ContributorController::class, 'contributors'])->name('contributors.list');
    Route::post('ajax/change/contri/status', [ContributorController::class, 'ajaxUpdateContributorStatus']);
    //END:: Contributor

});

// START:: MEMBERS ROUTES
Route::get('/member/login', [MemberAuthController::class, 'authenticateMember'])->name('member.login');
Route::post('/member/login', [MemberAuthController::class, 'authenticateMember'])->name('post.member.login');

Route::middleware(['auth:member'])->group(function () {
      Route::get('member/dashboard', [MemberController::class, 'dashboard'])->name('members.dashboard');
});
// END:: MEMBERS ROUTES


require __DIR__.'/auth.php';

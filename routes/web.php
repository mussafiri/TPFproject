<?php

use App\Http\Controllers\MemberController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\MemberDashboardController;
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
Route::get('/suspended', [AuthenticatedSessionController::class, 'suspendedUser']);

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    // Route::get('/change/password', [ProfileController::class, 'changePassword'])->name('change.password');
    Route::get('/profile', [ProfileController::class, 'myProfile'])->name('profile');
    Route::get('/reset/password', [ProfileController::class, 'resetPassword'])->name('profile.reset.password');
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
    Route::post('/district/register', [ZoneController::class, 'submitDistrict']);
    Route::post('/zone/register', [ZoneController::class, 'submitZones']);
    Route::post('/zone/edit', [ZoneController::class, 'submitZoneEdit']);

    //START:: Contributor 
    Route::prefix('contributors')->group(function(){
        Route::get('/categories/{status}', [ContributorController::class, 'contributorsCategory'])->name('contributors.category');
        Route::post('/category/add/submit', [ContributorController::class, 'submitNewContributorsCategory']);
        Route::post('/category/edit/submit', [ContributorController::class, 'submitEditContributorsCategory']);
        Route::get('/add', [ContributorController::class, 'addContributors']);
        Route::get('/edit/{id}', [ContributorController::class, 'editContributors']);
        Route::post('/edit/submit{id}', [ContributorController::class, 'submitEditContributor']);
        Route::post('/add/submit', [ContributorController::class, 'SubmitAddContributor']);
        Route::get('/list/{status}', [ContributorController::class, 'contributors'])->name('contributors.list');
    });
    //END:: Contributor

    Route::prefix('ajax')->group(function(){
        #Start::zones routes
        Route::get('/get/zone/old/data', [ZoneController::class, 'ajaxGetZoneOldData'])->name('ajaxGetZoneOldData');
        Route::get('/get/zone/data', [ZoneController::class, 'zoneUpdateAjax']);
        Route::post('/update/zone/status', [ZoneController::class, 'ajaxUpdateZoneStatus']);
        Route::post('/get/zone/data', [ZoneController::class, 'ajaxZoneGetData']);
        #End::zones routes

        #Start::district routes
        Route::post('/get/district/data', [ZoneController::class, 'ajaxDistrictGetData']);
        #Start::district routes

        #Start::section routes
        Route::post('/get/section/data', [ContributorController::class, 'ajaxGetSectionData']);
        #Start::section routes

        #Start::contributor routes
        Route::post('/get/contri/category/data', [ContributorController::class, 'ajaxGetContributorsCategory']);
        Route::post('/change/contri/category/status', [ContributorController::class, 'ajaxUpdateContributorsCategoryStatus']);
        Route::post('/change/contri/status', [ContributorController::class, 'ajaxUpdateContributorStatus']);
        #End::contributor routes
    });
});

// START:: MEMBERS ROUTES
Route::prefix('member')->group(function(){
    Route::get('/login', [MemberAuthController::class, 'login'])->name('member.login');
    Route::post('/login', [MemberAuthController::class, 'authenticateMember'])->name('submit.member.login');
    Route::get('/suspended', [MemberAuthController::class, 'suspendedMember']);

   Route::middleware('member')->group(function(){
       Route::get('/dashboard', [MemberDashboardController::class, 'index'])->name('member.dashboard');

   });
});

// END:: MEMBERS ROUTES


require __DIR__.'/auth.php';

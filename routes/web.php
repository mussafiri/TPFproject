<?php
use App\Http\Controllers\ContributionController;

use App\Http\Controllers\MemberController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\UserController;
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
    
    Route::prefix('ajax')->group(function(){
        Route::get('/get/district/old/data', [ZoneController::class, 'ajaxGetDistrictOldData']);
        Route::get('/get/zone/old/data', [ZoneController::class, 'ajaxGetZoneOldData'])->name('ajaxGetZoneOldData');
        Route::get('/get/zone/data', [ZoneController::class, 'zoneUpdateAjax']);
        Route::post('/get/zone/data/view', [ZoneController::class, 'ajaxZoneViewData']);
        Route::post('/get/district/data/view', [ZoneController::class, 'ajaxDistrictViewData']);
        Route::post('/get/section/data/view', [ZoneController::class, 'ajaxSectionViewData']);
        Route::post('/get/section/data/edit', [ZoneController::class, 'ajaxSectionGetData']);
        Route::post('/update/section/status', [ZoneController::class, 'ajaxUpdateSectionStatus']);
        Route::post('/update/district/status', [ZoneController::class, 'ajaxUpdateDistrictStatus']);
        #Member
        Route::post('/dynamic/validation', [MemberController::class, 'ajaxRowDynamicValidation']);
    });

    Route::prefix('zones')->group(function(){
        Route::get('/sections/{status}', [ZoneController::class, 'sections'])->name('sections');
        Route::get('/districts/{status}', [ZoneController::class, 'districts']);
        Route::get('/list', [ZoneController::class, 'zones']);
        Route::get('/dormant/list', [ZoneController::class, 'suspendedZones']);    

        Route::post('/register', [ZoneController::class, 'submitZones']);
        Route::post('/edit', [ZoneController::class, 'submitZoneEdit']);
    });

    Route::prefix('section')->group(function(){
        Route::post('/edit', [ZoneController::class, 'submitSectionEdit']);
        Route::post('/register', [ZoneController::class, 'submitSection']);
    });

    Route::prefix('district')->group(function(){
        Route::post('/edit', [ZoneController::class, 'submitDistrictEdit']);
        Route::post('/register', [ZoneController::class, 'submitDistrict']);
    });
    //:::::::::::::::::::::::::::::::::::::::::::::::: END ZONES ROUTES ::::::::::::::::::::::::::::::::::::::::::::::::

    //:::::::::::::::::::::::::::::::::::::::::::::::: MEMBERS ROUTES ::::::::::::::::::::::::::::::::::::::::::::::::
    Route::prefix('members')->group(function(){
        Route::get('/registration', [MemberController::class, 'regMemberView']);
        Route::get('/list', [MemberController::class, 'members']);
        Route::get('/possible/duplicates', [MemberController::class, 'duplicateMembers']);
        
        
    });
    Route::prefix('member')->group(function(){
    Route::post('registration/submit', [MemberController::class, 'submitMemberRegistration']);
    });
    //:::::::::::::::::::::::::::::::::::::::::::::::: END MEMBERS ROUTES ::::::::::::::::::::::::::::::::::::::::::::::::
    



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
        Route::post('/get/contributor/data', [ContributorController::class, 'ajaxGetContributorData']);
        Route::post('/get/contributor/category/data', [ContributorController::class, 'ajaxGetContributorsCategory']);
        Route::post('/change/contributor/category/status', [ContributorController::class, 'ajaxUpdateContributorsCategoryStatus']);
        Route::post('/change/contributor/status', [ContributorController::class, 'ajaxUpdateContributorStatus']);
        #End::contributor routes

        #Start:: user management routes
        Route::post('/change/user/status', [UserController::class, 'ajaxChangeUserUserStatus']);
        Route::post('/change/department/status', [UserController::class, 'ajaxChangeDepartmentStatus']);
        Route::post('/get/department/data', [UserController::class, 'ajaxGetDepartmentData']);
        Route::post('/get/designation/data', [UserController::class, 'ajaxGetDesignationData']);
        Route::post('/change/designation/status', [UserController::class, 'ajaxChangeDesignationStatus']);
        #End:: user management routes

        #Start:: constant value routes
        Route::post('/get/constantvalue/data',[SettingsController::class, 'ajaxGetConstantvalueData']);
        #End:: constant value routes
    });

    //Start:: users management routes
    Route::prefix('users')->group(function(){
        Route::get('/list/{status}', [UserController::class, 'userList']);
        Route::get('/add', [UserController::class, 'addUser']);
        Route::post('/add/submit', [UserController::class, 'submitAddUser']);
        Route::get('/view/{id}', [UserController::class, 'viewUser']);
        Route::get('/edit/{id}', [UserController::class, 'editUser']);
        Route::post('/edit/submit/{id}', [UserController::class, 'submitEditUser']);
        Route::get('/departments/{status}', [UserController::class, 'departments']);
        Route::post('/departments/add/submit', [UserController::class, 'submitNewDepartment']);
        Route::post('/department/edit/submit', [UserController::class, 'submitEditDepartment']);
        Route::get('/designations/{status}', [UserController::class, 'designations']);
        Route::post('/designations/add/submit', [UserController::class, 'submitNewDesignation']);
        Route::post('/designations/edit/submit', [UserController::class, 'submitEditDesignation']);
    });
    //end:: users management routes

    //Start:: Contributions
    Route::prefix('contributions')->group(function(){
        Route::get('/add', [ContributionController::class, 'addContribution']);
    });
    //End:: Contributions

    //Start:: Configurations routes
    Route::prefix('configs')->group(function(){
        Route::get('/constantvalues', [SettingsController::class, 'constantValues']);
        Route::post('/edit/constantvalue/submit', [SettingsController::class, 'submitConstantValues']);
        Route::get('/schemes', [SettingsController::class, 'schemes']);
    });
    //Start:: Configurations routes
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

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\ConstantValue;
use App\Models\User;
use App\Models\UserLoginAttempts;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\View\View;
use Carbon\Carbon;

class AuthenticatedSessionController extends Controller {
    /**
    * Display the login view.
    */

    public function create(): View {
        return view( 'auth.login' );
    }

    /**
    * Handle an incoming authentication request.
    */

    public function store( LoginRequest $request ): RedirectResponse {
        // $request->authenticate();

        $request->ensureIsNotRateLimited();

        //START:: UN AUTHORIZED USER OPERATIONS
        if ( ! Auth::attempt( $request->only( 'email', 'password' ), $request->filled( 'remember' ) ) ) {
            RateLimiter::hit( $request->throttleKey() );

            $getMaxAttempt = ConstantValue::where( 'item_type', 'MAXIMUM WRONG LOGIN ATTEMPTS' )->where( 'status', 'ACTIVE' )->first();

            //START:: check number of wrong attempts
            $checkIfExist = User::where( 'email', $request->email )->first();
            if ( $checkIfExist ) {

                $getAttemptsCount = UserLoginAttempts::where( 'user_id', $checkIfExist->id )->first();
                if ( $getAttemptsCount ) {

                    if ( $getAttemptsCount->attempt_counts == $getMaxAttempt->amount ) {

                        $updateAttempts = UserLoginAttempts::find( $getAttemptsCount->id );
                        $updateAttempts->attempt_counts = $getMaxAttempt->amount;
                        $updateAttempts->save();

                        //START:: block user
                        $updateUser = User::find( $checkIfExist->id );
                        $updateUser->status = 'BLOCKED';
                        $updateUser->save();
                        //END:: block user

                        // Auth::guard( 'web' )->logout();
                        toastr();
                        return redirect( '/suspended' )->with( 'error', 'You have been suspended. Kindly, contact system administrator for assistance' );
                    } else {
                        if ( $getAttemptsCount->attempt_counts < $getMaxAttempt->amount ) {

                            $updateAttempts = UserLoginAttempts::find( $getAttemptsCount->id );
                            $updateAttempts->attempt_counts = $getAttemptsCount->attempt_counts+1;
                            $updateAttempts->save();

                            $lastAttempt = $getMaxAttempt->amount-$updateAttempts->attempt_counts;

                            if ( $lastAttempt == 2 ) {

                                $subText = 'You have only 2 last attempts if you get them wrong your account will be suspended.';
                            } elseif ( $lastAttempt == 1 ) {

                                $subText = 'You have only 1 last attempt if you get it wrong your account will be suspended.';
                            } else {
                                $subText = '';
                            }
                            toastr();

                            return redirect( '/login' )->with( 'error', 'Credentials Combination is not correct: '.$subText.'Kindly, Use forget password instead' );

                        } else {
                            // Auth::guard( 'web' )->logout();
                            toastr();
                            return redirect( '/suspended' )->with( 'error', 'You have been suspended. Kindly, contact system administrator for assistance' );
                        }
                    }

                } else {
                    $createAttempt = new UserLoginAttempts;
                    $createAttempt->user_id = $checkIfExist->id;
                    $createAttempt->attempt_counts = 1;
                    $createAttempt->save();
                    toastr();
                    return redirect( '/login' )->with( 'error', 'Credentials Combination is not correct' );
                }

            } else {
                toastr();
                return redirect( '/login' )->with( 'error', 'Credentials Combination is not correct' );
            }
            //END:: check number of wrong attempts
        }

        //END:: UN AUTHORIZED USER OPERATIONS

        //START:: last login
        $getLastLogin = User::find( Auth::user()->id );

        if ( $getLastLogin->status == 'ACTIVE' ) {

            //START:: check Password Status
            if ( $getLastLogin->password_status == 'DEFAULT' ) {
                Auth::guard( 'web' )->logout();
                // log out the user
                toastr();
                return redirect( '/reset/password' )->with( 'warning', 'You need to change Password. A default password is not secure' );
            }
            //END:: check Password Status

            if ( $getLastLogin->last_login == 'NULL' ) {
                $getLastLogin->last_login = date( 'Y-m-d H:i:s' );
                $getLastLogin->save();
            } else {
                //START::checking IDLE TIME ALLOWED
                $getMaxInactiveTime = ConstantValue::where( 'item_type', 'IDLE TIME ALLOWED' )->first();
                $lastLoginDate = Carbon::parse( $getLastLogin->last_login );
                $toDate = Carbon::now();

                $numberOfDays = $lastLoginDate->diffInDays( $toDate );
                $updateUser = User::find( Auth::user()->id );
                if ( $numberOfDays >= $getMaxInactiveTime->amount ) {
                    // Login interval is too long enough to be suspended
                    //START:: block user
                    $updateUser->status = 'BLOCKED';
                    $updateUser->save();

                    Auth::guard( 'web' )->logout();
                    // log out the user

                    return redirect( '/login' );
                    //END:: block user
                }

                $getLastLogin->last_login = date( 'Y-m-d H:i:s' );
                $getLastLogin->save();

                //END::checking IDLE TIME ALLOWED
            }

            //START::remove in wrong attempts
            $getAttemptsCount = UserLoginAttempts::where( 'user_id', Auth::user()->id )->first();
            if ( $getAttemptsCount ) {
                $id = $getAttemptsCount->id;
                $deleteID = UserLoginAttempts::find( $id );
                $deleteID->delete();
            }
            //END::remove in wrong attempts
        } else {
            Auth::guard( 'web' )->logout();
            toastr();
            return redirect( '/suspended' )->with( 'error', 'You have been suspended. Kindly, contact system administrator for assistance' );
        }

        RateLimiter::clear( $request->throttleKey() );

        $request->session()->regenerate();

        // Log out other devices
        Auth::logoutOtherDevices( $request->password );

        return redirect()->intended( RouteServiceProvider::HOME );
    }

    public function suspendedUser() {
        return view( 'auth.user_suspended' );
    }

    /**
    * Destroy an authenticated session.
    */

    public function destroy( Request $request ): RedirectResponse {
        Auth::guard( 'web' )->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect( '/login' );
    }

}

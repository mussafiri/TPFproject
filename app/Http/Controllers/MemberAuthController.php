<?php

namespace App\Http\Controllers;

use App\Models\ConstantValue;
use App\Models\Member;
use App\Models\MemberLoginAttempts;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Foundation\Auth\ThrottlesLogins;

class MemberAuthController extends Controller {
    
    public function forgotPassword() {
        return view( 'member_portal.auth.member_forgot_password' );

    }

    public function changePassword() {
        return view( 'member_portal.auth.member_change_password' );

    }

    public function passwordReset() {
        return view( 'member_portal.auth.member_reset_password' );
    }

    public function veryAccount() {
        return view( 'member_portal.auth.member_verify_account' );
    }

    public function login() {
        return view( 'member_portal.auth.member_login' );
    }

    public function suspendedMember(){
        return view( 'member_portal.auth.member_suspended' );
    }


    public function authenticateMember( Request $request ) {
        $credentials = $request->only( 'member_code', 'password' );
        if ( Auth::guard( 'member' )->attempt( $credentials ) ) {

                //START:: last login
                    $getLastLogin= Member::find(Auth::guard('member')->user()->id);
                     if($getLastLogin->status=='ACTIVE'){  

                            //START:: check Password Status
                            
                            //END:: check Password Status

                            if($getLastLogin->last_login=='NULL'){
                                $getLastLogin->last_login=date('Y-M-D H:i:s');
                                $getLastLogin->save();

                            }else{
                                //START::checking IDLE TIME ALLOWED
                                $getMaxInactiveTime= ConstantValue::where('item_type','IDLE TIME ALLOWED')->first();
                                $lastLoginDate = Carbon::parse($getLastLogin->last_login);
                                $toDate = Carbon::now();

                                $numberOfDays = $lastLoginDate->diffInDays($toDate);

                                if($numberOfDays >= $getMaxInactiveTime->amount){ // Login interval is too long enough to be suspended
                                    //START:: block user
                                    $updateMember = Member::find( Auth::guard('member')->user()->id );
                                    $updateMember->status = 'BLOCKED';
                                    $updateMember->save();

                                    Auth::guard( 'web' )->logout(); // log out the user
                                    toastr();
                                    return redirect( 'member/suspended' )->with( 'error','You have been suspended. Kindly, contact system administrator for assistance' );
                                    //END:: block user
                                }
                                //END::checking IDLE TIME ALLOWED
                            }

                            //START::remove in wrong attempts
                            $getAttemptsCount = MemberLoginAttempts::where( 'member_id', Auth::guard('member')->user()->id )->first();
                            if($getAttemptsCount){
                                $id = $getAttemptsCount->id;
                                $deleteID = MemberLoginAttempts::find($id);
                                $deleteID->delete();
                            }
                            //END::remove in wrong attempts
                        //END:: last login

                        toastr();
                        return redirect()->intended( '/member/dashboard' )->with('success','Access to TPF Platform granted');
                }else{
                    Auth::guard( 'member' )->logout();
                    toastr();
                    return redirect( 'member/suspended' )->with( 'error','You have been suspended. Kindly, contact system administrator for assistance' );
                }

        } else {
            //START:: UN AUTHORIZED USER OPERATIONS
            // RateLimiter::hit( $request->throttleKey() );

            $getMaxAttempt = ConstantValue::where( 'item_type', 'MAXIMUM WRONG LOGIN ATTEMPTS' )->where( 'status', 'ACTIVE' )->first();

            //START:: check number of wrong attempts
            $checkIfExist = Member::where( 'member_code', $request->member_code )->first();
            if ( $checkIfExist ) {

                $getAttemptsCount = MemberLoginAttempts::where( 'member_id', $checkIfExist->id )->first();
                if ( $getAttemptsCount ) {

                    if ( $getAttemptsCount->attempt_counts == $getMaxAttempt->amount ) {

                        $updateAttempts = MemberLoginAttempts::find( $getAttemptsCount->id );
                        $updateAttempts->attempt_counts = $getMaxAttempt->amount;
                        $updateAttempts->save();
                        //START:: block user
                        $updateMember = Member::find( $checkIfExist->id );
                        $updateMember->status = 'BLOCKED';
                        $updateMember->save();
                        //END:: block user

                        // Auth::guard( 'web' )->logout();
                            toastr();
                            return redirect( 'member/suspended' )->with( 'error','You have been suspended. Kindly, contact system administrator for assistance' );
                    } else {
                        if ( $getAttemptsCount->attempt_counts < $getMaxAttempt->amount ) {

                            $updateAttempts = MemberLoginAttempts::find( $getAttemptsCount->id );
                            $updateAttempts->attempt_counts = $getAttemptsCount->attempt_counts+1;
                            $updateAttempts->save();
                                                                  
                            $lastAttempt = $getMaxAttempt->amount-$updateAttempts->attempt_counts;

                            if ( $lastAttempt ==2) {

                                $subText = 'You have only 2 last attempts if you get them wrong your account will be suspended.';
                            } elseif ( $lastAttempt ==1) {

                                $subText = 'You have only 1 last attempt if you get it wrong your account will be suspended.';
                            } else {
                                $subText = '';
                            }
                            toastr();

                            return redirect( '/member/login' )->with( 'error','Credentials Combination is not correct: '.$subText.'Kindly, Use forget password instead' );

                        } else {
                            // Auth::guard( 'web' )->logout();
                            
                            toastr();
                            return redirect( '/member/suspended' )->with( 'error','You have been suspended. Kindly, contact system administrator for assistance' );
                        }
                    }

                } else {
                    $createAttempt = new MemberLoginAttempts;
                    $createAttempt->member_id = $checkIfExist->id;
                    $createAttempt->attempt_counts = 1;
                    $createAttempt->save();
                    
                    toastr();
                    return redirect( '/member/login' )->with('error','Credentials Combination is not correct' );
                }

            } else {
                
                toastr();
                return redirect( '/member/login' )->with('error','Credentials Combination is not correct' );
            }
            //END:: check number of wrong attempts
            //END:: UN AUTHORIZED USER OPERATIONS
  
            toastr();
            return redirect()->back()->with( 'error','The provided credentials are incorrect.' );
        }
    }


    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('member')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('member/login');
    }

}

<?php

namespace App\Http\Controllers\Auth;
//Administrator!23
use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\MemberPasswordChange;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\PasswordChange;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => [ 'required', Password::min(8)
                                ->letters()
                                ->mixedCase()
                                ->numbers()
                                ->symbols()
                                ->uncompromised(), 
                            'confirmed',
            ],
        ]);

        // START::CHECK IF PASSWORD EXIT
        $passwordCheck = PasswordChange::where('user_id', Auth::user()->id)->get();
        if($passwordCheck){
            foreach ($passwordCheck as $data) {
                if (Hash::check($request->password, $data->password)) {
                    toastr();
                    return redirect('profile/' . Crypt::encryptString(2))->with('error','Kindly! Enter new password, do not enter one used before');
                } else {
                }
            }
        }
        // END::CHECK IF PASSWORD EXIT

        $updateUser = User::find(Auth::user()->id);
        $updateUser->password = Hash::make($request->password);
        $updateUser->password_changed_at = date('Y-m-d H:i:s');
        $updateUser->password_status = 'ACTIVE';
        $updateUser->save();

        $savePassword = new PasswordChange();
        $savePassword->user_id = Auth::user()->id;
        $savePassword->password = Hash::make($request->password);
        $savePassword->created_by = Auth::user()->id;
        $savePassword->save();

        Auth::guard('web')->logout();
        toastr();
        return redirect('/login')->with(['success' => 'You have Successfully updated password. You can login with a  changed password']);
    }

    public function memberUpdate(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => [ 'required', Password::min(8)
                                ->letters()
                                ->mixedCase()
                                ->numbers()
                                ->symbols()
                                ->uncompromised(), 
                            'confirmed',
            ],
        ]);

        // START::CHECK IF PASSWORD EXIT
        $passwordCheck = MemberPasswordChange::where('user_id', Auth::user()->id)->get();
        if($passwordCheck){
            foreach ($passwordCheck as $data) {
                if (Hash::check($request->password, $data->password)) {
                    toastr();
                    return redirect('member/profile/' . Crypt::encryptString(2))->with('error','Kindly! Enter new password, do not enter one used before');
                } else {
                }
            }
        }
        // END::CHECK IF PASSWORD EXIT

        $updateUser = Member::find(Auth::user()->id);
        $updateUser->password = Hash::make($request->password);
        $updateUser->password_changed_at = date('Y-m-d H:i:s');
        $updateUser->password_status = 'ACTIVE';
        $updateUser->save();

        $savePassword = new MemberPasswordChange();
        $savePassword->user_id = Auth::user()->id;
        $savePassword->password = Hash::make($request->password);
        $savePassword->created_by = Auth::user()->id;
        $savePassword->save();

        Auth::guard('member')->logout();
        toastr();
        return redirect('/member/login')->with(['success' => 'You have Successfully updated password. You can login with a  changed password']);
    }
}

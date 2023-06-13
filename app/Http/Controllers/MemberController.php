<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\Contributor;
use App\Models\MemberIdentityType;
use App\Models\MemberSalutation;

class MemberController extends Controller {
    public function index() {

    }
    public function members() {
        $members = Member::limit(500)->get();
        return view('members.members_list', ['members'=>$members]);
    }
    public function regMemberView() {
        $salutation_title=MemberSalutation::where("status","ACTIVE")->get();
        $contributors=Contributor::where("status","ACTIVE")->get();
        $identity_types=MemberIdentityType::where("status","ACTIVE")->get();
        return view('members.member_registration_form', ['contributors'=>$contributors,"titles"=>$salutation_title,"ids"=>$identity_types]);
    }
    public function submitMemberRegistration(Request $request) {

    }

}

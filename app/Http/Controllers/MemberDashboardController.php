<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MemberDashboardController extends Controller {
    public function index() {
        return view( 'member_portal.member_dashboard' );
    }
}

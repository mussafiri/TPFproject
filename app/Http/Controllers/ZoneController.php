<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Zone;


class ZoneController extends Controller
{
    //
    public function zones(){
        $zones = Zone::all();
        return view('zones.zones', ['zones'=>$zones]);
    }

    public function updateZonesStatus(){

    }
}

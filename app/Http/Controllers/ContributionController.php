<?php

namespace App\Http\Controllers;

use App\Models\Scheme;
use App\Models\Section;
use Illuminate\Http\Request;

class ContributionController extends Controller {

    public function addContribution() {
        $sections = Section::where( 'status', 'ACTIVE' )->get();
        $schemes = Scheme::where( 'status', 'ACTIVE' )->get();
        return view( 'contributions.contributions_add', [ 'sections'=>$sections, 'schemes'=>$schemes ] );
    }
}

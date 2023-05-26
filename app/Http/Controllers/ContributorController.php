<?php

namespace App\Http\Controllers;

use App\Models\ContributorType;
use Illuminate\Http\Request;

class ContributorController extends Controller {

    public function contributorsCategory() {
        $contrCateg = ContributorType::all();
        return view( 'contributor.contributorsCategory', [ 'contrCateg'=>$contrCateg ] );
    }

    public function contributors() {
        return view( 'contributor.contributorsList' );
    }
}

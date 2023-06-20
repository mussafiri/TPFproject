<?php

namespace App\Http\Controllers;

use App\Models\ContributorCatContrStructure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class ContributorratesController extends Controller
{
    public function contributionStructure ($status ) {
        $status = Crypt::decryptString( $status );
        $contributorRates = ContributorCatContrStructure::where( 'status', $status )->get();
    
        return view( 'contributor.contributor_contr_structure', compact( 'contributorRates','status' ) );
    }
}

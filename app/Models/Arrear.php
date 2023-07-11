<?php

namespace App\Models;

use App\Lib\Common;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Arrear extends Model
{
    use HasFactory;

    public function section(){
        return $this->belongsTo(Section::class , 'section_id');
    }

    public function totalContributors($sectionID){

        $countContributors = Contributor::where( 'section_id', $sectionID )->count();
        return $countContributors;
    }

    public function totalMembers($sectionID){
        $totalMembers = Contributor::join( 'members', 'members.contributor_id', '=', 'contributors.id' )
        ->where( 'contributors.section_id', $sectionID )
        ->count();
        return $totalMembers;
    }

    public function arrearTotalContributionExpected($sectionID, $arear_date){
        $cmn = new Common();
        $arrearTotalContribution = $cmn->arrearTotalContribution($sectionID, $arear_date);
        return $arrearTotalContribution;
    } 

    public function arrearTotalPenaltyExpected($totalSectionContribution, $arrearID, $current_date){
        $cmn = new Common();
        $arrearTotalPenaltyRate = $cmn->arrearsPenaltyComputation( $arrearID, $current_date);
        $arrearTotalPenalty = $totalSectionContribution * $arrearTotalPenaltyRate;
        return $arrearTotalPenalty;
    }
    
    public function arrearAge($arrearID, $current_date){
        $cmn = new Common(); 
        $getArrearData = Arrear::find( $arrearID );
        $arrear_period = $getArrearData->arrear_period.'-01';

        $arrearTotalPenalty = $cmn->arrearElapsedDaysAlgorithm( $arrear_period, $current_date );
        return $arrearTotalPenalty;
    }

    public function sectionPenatyPaid($arrearID, $sectionID){
        $totalPaid = ArrearPenaltyPayment::where('arrear_id',$arrearID)
        ->where('section_id',$sectionID)
        ->where('status', 'COMPLETED')
        ->where('type','SECTION PAY')
        ->sum('pay_amount');
        return $totalPaid;
    }
}

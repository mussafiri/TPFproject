<?php

namespace App\Models;

use App\Lib\Common;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArrearDetail extends Model
{
    use HasFactory;

    public function arrear() {
        return $this->belongsTo( Arrear::class, 'arrear_id' );
    }

    public function createdBy() {
        return $this->belongsTo( User::class, 'created_by' );
    }

    public function updatedBy() {
        return $this->belongsTo( User::class, 'updated_by' );
    }
    public function contributor() {
        return $this->belongsTo( Contributor::class, 'contributor_id' );
    }
    
    public function member() {
        return $this->belongsTo( Member::class, 'member_id' );
    }

    public function getMemberMonthlyIncome( $memberID ) {
        $cmn = new Common();
        $memberIcome = $cmn ->memberMonthlyIncome( $memberID );
        return $memberIcome;
    }

    public function getContributorMonthlyIncome( $contributorID ) {
        $cmn = new Common();
        $contributorContribution = $cmn->contributorMonthlyIncome( $contributorID );
        return $contributorContribution;
    }

    public function getMemberContributionAmount( $contributorID, $memberID ) {
        $cmn = new Common();
        $memberContribution = $cmn->memberContributionAmount( $contributorID, $memberID );
        return $memberContribution;
    }

    public function getContributorContributionAmount( $contributorID, $memberID ) {
        $cmn = new Common();
        $contributorContribution = $cmn->contributorContributionAmount( $contributorID, $memberID );
        return $contributorContribution;
    }

    public function totalMemberArrearPenaltyExpected($memberContribution, $arrearID, $current_date){
        $cmn = new Common();
        $arrearTotalPenaltyRate = $cmn->arrearsPenaltyComputation( $arrearID, $current_date);
    
        $arrearTotalPenalty     = $arrearTotalPenaltyRate * $memberContribution;
        return $arrearTotalPenalty;
    }
    public function memberPenatyPaid($arrearID, $sectionID){
        $totalPaid = ArrearPenaltyPayment::where('arrear_id',$arrearID)
        ->where('section_id',$sectionID)
        ->where('arrear_detail_id','>',0)
        ->where('status', 'COMPLETED')
        ->where('type','MEMBER PAY')
        ->sum('pay_amount');
        return $totalPaid;
    }

    public function arrearAge($arrearID, $current_date){
        $cmn = new Common(); 
        $getArrearData = Arrear::find( $arrearID );
        $arrear_period = $getArrearData->arrear_period.'-01';

        $arrearTotalPenalty = $cmn->arrearElapsedDaysAlgorithm( $arrear_period, $current_date );
        return $arrearTotalPenalty;
    }
}

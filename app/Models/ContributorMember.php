<?php

namespace App\Models;

use App\Lib\Common;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContributorMember extends Model {
    use HasFactory;

    public function transferedBy() {
        return $this->belongsTo( User::class, 'created_by' );
    }
    public function member() {
        return $this->belongsTo( Member::class, 'member_id' );
    }

    public function contributor() {
        return $this->belongsTo( Contributor::class, 'contributor_id' );
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

    public function totalMemberArrearPenaltyExpected($totalMemberContribution, $arrearID, $current_date){
        $cmn = new Common();
        $arrearPenaltyRate = $cmn->arrearsPenaltyComputation( $arrearID, $current_date);

        $totalMemberArrearPenalty = $totalMemberContribution*$arrearPenaltyRate;

        return $totalMemberArrearPenalty;
    }

}

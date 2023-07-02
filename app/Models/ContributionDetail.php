<?php

namespace App\Models;

use App\Lib\Common;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContributionDetail extends Model
{
    use HasFactory;
    public function contribution() {
        return $this->belongsTo( Contribution::class, 'contribution_id' );
    }

    public function contributor() {
        return $this->belongsTo( Contributor::class, 'contributor_id' );
    }

    public function member() {
        return $this->belongsTo( Member::class, 'member_id' );
    }

    public function payMode() {
        return $this->belongsTo( PaymentMode::class, 'pay_mode_id' );
    }

    public function approvedBy() {
        return $this->belongsTo( User::class, 'approved_by' );
    }

    public function createdBy() {
        return $this->belongsTo( User::class, 'user_id' );
    }

    public function updatedBy() {
        return $this->belongsTo( User::class, 'updated_by' );
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
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contribution extends Model {
    use HasFactory;

    public function section() {
        return $this->belongsTo( Section::class, 'section_id' );
    }

    public function payMode() {
        return $this->belongsTo( PaymentMode::class, 'payment_mode_id' );
    }

    public function createdBy() {
        return $this->belongsTo( User::class, 'created_by' );
    }

    public function approvedBy() {
        return $this->belongsTo( User::class, 'approved_by' );
    }

    public function approvalRejectedBy() {
        return $this->belongsTo( User::class, 'approval_rejected_by' );
    }

    public function postedBy() {
        return $this->belongsTo( User::class, 'posted_by' );
    }

    public function postingRejectedBy() {
        return $this->belongsTo( User::class, 'posting_rejected_by' );
    }

    public function updatedBy() {
        return $this->belongsTo( User::class, 'updated_by' );
    }


    public function sumTransaction( $contritbutionID ) {
        $totalTopup = ContributionDetail::where( 'contribution_id', $contritbutionID )->sum( 'member_contribution' );
        return $totalTopup;
    }

    public function sumTopup( $contritbutionID ) {
        $totalTopup = ContributionDetail::where( 'contribution_id', $contritbutionID )->sum( 'member_topup' );
        return $totalTopup;
    }
}

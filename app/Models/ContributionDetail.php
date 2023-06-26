<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContributionDetail extends Model
{
    use HasFactory;

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
}

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
}

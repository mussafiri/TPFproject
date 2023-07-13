<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArrearPenaltyPayment extends Model
{
    use HasFactory;
    
    public function arrear(){
        return $this->belongsTo(Arrear::class , 'arrear_id');
    }

    public function section(){
        return $this->belongsTo(Section::class , 'section_id');
    }

    public function arrearDetail(){
        return $this->belongsTo(ArrearDetail::class , 'arrear_detail_id');
    }

    public function payMode(){
        return $this->belongsTo(PaymentMode::class , 'payment_mode_id');
    }

    public function createdBy(){
        return $this->belongsTo(User::class , 'created_by');
    }

    public function rejectedBy(){
        return $this->belongsTo(User::class , 'rejected_by');
    }
    
    public function updatedBy(){
        return $this->belongsTo(User::class , 'updated_by');
    }

    public function rejectedReason(){
        return $this->belongsTo(User::class , 'rejected_reason_id');
    }
}

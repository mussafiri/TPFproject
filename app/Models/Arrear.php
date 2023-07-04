<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Arrear extends Model
{
    use HasFactory;

    public function contributionDetials(){
        return $this->belongsTo(ContributionDetail::class, 'contribution_details_id');
    }
}

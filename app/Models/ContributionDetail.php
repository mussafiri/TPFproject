<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContributionDetail extends Model
{
    use HasFactory;
    public function contribution() {
        return $this->belongsTo( Contribution::class, 'contribution_id');
    }
    public function contributor() {
        return $this->belongsTo( Contributor::class, 'contributor_id');
    }
    public function createdBy() {
        return $this->belongsTo( User::class, 'created_by');
    }
}

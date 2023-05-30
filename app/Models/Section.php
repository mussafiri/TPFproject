<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;
    public function contributor() {
        return $this->hasMany( Contributor::class, 'section_id' );
    }
    public function district() {
        return $this->belongsTo( District::class, 'district_id' );
    }
}

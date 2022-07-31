<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookmarkedProject extends Model
{
    public function project(){
        return $this->belongsTo(Project::class);
    }
}

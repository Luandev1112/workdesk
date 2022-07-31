<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class BookmarkedFreelancer extends Model
{
    public function freelancer(){
        return $this->belongsTo(User::class, 'freelancer_user_id');
    }
}

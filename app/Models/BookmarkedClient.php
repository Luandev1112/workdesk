<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class BookmarkedClient extends Model
{
    public function client(){
        return $this->belongsTo(User::class, 'client_user_id');
    }
}

<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CancelProject extends Model
{
    use SoftDeletes;
    public function requested_user()
    {
        return $this->belongsTo(User::class, 'requested_user_id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}

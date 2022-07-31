<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
    use SoftDeletes;
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_user_id');
    }

    public function reviewed()
    {
        return $this->belongsTo(User::class, 'reviewed_user_id');
    }

    public function reviewed_role()
    {
        return $this->belongsTo(Role::class, 'reviewed_user_role_id');
    }
}

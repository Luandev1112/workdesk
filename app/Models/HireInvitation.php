<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HireInvitation extends Model
{
    use SoftDeletes;

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'sent_by_user_id');
    }

    public function freelancer()
    {
        return $this->belongsTo(User::class, 'sent_to_user_id');
    }
}

<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MilestonePayment extends Model
{
    use SoftDeletes;

    public function client()
    {
        return $this->belongsTo(User::class, 'client_user_id');
    }

    public function freelancer()
    {
        return $this->belongsTo(User::class, 'freelancer_user_id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}

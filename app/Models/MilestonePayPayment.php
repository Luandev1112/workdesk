<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MilestonePayPayment extends Model
{
    use SoftDeletes;

    public function milestone_request()
    {
        return $this->belongsTo(MilestonePayment::class, 'milestone_payment_id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'client_user_id');
    }
    public function freelancer()
    {
        return $this->belongsTo(User::class, 'freelancer_user_id');
    }
}

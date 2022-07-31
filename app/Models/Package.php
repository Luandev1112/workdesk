<?php

namespace App\Models;

use App\Models\PackagePayment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Package extends Model
{
    use SoftDeletes;
    public function scopeFreelancer($query)
    {
        return $query->where('type', 'freelancer');
    }

    public function scopeClient($query)
    {
        return $query->where('type', 'client');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function package_payments(){
        return $this->hasMany(PackagePayment::class);
    }
}

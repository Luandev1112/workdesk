<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Service;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServicePackage extends Model
{
    use SoftDeletes;
    protected $guarded = [];
    protected $table = 'freelancer_services_packages';

    public function service()
    {
        return $this->belongsTo(Service::class)->withTrashed();
    }

    public function scopeBasic($query)
    {
        return $query->where('service_type', 'basic');
    }

    public function scopeStandard($query)
    {
        return $query->where('service_type', 'standard');
    }

    public function scopePremium($query)
    {
        return $query->where('service_type', 'premium');
    }

}

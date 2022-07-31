<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\User;
use App\Models\ProjectCategory;

class Service extends Model
{
    use SoftDeletes;
    protected $guarded = [];
    protected $table = 'freelancer_services';

    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function category()
    {
        return $this->belongsTo(ProjectCategory::class, 'project_cat_id')->withTrashed();
    }

    public function service_packages()
    {
        return $this->hasMany(ServicePackage::class)->withTrashed();
    }
}

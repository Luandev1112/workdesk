<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServicePackagePayment extends Model
{
    use SoftDeletes;
    protected $guarded = [];
    protected $table = 'service_payments';

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function servicePackage(){
        return $this->belongsTo(ServicePackage::class)->withTrashed();
    }

    public function freelancer() {
        return $this->belongsTo(User::class, 'service_owner_id');
    }

}

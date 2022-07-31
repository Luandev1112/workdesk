<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Address;
use App\Models\Transaction;
use App\Models\UserBadge;
use App\Models\UserProfile;
use App\Models\UserRole;
use App\Models\Project;
use App\Models\Review;
use App\Models\ProjectBid;
use App\Models\ProjectUser;
use App\Models\Portfolio;
use App\Models\UserPackage;
use App\Models\Verification;
use App\Models\WorkExperience;
use App\Models\EducationDetail;
use App\Models\Service;
use App\Models\ServicePackagePayment;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;
    use HasRoles;

    protected $fillable = [
        'name', 'email', 'password', 'user_name'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function address()
    {
        return $this->morphOne(Address::class, 'addressable');
    }

    public function userPackage()
    {
        return $this->hasOne(UserPackage::class);
    }

    public function profile()
    {
        return $this->hasOne(UserProfile::class);
    }

    public function badges()
    {
        return $this->hasMany(UserBadge::class);
    }

    public function verifications()
    {
        return $this->hasMany(Verification::class);
    }

    public function workExperiences()
    {
        return $this->hasMany(WorkExperience::class);
    }

    public function userRoles()
    {
        return $this->hasMany(UserRole::class);
    }

    public function userPortfolios()
    {
        return $this->hasMany(Portfolio::class);
    }

    public function userVerifications()
    {
        return $this->hasMany(Verification::class);
    }

    public function bids()
    {
        return $this->hasMany(ProjectBid::class, 'bid_by_user_id');
    }

    public function projectUsers()
    {
        return $this->hasMany(ProjectUser::class);
    }

    public function number_of_projects()
    {
        return $this->hasMany(Project::class, 'client_user_id');
    }

    public function education_details()
    {
        return $this->hasMany(EducationDetail::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'reviewed_user_id')->where('published', 1);
    }

    public function services()
    {
        return $this->hasMany(Service::class);
    }

    public function purchasedServices()
    {
        return $this->hasMany(ServicePackagePayment::class);
    }
}

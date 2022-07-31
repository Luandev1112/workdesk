<?php


namespace App\Repositories\Badge;


use Illuminate\Http\Request;

interface BadgeInterface
{
    public function getBadgesAndRole($type);

    public function createBadge(Request $request);
}

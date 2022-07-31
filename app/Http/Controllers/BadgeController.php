<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Repositories\Badge\BadgeInterface;
use Illuminate\Http\Request;
use App\Models\Badge;
use App\Models\Role;


class BadgeController extends Controller
{
    protected $repository;

    public function __construct(BadgeInterface $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        list($badges, $role) = $this->repository->getBadgesAndRole('freelancer');
        return view('admin.default.freelancer.badges.index', compact('badges','role'));
    }

    public function client_badges_index()
    {
        list($badges, $role) = $this->repository->getBadgesAndRole('client');
        return view('admin.default.client.badges.index', compact('badges','role'));
    }

    public function store(Request $request)
    {
        $badge          = new Badge;
        $badge->name    = $request->name;
        $badge->type    = $request->type;
        $badge->value   = $request->value;
        $badge->role_id = $request->role_id;
        $badge->icon    = $request->icon;
        $badge->save();

        flash(translate('New Badge has been updated successfully!'))->success();
        if ($request->role_id == "freelancer") {
            return redirect()->route('badges.index');
        }
        if ($request->role_id == "client") {
            return redirect()->route('client_badges_index');
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $badge = Badge::findOrFail(decrypt($id));
        return view('admin.default.freelancer.badges.edit', compact('badge'));
    }

    public function client_badges_edit($id)
    {
        $badge = Badge::findOrFail(decrypt($id));
        return view('admin.default.client.badges.edit', compact('badge'));
    }

    public function update(Request $request, $id)
    {
        $badge          = Badge::findOrFail($id);
        $badge->name    = $request->name;
        $badge->type    = $request->type;
        $badge->value   = $request->value;
        $badge->icon    = $request->icon;
        $badge->save();

        flash(translate('New Badge has been updated successfully!'))->success();
        if ($request->role_id == "freelancer") {
            return redirect()->route('badges.index');
        }
        if ($request->role_id == "client") {
            return redirect()->route('client_badges_index');
        }

    }

    public function destroy($id)
    {
        $badge = Badge::destroy($id);
        flash('Badge has been deleted successfully')->success();
        return back();
    }
}

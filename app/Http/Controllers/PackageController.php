<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Package;
use App\Models\UserProfile;
use App\Models\UserPackage;
use App\Models\Role;
use Auth;
use Session;

class PackageController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:show freelancer packages|show client packages'])->only('index');
        $this->middleware(['permission:create new freelancer package|create new freelancer package'])->only('create');
    }

    public function index($type)
    {
        $packages = Package::latest()->where('type', $type)->paginate(10);
        if ($type == 'freelancer') {
            return view('admin.default.freelancer.packages.index', compact('packages'));
        }
        elseif ($type == 'client') {
            return view('admin.default.client.packages.index', compact('packages'));
        }

    }

    public function create($type)
    {
        if ($type == 'freelancer') {
            return view('admin.default.freelancer.packages.create');
        }
        elseif ($type == 'client') {
            return view('admin.default.client.packages.create');
        }

    }

    public function store(Request $request){
        $package        = new Package;
        $package->type  = $request->type;
        $package->name  = $request->name;
        $package->price = $request->price;
        $package->badge = $request->badge;
        $package->photo = $request->photo;
        $package->number_of_days = $request->number_of_days;
        if ($request->type == 'freelancer') {
            $package->commission = $request->commission;
            $package->commission_type = $request->commission_type;
        }
        else {
            $package->commission = 0;
            $package->commission_type = 'amount';
        }

        $package->fixed_limit = $request->fixed_limit;
        $package->long_term_limit = $request->long_term_limit;
        if ($request->skill_add_limit != null && $request->portfolio_add_limit != null & $request->job_experience_limit != null && $request->project_bookmark_limit != null) {
            $package->skill_add_limit = $request->skill_add_limit;
            $package->portfolio_add_limit = $request->portfolio_add_limit;
            $package->job_exp_limit = $request->job_experience_limit;
            $package->bookmark_project_limit = $request->project_bookmark_limit;
            $package->service_limit = $request->service_limit;
        }

        if ($request->following_status != null) {
            $package->following_status = 1;
        }
        else {
            $package->following_status = 0;
        }
        $package->bio_text_limit = $request->bio_text_limit;
        if ($request->active != null) {
            $package->active = 1;
        }
        else {
            $package->active = 0;
        }
        if ($request->recommended != null) {
            $package->recommended = 1;
        }
        else {
            $package->recommended = 0;
        }
        if ($package->save()) {
            flash('New Package has been inserted successfully')->success();
            return redirect()->route($request->type.'_package.index',$request->type);
        }
    }

    public function edit($id)
    {
        $package = Package::findOrFail(decrypt($id));
        return view('admin.default.'.$package->type.'.'.'packages.edit', compact('package'));
    }

    public function update(Request $request, $id){
        $package        = Package::findOrFail($id);
        $package->type  = $request->type;
        $package->name  = $request->name;
        $package->price = $request->price;
        $package->badge = $request->badge;
        $package->photo = $request->photo;
        if ($request->number_of_projects != null) {
            $package->number_of_projects = $request->number_of_projects;
        }
        $package->number_of_days = $request->number_of_days;
        $package->commission = $request->commission;
        $package->commission_type = $request->commission_type;

        $package->fixed_limit = $request->fixed_limit;
        $package->long_term_limit = $request->long_term_limit;
        if ($request->skill_add_limit != null && $request->portfolio_add_limit != null & $request->job_experience_limit != null && $request->project_bookmark_limit != null) {
            $package->skill_add_limit = $request->skill_add_limit;
            $package->portfolio_add_limit = $request->portfolio_add_limit;
            $package->job_exp_limit = $request->job_experience_limit;
            $package->bookmark_project_limit = $request->project_bookmark_limit;
            $package->service_limit = $request->service_limit;
        }

        if ($request->following_status != null) {
            $package->following_status = 1;
        }
        else {
            $package->following_status = 0;
        }
        $package->bio_text_limit = $request->bio_text_limit;
        if ($request->active != null) {
            $package->active = 1;
        }
        else {
            $package->active = 0;
        }
        if ($request->recommended != null) {
            $package->recommended = 1;
        }
        else {
            $package->recommended = 0;
        }
        if ($package->save()) {
            flash('New Package has been updated successfully')->success();
            return redirect()->route($request->type.'_package.index',$request->type);
        }
        else {
            flash('Sorry! Something went wrong.')->error();
            return back();
        }
    }

    public function destroy($id)
    {
        $package = Package::findOrFail($id);

        if(Package::destroy($id)){
            flash('Package Info has been deleted successfully')->success();
            return redirect()->back();
        }
        return back();
    }

    //Show specific user packages
    public function select_package()
    {
        if (Auth::check()) {
            if (isClient()) {
                $packages = Package::where('type', 'client')->where('active', '1')->get();
                return view('frontend.default.user.client.package_select', compact('packages'));
            }
            elseif (isFreelancer()) {
                $packages = Package::where('type', 'freelancer')->where('active', '1')->get();
                return view('frontend.default.user.freelancer.package_select', compact('packages'));
            }
        }
        else {
            abort(404);
        }
    }

    public function get_package_purchase_modal(Request $request)
    {
        $package = Package::findOrFail($request->id);
        return view('frontend.default.partials.package_purchase_modal', compact('package'));
    }

    public function package_purchase_free($id)
    {
        $package = Package::findOrFail($id);

        $userPackage = Auth::user()->userPackage;
        if($userPackage == null){
            $userPackage = new UserPackage;
            $userPackage->user_id = Auth::user()->id;
        }
        elseif ($userPackage->package_id == $package->id) {
            flash('You are using this package already.')->warning();
            return back();
        }
        $userPackage->package_id = $package->id;
        if($package->number_of_days > 0){
            $userPackage->package_invalid_at = date('Y-m-d', strtotime('+ '.$package->number_of_days.'days'));
        }

        if ($userPackage->fixed_limit == null) {
            $userPackage->fixed_limit = $package->fixed_limit;
        }
        else {
            $userPackage->fixed_limit += $package->fixed_limit;
        }

        if ($userPackage->long_term_limit == null) {
            $userPackage->long_term_limit = $package->long_term_limit;
        }
        else {
            $userPackage->long_term_limit += $package->long_term_limit;
        }

        $userPackage->skill_add_limit = $package->skill_add_limit;
        $userPackage->portfolio_add_limit = $package->portfolio_add_limit;
        $userPackage->job_exp_limit = $package->job_exp_limit;
        $userPackage->bookmark_project_limit = $package->bookmark_project_limit;
        $userPackage->following_status = $package->following_status;
        $userPackage->bio_text_limit = $package->bio_text_limit;
        $userPackage->service_limit = $package->service_limit;

        $userPackage->save();

        flash('New Package has been purchased successfully')->success();
        return redirect()->route('dashboard');
    }
}

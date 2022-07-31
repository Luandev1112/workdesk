<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\WorkExperience;
use Session;
use Auth;

class WorkExperienceController extends Controller
{
    //Adding new work exp info
    public function store(Request $request)
    {
        if(count(Auth::user()->workExperiences) < Auth::user()->userPackage->job_exp_limit){
            $work_exp = new WorkExperience;
            $work_exp->user_id = Auth::user()->id;
            $work_exp->company_name = $request->company_name;
            $work_exp->company_website = $request->company_website;
            $work_exp->designation = $request->designation;
            $work_exp->location = $request->location;
            if ($request->present == 'on') {
                $work_exp->present = '1';
                $work_exp->start = date($request->start_date);
            }
            else {
                $work_exp->present = '0';
                $work_exp->start = date($request->start_date);
                $work_exp->end = date($request->end_date);
            }

            $work_exp->save();
            flash(translate('New work experience has been added successfully'))->success();
            return redirect()->route('user.profile');
        }
        else {
            flash(translate('Sorry! Work experience adding limit has been reached.'))->warning();
            return back();
        }
    }

    //Show edit page to update work exp info
    public function edit($id)
    {
        $work_exp = WorkExperience::findOrFail(decrypt($id));
        if (isFreelancer()) {
            return view('frontend.default.user.freelancer.setting.work_experience_edit', compact('work_exp'));
        }
    }

    //Updating work exp info
    public function update(Request $request, $id)
    {
        $work_exp = WorkExperience::findOrFail($id);
        $work_exp->user_id = Auth::user()->id;
        $work_exp->company_name = $request->company_name;
        $work_exp->company_website = $request->company_website;
        $work_exp->designation = $request->designation;
        $work_exp->location = $request->location;
        if ($request->present == 'on') {
            $work_exp->present = '1';
            $work_exp->start = date($request->start_date);
        }
        else {
            $work_exp->present = '0';
            $work_exp->start = date($request->start_date);
            $work_exp->end = date($request->end_date);
        }

        if ($work_exp->save()) {
            flash(translate('Work Experience has been updated successfully'))->success();
            return redirect()->route('user.profile');
        }
        else {
            flash(translate('Sorry! Something went wrong.'))->error();
            return back();
        }
    }

    public function destroy(Request $request, $id){
        $work_exp = WorkExperience::findOrFail(decrypt($id));
        $work_exp->delete();

        flash(translate('Work Experience has been deleted successfully'))->success();
        return redirect()->route('user.profile');
    }
}

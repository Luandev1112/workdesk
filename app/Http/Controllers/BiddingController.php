<?php

namespace App\Http\Controllers;

use App\Utility\EmailUtility;
use App\Utility\NotificationUtility;
use Illuminate\Http\Request;
use App\Models\ProjectBid;
use App\Models\UserPackage;
use App\Models\Project;
use App\Models\Notification;
use Auth;

class BiddingController extends Controller
{
    // New Bid Request Store
    public function store(Request $request)
    {
        $biddable = false;
        if(Project::findOrFail($request->project_id)->type == 'Fixed'){
            $userPackage = UserPackage::where('user_id', Auth::user()->id)->first();
            if($userPackage->fixed_limit > 0){
                $userPackage->fixed_limit -= 1 ;
                $userPackage->save();

                $biddable = true;
            }
        }
        else{
            $userPackage = UserPackage::where('user_id', Auth::user()->id)->first();
            if($userPackage->long_term_limit > 0){
                $userPackage->long_term_limit -= 1 ;
                $userPackage->save();

                $biddable = true;
            }
        }
        if ($biddable) {
            $bid = new ProjectBid;
            $bid->project_id = $request->project_id;
            $bid->bid_by_user_id = Auth::user()->id;
            $bid->amount = $request->amount;
            $bid->message = $request->message;
            $bid->save();

            $project = Project::where('id',$request->project_id)->first();
            $project->bids ++;
            $project->save();

            //from freelancer to client
            NotificationUtility::set_notification(
                "freelancer_bid_on_project",
                "A new bid has been submitted by",
                route('project.details',['slug'=>$project->slug],false),
                $project->client_user_id,
                Auth::user()->id,
                'client'
            );
            EmailUtility::send_email(
                "A new bid has been submitted",
                "A new bid has been submitted by". Auth::user()->name,
                get_email_by_user_id($project->client_user_id),
                route('project.details',['slug'=>$project->slug])
            );

            flash(translate('Bid has been submitted successfully'))->success();
            return redirect()->back();
        }

        flash(translate('Bid limit has been reached'))->warning();
        return redirect()->back();
    }
}

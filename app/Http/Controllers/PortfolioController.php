<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Portfolio;
use App\Models\Role;
use Session;
use Auth;
use App\Models\UserProfile;

class PortfolioController extends Controller
{
    //New Portfolio Add
    public function store(Request $request)
    {
        if(count(Auth::user()->userPortfolios) < Auth::user()->userPackage->portfolio_add_limit){
            $portfolio = new Portfolio;
            $portfolio->user_id = Auth::user()->id;
            $portfolio->name = $request->portfolio_name;
            $portfolio->type = $request->portfolio_category;
            $portfolio->description = $request->portfolio_details;
            if ($request->portfolio_img != null) {
                $portfolio->photo = $request->portfolio_img;
            }

            $portfolio->save();
            flash(translate('Your Portfolio has been added successfully'))->success();
            return redirect()->route('user.profile');
        }
        else {
            flash(translate('Sorry! Portfolio adding limit has been reached.'))->warning();
            return back();
        }
    }

    public function edit($id)
    {
        $user_portfolio = Portfolio::findOrFail(decrypt($id));
        if (isFreelancer()) {
            return view('frontend.default.user.freelancer.setting.portfolio_edit', compact('user_portfolio'));
        }
    }

    //Existing portfolio update
    public function update(Request $request, $id)
    {
        $portfolio = Portfolio::findOrFail($id);
        $portfolio->user_id = Auth::user()->id;
        $portfolio->name = $request->portfolio_name;
        $portfolio->type = $request->portfolio_category;
        $portfolio->description = $request->portfolio_details;
        if ($request->portfolio_img != null) {
            $portfolio->photo = $request->portfolio_img;
        }
        if ($portfolio->save()) {
            flash(translate('Your Portfolio has been updated successfully'))->success();
            return redirect()->route('user.profile');
        }
        else {
            flash(translate('Sorry! Something went wrong.'))->error();
            return back();
        }
    }

    public function destroy(Request $request, $id){
        $portfolio = Portfolio::findOrFail(decrypt($id));
        $portfolio->delete();

        flash(translate('Portfolio has been deleted successfully'))->success();
        return redirect()->route('user.profile');
    }
}

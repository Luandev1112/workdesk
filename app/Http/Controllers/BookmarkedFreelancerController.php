<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BookmarkedFreelancer;
use Auth;

class BookmarkedFreelancerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bookmarked_freelancers = BookmarkedFreelancer::where('user_id', Auth::user()->id)->paginate(8);
        return view('frontend.default.user.client.bookmarked-freelancers', compact('bookmarked_freelancers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($id)
    {
        $userPackage = Auth::user()->userPackage;
        if($userPackage->following_status){
            $bookmarked_freelancer = new BookmarkedFreelancer;
            $bookmarked_freelancer->user_id = Auth::user()->id;
            $bookmarked_freelancer->freelancer_user_id = decrypt($id);
            $bookmarked_freelancer->save();
        }
        else {
            flash('Freelancer following option is not available on your package.')->warning();
        }

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        BookmarkedFreelancer::destroy($id);
        return back();
    }
}

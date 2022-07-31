<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BookmarkedProject;
use Auth;

class BookmarkedProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bookmarked_projects = BookmarkedProject::where('user_id', Auth::user()->id)->paginate(8);
        return view('frontend.default.user.freelancer.bookmarked-projects', compact('bookmarked_projects'));
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
        if($userPackage->bookmark_project_limit > count(BookmarkedProject::where('user_id', Auth::user()->id)->get())){
            $bookmarked_project = new BookmarkedProject;
            $bookmarked_project->user_id = Auth::user()->id;
            $bookmarked_project->project_id = decrypt($id);
            $bookmarked_project->save();

            $userPackage->bookmark_project_limit--;
            $userPackage->save();
        }
        else {
            flash('Project bookmark limit has been reached.')->warning();
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
        BookmarkedProject::destroy($id);
        $userPackage = Auth::user()->userPackage;
        $userPackage->bookmark_project_limit++;
        $userPackage->save();
        return back();
    }
}

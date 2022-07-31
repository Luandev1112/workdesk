<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Skill;
use Gate;

class SkillController extends Controller
{

    public function __construct()
    {
        $this->middleware(['permission:show freelancer skills'])->only('index');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $skills = Skill::latest()->paginate(10);
        return view('admin.default.freelancer.skills.index', compact('skills'));

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
    public function store(Request $request)
    {
        $skill = new Skill;
        $skill->name = $request->name;
        if ($skill->save()) {
            flash('New Skill has been inserted successfully')->success();
            return redirect()->route('skills.index');
        }
        else {
            flash('Sorry! Something went wrong.')->error();
            return back();
        }
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
        $skill = Skill::findOrFail(decrypt($id));
        return view('admin.default.freelancer.skills.edit', compact('skill'));
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
        $skill = Skill::findOrFail($id);
        $skill->name = $request->name;
        if ($skill->save()) {
            flash('Skill has been Updated successfully')->success();
            return redirect()->route('skills.index');
        }
        else {
            flash('Sorry! Something went wrong.')->error();
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $skill = Skill::findOrFail($id);
        if(Skill::destroy($id)){
            flash('Skill Info has been deleted successfully')->success();
            return redirect()->route('skills.index');
        }
        else {
            flash('Sorry! Something went wrong.')->error();
            return back();
        }
    }
}

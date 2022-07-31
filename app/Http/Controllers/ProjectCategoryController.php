<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProjectCategory;
use App\Utility\CategoryUtility;
use Illuminate\Support\Str;

class ProjectCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:show project category'])->only('index');

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $project_categories = ProjectCategory::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.default.project.project_categories.index', compact('project_categories'));
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
        $project_category = new ProjectCategory;
        $project_category->name = $request->name;
        if ($request->parent_id != null) {
            $project_category->parent_id = $request->parent_id;
        }
        $project_category->photo = $request->photo;
        $project_category->slug = Str::slug($request->name, '-').'-'.Str::random(5);
        if($project_category->save()){
            flash(translate('New Category has been added successfully!'))->success();
            return redirect()->route('project-categories.index');
        }
        else {
            flash(translate('Something went wrong!'))->warning();
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
        $project_category = ProjectCategory::findOrFail(decrypt($id));
        $project_categories = ProjectCategory::whereNotIn('id',CategoryUtility::children_ids($project_category->id,true))->where('id', '!=' , $project_category->id)->get();
        return view('admin.default.project.project_categories.edit', compact('project_category', 'project_categories'));

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
        $project_category = ProjectCategory::findOrFail($id);
        $project_category->name = $request->name;
        if ($request->parent_id != null) {
            $project_category->parent_id = $request->parent_id;
        }
        $project_category->slug = Str::slug($request->name, '-').'-'.Str::random(5);
        $project_category->photo = $request->photo;
        if($project_category->save()){
            flash(translate('New Category has been updated successfully!'))->success();
            return redirect()->route('project-categories.index');
        }
        else {
            flash(translate('Something went wrong!'))->warning();
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
        CategoryUtility::delete_category(decrypt($id));
        flash(translate('Category deleted'))->success();
        return redirect()->route('project-categories.index');
    }
}

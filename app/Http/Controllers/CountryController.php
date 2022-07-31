<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Country;
use Gate;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::allows('country_index')) {
            $countries = Country::paginate(10);
            return view('admin.default.system_configurations.countries.index', compact('countries'));
        }
        else {
            flash(translate('You do not have access permission!'))->warning();
            return back();
        }
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
        $country = new Country;
        $country->name = $request->name;
        $country->code = $request->code;
        if($request->hasFile('icon')){
            $country->photo = $request->file('icon')->store('uploads/images/country');
        }
        if ($country->save()) {
            flash('New Country has been inserted successfully')->success();
            return redirect()->route('countries.index');
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
        if (Gate::allows('country_edit')) {
            $country = Country::findOrFail(decrypt($id));
            return view('admin.default.system_configurations.countries.edit', compact('country'));
        }
        else {
            flash(translate('You do not have access permission!'))->warning();
            return back();
        }
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
        $country = Country::findOrFail($id);
        $country->name = $request->name;
        $country->code = $request->code;
        if($request->hasFile('icon')){
            if ($country->icon) {
                unlink($country->photo);
            }
            $country->photo = $request->file('icon')->store('uploads/images/country');
        }
        if ($country->save()) {
            flash('Country info has been updated successfully')->success();
            return redirect()->route('countries.index');
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
        if (Gate::allows('country_delete')) {
            $country = Country::findOrFail($id);
            if(Country::destroy($id)){
                unlink($country->icon);
                flash('Country has been deleted successfully')->success();
                return redirect()->route('countries.index');
            }
            return back();
        }
        else {
            flash(translate('You do not have access permission!'))->warning();
            return back();
        }
    }
}

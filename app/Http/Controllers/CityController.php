<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\City;
use Gate;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::allows('state_index')) {
            $cities = City::paginate(10);
            return view('admin.default.system_configurations.cities.index', compact('cities'));
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
        $city = new City;
        $city->name = $request->name;
        $city->country_id = $request->country_id;
        if ($city->save()) {
            flash('New City has been inserted successfully')->success();
            return redirect()->route('cities.index');
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
        if (Gate::allows('state_edit')) {
            $city = City::findOrFail(decrypt($id));
            return view('admin.default.system_configurations.cities.edit', compact('city'));
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
        $city = City::findOrFail($id);
        $city->name = $request->name;
        $city->country_id = $request->country_id;
        if ($city->save()) {
            flash('City has been updated successfully')->success();
            return redirect()->route('cities.index');
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
        if (Gate::allows('state_delete')) {
            $city = City::findOrFail($id);
            if(City::destroy($id)){
                flash('City has been deleted successfully')->success();
                return redirect()->route('cities.index');
            }
            else {
                flash(translate('Something went wrong!'))->warning();
                return back();
            }
        }
        else {
            flash(translate('You do not have access permission!'))->warning();
            return back();
        }
    }

    public function get_city_by_country(Request $request)
    {
        $cities = City::where('country_id', $request->country_id)->get();
        return $cities;
    }
}

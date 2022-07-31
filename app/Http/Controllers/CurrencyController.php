<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Currency;
use Redirect,Response;
use Gate;

class CurrencyController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:show system currency setting'])->only('index');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $currencies = Currency::all();
        return view('admin.default.system_configurations.currencies.index', compact('currencies'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.default.system_configurations.currencies.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $currency = new Currency;
        $currency->name = $request->name;
        $currency->symbol = $request->symbol;
        $currency->code = $request->code;
        // $currency->exchange_rate = $request->exchange_rate;
        if ($currency->save()) {
            flash(translate('Currency has been inserted successfully'))->success();
            return redirect()->route('currencies.index');
        }
        else{
            flash(translate('Something went wrong'))->error();
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
        $currency = Currency::findOrFail(decrypt($id));
        return view('admin.default.system_configurations.currencies.edit', compact('currency'));
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
        $currency = Currency::findOrFail($id);
        $currency->name = $request->name;
        $currency->symbol = $request->symbol;
        $currency->code = $request->code;
        // $currency->exchange_rate = $request->exchange_rate;
        if ($currency->save()) {
            flash(translate('Currency has been updated successfully'))->success();
            return redirect()->route('currencies.index');
        }
        else{
            flash(translate('Something went wrong'))->error();
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
        $currency = Currency::findOrFail($id);
        if(Currency::destroy($id)){
            flash(translate('Currency has been deleted successfully'))->success();
            return redirect()->route('currencies.index');
        }

        flash(translate('Something went wrong'))->error();
        return back();
    }

    public function set_currency()
    {
        if (Gate::allows('currency_configuration')) {
            $currencies = Currency::all();
            return view('admin.default.system_configurations.currencies.set_currency', compact('currencies'));
        }
        else {
            flash(translate('You do not have access permission!'))->warning();
            return back();
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmailConfigurationController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:show email setting'])->only('index');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.default.system_configurations.email_config.index');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }



}

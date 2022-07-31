<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Utility\SettingsUtility;
use Gate;

class GeneralConfigurationController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:show general setting'])->only('index');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {        
        return view('admin.default.system_configurations.general_config.index');
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $inputs = $request->except(['_token']);

        if(!empty($inputs)){
            foreach ($inputs as $type => $value) {
                SettingsUtility::save_settings($type,trim($value));
                if($type == 'site_name'){
                    $system_config = new SystemConfigurationController;
                    $system_config->overWriteEnvFile("APP_NAME",trim($value));
                }
                if($type == 'timezone'){
                    $system_config = new SystemConfigurationController;
                    $system_config->overWriteEnvFile('APP_TIMEZONE',trim($value));
                }
            }
        }


        flash("Settings updated successfully")->success();
        return back();
    }
}

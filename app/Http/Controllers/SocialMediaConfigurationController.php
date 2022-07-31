<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Utility\SettingsUtility;
use Gate;

class SocialMediaConfigurationController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:show third party api setting'])->only('index');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        return view('admin.default.system_configurations.social_media_config.index');
        
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $_SystemConfigurationController = new SystemConfigurationController;
        foreach ($request->types as $key => $type) {
            $_SystemConfigurationController->overWriteEnvFile($type, $request[$type]);
        }

        if ($request->has($request->social_media_type . '_activation_checkbox')) {
            SettingsUtility::save_settings($request->social_media_type . '_activation_checkbox', 1);
        } else {
            SettingsUtility::save_settings($request->social_media_type . '_activation_checkbox', 0);
        }


        flash("Settings updated successfully")->success();
        return back();
    }
}

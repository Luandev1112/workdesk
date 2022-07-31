<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Utility\SettingsUtility;
use Gate;

class PaymentConfigurationController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:show payment gateways setting'])->only('index');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        return view('admin.default.system_configurations.payment_config.index');
        
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

        if ($request->has($request->payment_method . '_activation_checkbox')) {
            SettingsUtility::save_settings($request->payment_method . '_activation_checkbox', 1);
        } else {
            SettingsUtility::save_settings($request->payment_method . '_activation_checkbox', 0);
        }

        if ($request->has($request->payment_method . '_sandbox_checkbox')) {
            SettingsUtility::save_settings($request->payment_method . '_sandbox_checkbox', 1);
        } else {
            SettingsUtility::save_settings($request->payment_method . '_sandbox_checkbox', 0);
        }


        flash("Settings updated successfully")->success();
        return back();
    }
}

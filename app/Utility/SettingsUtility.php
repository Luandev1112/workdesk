<?php
/**
 * Created by PhpStorm.
 * User: Aunok
 * Date: 12/19/2019
 * Time: 4:37 PM
 */

namespace App\Utility;

use App\Models\SystemConfiguration;

class SettingsUtility
{
    public static function get_settings_value($type)
    {
        $value = "";
        $settings = SystemConfiguration::where('type', $type)->first();

        if (is_null($settings)) {

            $settings = new SystemConfiguration;
            $settings->type = $type;
            $settings->value = $value;
            $settings->save();
        } else {
            $value = $settings->value;
        }

        return $value;
    }

    public static function save_settings($type, $value)
    {
        $settings = SystemConfiguration::where('type', $type)->first();
        if (is_null($settings)) {
            $settings = new SystemConfiguration;
            $settings->type = $type;
            $settings->value = $value;
            $settings->save();
        } else {
            $settings->value = $value;
            $settings->save();
        }
    }
}

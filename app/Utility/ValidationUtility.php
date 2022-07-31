<?php

namespace App\Utility;
use App\Models\Service;
use App\Models\ServicePackage;
use Auth;

class ValidationUtility
{
   public static function get_service_validation_rules()
   {
       return [
           'title' => 'required',
           'category_id' => 'required',
           'basic_price' => 'required|numeric',
           'standard_price' => 'required|numeric',
           'premium_price' => 'required|numeric',
           'basic_delivery_time' => 'required',
           'standard_delivery_time' => 'required',
           'premium_delivery_time' => 'required',
           'basic_revision_limit' => 'required',
           'standard_revision_limit' => 'required',
           'premium_revision_limit' => 'required',
           'basic_included_description' => 'required',
           'standard_included_description' => 'required',
           'premium_included_description' => 'required',
       ];
   }

   public static function get_service_validation_message()
   {
       return [
           'title.required' => translate('Title is required.'),
           'category_id.required' => translate('Category is required.'),
           'standard_price.required' => translate('Standard Price is required.'),
           'basic_price.required' => translate('Basic Price is required.'),
           'premium_price.required' => translate('Premium Price is required.'),
           'standard_price.numeric' => translate('Standard Price should be a number.'),
           'basic_price.numeric' => translate('Basic price should be a number.'),
           'premium_price.numeric' => translate('Premium price should be a number.'),
           'basic_delivery_time.required' => translate('Basic delivery time limit field is requried.'),
           'standard_delivery_time.required' => translate('Standard delivery time limit field is requried.'),
           'premium_delivery_time.required' => translate('Premium delivery time limit field is requried.'),
           'basic_revision_limit.required' => translate('Basic Revision limit is required.'),
           'standard_revision_limit.required' => translate('Standard Revision limit is required.'),
           'premium_revision_limit.required' => translate('Premium Revision limit is required.'),
       ];
   }
}

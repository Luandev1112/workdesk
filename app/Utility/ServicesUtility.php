<?php

namespace App\Utility;
use App\Models\Service;
use App\Models\ServicePackage;
use Auth;
use Str;

class ServicesUtility
{
    public static function make_package_array($request) {
        $service_packages = array();

        if($request->has('basic_price')) {
            $service_packages['basic']['service_price'] = $request->basic_price;
            $service_packages['basic']['delivery_time'] = $request->basic_delivery_time;
            $service_packages['basic']['revision_limit'] = $request->basic_revision_limit;
            $service_packages['basic']['feature_description'] = json_encode($request->basic_included_description);
        }

        if($request->has('standard_price')) {
            $service_packages['standard']['service_price'] = $request->standard_price;
            $service_packages['standard']['delivery_time'] = $request->standard_delivery_time;
            $service_packages['standard']['revision_limit'] = $request->standard_revision_limit;
            $service_packages['standard']['feature_description'] = json_encode($request->standard_included_description);
        }

        if($request->has('premium_price')) {
            $service_packages['premium']['service_price'] = $request->premium_price;
            $service_packages['premium']['delivery_time'] = $request->premium_delivery_time;
            $service_packages['premium']['revision_limit'] = $request->premium_revision_limit;
            $service_packages['premium']['feature_description'] = json_encode($request->premium_included_description);
        }

        return $service_packages;
    }

    public static function create_service($request)
    {
        $service = new Service();
        $service_package = new ServicePackage();

        $service->title = $request->title;
        $service->image = $request->service_photo;
        $service->about_service = $request->about_service;
        $service->project_cat_id = $request->category_id;
        $service->user_id = Auth::user()->id;
        $service->slug = Str::slug($request->title, '-').date('Ymd-his');
        $service->client_name = $request->client_name;
        $service->site_url = $request->site_url;
        $service->save();

        $requested_service_packages = ServicesUtility::make_package_array($request);

        if($service->id != null) {
            foreach($requested_service_packages as $key => $service_package) {
                $new_package = new ServicePackage();
                $new_package->service_type = $key;
                foreach($service_package as $key => $service_package_details) {
                    $new_package->$key = $service_package[$key];
                }
                $new_package->service_id = $service->id;
                $new_package->save();
            }
            return 1;
        }

        return 0;
    }

   public static function update_service($request, $slug)
   {
        $service = Service::where('slug', $slug)->first();
        $service_packages = $service->service_packages;

        $service->title = $request->title;
        $service->image = $request->service_photo;
        $service->about_service = $request->about_service;
        $service->project_cat_id = $request->category_id;
        $service->user_id = Auth::user()->id;
        $service->client_name = $request->client_name;
        $service->site_url = $request->site_url;
        
        if ($service->slug == null) {
            $service->slug = Str::slug($request->title, '-').date('Ymd-his');
        }
        $counter = 0;
        $requested_service_packages = ServicesUtility::make_package_array($request);

        if($service->save()) {
            foreach($requested_service_packages as $key => $service_package) {
                $new_package = $service_packages[$counter++];
                $new_package->service_type = $key;
                foreach($service_package as $key => $service_package_details) {
                    $new_package->$key = $service_package[$key];
                }
                $new_package->service_id = $service->id;
                $new_package->save();
            }
            return 1;
        }

        return 0;

   }

    public static function can_create_service()
    {
        $services = Service::where('user_id', Auth::user()->id)->get();
        $service_count = $services->count();
        if($service_count < Auth::user()->userPackage->service_limit) {
            return 1;
        }

        return 0;
    }

    public static function delete_service($slug)
    {
        $service = Service::where('slug', $slug)->first();
        $service_packages = $service->service_packages;
        if($service->delete()) {
            foreach($service_packages as $service_package) {
                $service_package->delete();
            }

            return 1;
        }

        return 0;
    }
}

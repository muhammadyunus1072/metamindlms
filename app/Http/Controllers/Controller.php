<?php

namespace App\Http\Controllers;

use App\Helpers\FileHelper;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function meta_data($data = null)
    {
        // $company_information = Company_information::first();
        // $data["meta_web_title"] = (!empty($data["meta_web_title"])) ? $data["meta_web_title"] : $company_information->website_name;
        // $data["meta_description"] = (!empty($data["meta_description"])) ? $data["meta_description"] : $company_information->slogan;
        // $data["meta_keywords"] = (!empty($data["meta_keywords"])) ? $data["meta_keywords"] : $company_information->website_name;
        // $data["meta_web_author"] = (!empty($data["meta_web_author"])) ? $data["meta_web_author"] : "Smart Integrated System";
        // $data["meta_language"] = (!empty($data["meta_language"])) ? $data["meta_language"] : "Indonesian";
        // $data["meta_og_title"] = (!empty($data["meta_og_title"])) ? $data["meta_og_title"] : $company_information->website_name;
        // $data["meta_og_image"] = (!empty($data["meta_og_image"])) ? $data["meta_og_image"] : $company_information->icon;
        // $data["meta_og_description"] = (!empty($data["meta_og_description"])) ? $data["meta_og_description"] : $company_information->slogan;
        // $data["meta_icon"] = (!empty($data["meta_icon"])) ? $data["meta_icon"] : $company_information->icon;
        // $data["meta_logo"] = (!empty($data["meta_logo"])) ? $data["meta_logo"] : $company_information->logo;

        // // CONFIG
        // $data['croute_notif'] = route('notification.index') . "/";
        // $data['sis_url'] = "https://smartintegratedsystem.com/";
        // $data['get_company'] = $company_information;
        // $data['version_data'] = App_setting::where('type', 'web')->orderBy('created_at')->get()->last();
        // $data["hidden_code"] = TRUE;

        // IMAGES

        $data["files_course"] = FileHelper::COURSE_READ_LOCATION;

        return $data;
    }
}

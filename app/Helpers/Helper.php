<?php

use Illuminate\Support\Facades\Storage;


if (!function_exists('file_asset')) {

    function file_asset($file)
    {
        if ($file == 'default.png') {

            return asset($file);
        }
        return "https://wefu.b-cdn.net/{$file}";
    }
}
if (!function_exists('static_asset')) {

    function static_asset($file) {return env("BUNNY_URL") . $file;}
}

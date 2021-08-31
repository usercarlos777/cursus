<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Twilio\Rest\Client;

class HelperController extends Controller
{
    //
    public function twillioMsg($ph, $message)
    {
        try {
            $account_sid = env("TWILIO_SID");
            $auth_token = env("TWILIO_AUTH_TOKEN");
            $twilio_number = env("TWILIO_NUMBER");
        } catch (\Exception $e) {
        }
    }
    public function uploadfile($file, $path)
    {
        $name = uniqid() . '.' . $file->getClientOriginalExtension();

        Storage::disk('s3')->putFileAs($path, $file, $name, 'public');

        return $path . '/' . $name;
    }
    public function deleteImage($fileName)
    {
        try {
            if ($fileName == "default.png") {
                return false;
            }

            Storage::disk('s3')->delete($fileName);
        } catch (\Throwable $th) {
            // throw $th;
        }
    }
}

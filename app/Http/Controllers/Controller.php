<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function sendingSMS($mobile, $messasge)
    {
        // $messasge = urlencode($messasge);
        // $url = 'https://2aitbd.com/2abulksms/remote_access_script.php?user=2ait&pass=2a369&mobile=' . $mobile . '&text=' . $messasge;
        // return file_get_contents($url);
    }

    public function validateMobile($mobile)
    {
        if (strlen($mobile) == 11) {
            return $mobile;
        } elseif (strlen($mobile) == 13) {
            $mobile = substr($mobile, 2);
            return $mobile;
        } elseif (strlen($mobile) == 14) {
            $mobile = substr($mobile, 3);
            return $mobile;
        } else {
            return false;
        }
    }
}

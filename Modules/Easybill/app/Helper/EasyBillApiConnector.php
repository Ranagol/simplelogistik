<?php

namespace Modules\Easybill\app\Helper;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use App\Models\TmsApiAccess;

class EasyBillApiConnector 
{
    /**
     * Call API.
     * Method: POST, PUT, GET etc
     * Data: array("param" => "value") ==> index.php?param=value
     * @param string $method
     * @param string $url
     * @param array|false $data        (optional)
     * @return string                  (json)
     */    
    public function callAPI($method, $url, $apiAccess, $data = false):string
    {
        $curl = curl_init();
    
        switch ($method)
        {
            case "POST":
                curl_setopt($curl, CURLOPT_POST, 1);
    
                if ($data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                break;
            case "PUT":
                curl_setopt($curl, CURLOPT_PUT, 1);
                break;
            default:
                if ($data)
                    $url = sprintf("%s?%s", $url, http_build_query($data));
        }
    
        // Optional Authentication:
        $authorization = "Authorization: " . $apiAccess['api_token_type'] . " " . $apiAccess['api_token'];
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($curl, CURLOPT_USERPWD, "username:password");
    
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    
        $result = curl_exec($curl);
    
        curl_close($curl);
    
        return $result;
    }
}
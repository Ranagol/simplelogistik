<?php

namespace Modules\Easybill\app\Helper;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use App\Models\TmsApiAccess;
use Nwidart\Modules\Facades\Module;


class EasybillModuleHandling 
{
    /**
     * Handle the status of the module.
     * @param array $arguments
     * @return array
     */
    public function handleStatus($arguments)
    {
        $message = [];
        $module = Module::find('Easybill');
        $behave = $arguments['behave'] . '=' . $arguments['detail'];
        
        if ($behave == 'setting=disable') {   
            $module->disable();
            $message = ['warning' => 'New setting ' . $arguments['detail'] . PHP_EOL . 'Easybill module is disabled!'];
            return $message;
        }        
        if ($behave == 'setting=enable') {  
            $module->enable();
            $message = ['success' => 'New setting ' . $arguments['detail'] . PHP_EOL . 'Easybill module is enabled!'];
            return $message;
        }

        if (Module::isDisabled('Easybill')) {
            $message = ['error' => 'Easybill module is disabled!'];
            return $message;
        }

        return $message;
    }    
}
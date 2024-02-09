<?php

namespace App\Services;

use App\Models\TmsFunctionalCondition;
use Nwidart\Modules\Facades\Module;


/**
 * The methods in this class are enabling/disabling the modules, and leaving the module status in tms_functional_conditions table.
 */
class ModulesService
{
    /**
     * Handle the status of the module.
     * @param string $module      // module name
     * @param string $behave      // setting=disable or setting=enable
     * @param array  $message
     * @return array $message
     */
    public function handleStatus($module, $behave, $message = ['status' => 'success', 'message' => ''])
    {
        $module = Module::find($module);
        if (isset($message['error'], $message['warning'])) {
            return $message;
        }        
        if ($behave == 'setting=disable') {            
            $module->disable();
            $message = ['status' => 'warning', 'message' => $module . ' module is disabled!'];
            TmsFunctionalCondition::updateOrCreate(
                ['module_name' => $module],
                ['module_status' => 'disabled', 'field_name' => $module]
            );
            return $message;
        }        
        if ($behave == 'setting=enable') {            
            $module->enable();  
            $message = ['status' => 'success', 'message' => $module . ' module is enabled!'];
            TmsFunctionalCondition::updateOrCreate(
                ['module_name' => $module],
                ['module_status' => 'enabled', 'field_name' => $module]
            );
            return $message;
        }

        if (Module::isDisabled($module)) {
            $message = ['status' => 'error', 'message' => $module . ' module is disabled!'];
        }
        return $message;
    }

    /**
     * Handle the arguments of the module.
     * @param string $argumentBehave
     * @param array  $allowedBehave
     * @return array $message
     */
    public function handleArguments($argumentBehave, $allowedBehave)
    {        
        if (!$this->stripos_array($argumentBehave, $allowedBehave)) {
            return ['status' => 'error', 'message'=> ('The argument ' . $argumentBehave . ' is not allowed!')];
        }
        return ['status' => 'success', 'message' => ('The argument ' . $argumentBehave . ' is allowed!')];        
    }    

    /**
     * Check if the string is in the array.
     * @param string $haystack
     * @param array  $needles
     * @return bool
     */
    private function stripos_array($haystack, $needles){
        foreach($needles as $needle) {
            if(($res = stripos($haystack, $needle)) !== false) {
                return true;
            }
        }
        return false;
    }
}
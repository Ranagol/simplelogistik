<?php

namespace Modules\Easybill\app\Helper;

use App\Models\TmsAddress;
use App\Models\TmsApiAccess;
use App\Models\TmsCustomer;
use Illuminate\Database\Eloquent\Collection;

class CustomerHandling
{
    /**
     * Creates or updates a customer in easybill.
     * @param $result
     * @param $apiAccess
     * @param $mappedData
     * @return array
     */
    public function createOrUpdateCustomer(array $result, TmsApiAccess $apiAccess, array $mappedData)
    {
        $resArr = ['message' => '', 'easybillData' => ''];

        $easyBillConnector = new EasyBillApiConnector();

        $result = json_decode($easyBillConnector->callAPI(
            'GET', 
            $apiAccess,
            'customers?number=' . $mappedData['number'], 
            []
        ), true);        

        //create or update customer in easybill        
        if (isset($result['items']) && $result['items'] == []) 
        {
            $resArr['message'] = 'Customer(' .$mappedData['number']. ') not found. Creating new customer.';
            $response = $easyBillConnector->callAPI(
                'POST', 
                $apiAccess,
                'customers',  
                $mappedData
            );
            $resArr['easybillData'] = json_decode($response);             
        } else {
            $resArr['message'] = 'Customer(' .$mappedData['number']. ') found. Updating customer. ' . $result['items'][0]['id']; 
            $response = $easyBillConnector->callAPI(
                'PUT', 
                $apiAccess,
                'customers/' . $result['items'][0]['id'], 
                $mappedData
            );            
            $resArr['easybillData'] = json_decode($response);            
        } 
        
        return $resArr;
    }
}
<?php

namespace Modules\Easybill\app\Console;

use App\Models\TmsCountry;
use App\Models\TmsCustomer;
use App\Models\TmsOrderAddress;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Nwidart\Modules\Facades\Module;
use App\Models\TmsOrder;
use App\Models\TmsApiAccess;
use Modules\Easybill\app\Helper\DataMapping;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class InvoicesCommand extends Command
{

    protected $apiName = '';
    protected $apiAccess = [];

    /**
     * The name and signature of the console command.
     */
    protected $signature = 'send-invoices {orderid?} {setting=none : (setting=enable) Enables the module; (setting=disable) Disables the module} {-h|--help?}';

    /**
     * The console command description.
     */
    protected $description = 'Send invoice(s) to easybill.';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {                
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $dataMapping = new DataMapping();

        $this->info('Arguments: ' . json_encode($this->arguments()));
        $this->handleStatus();
        $this->info($this->description);       

        $this->apiName = config('api.billingApi');                
        $this->apiAccess = TmsApiAccess::where('api_name', $this->apiName)->first();
        $this->info('ApiAccess: ' . json_encode($this->apiAccess));
        
        $this->info('OrderId: ' . $this->argument('orderid'));

        try {
            $order = TmsOrder::where('id', $this->argument('orderid'))->first();
            $customer = TmsCustomer::where('id', $order->customer_id)->first();
            $addressTypes = $this->changeKeyValue(TmsOrderAddress::getAddressTypes());
            $this->info('AddressTypes: ' . json_encode($addressTypes));
            $addresses['is_pickup'] = TmsOrderAddress::where('order_id',$this->argument('orderid'))
                                                          ->where('address_type', $addressTypes['Pickup address'])
                                                          ->first();
            $addresses['is_delivery'] = TmsOrderAddress::where('order_id',$this->argument('orderid'))
                                                          ->where('address_type', $addressTypes['Delivery address'])
                                                          ->first();
            $addresses['is_billing'] = TmsOrderAddress::where('order_id',$this->argument('orderid'))
                                                          ->where('address_type', $addressTypes['Billing address'])
                                                          ->first();            
            $this->info('Addresses: ' . json_encode($addresses));
        } catch (\Throwable $th) {
            $this->info('Error: ' . $th->getMessage());
            die();
        }

        //create or update customer in easybill
        $result = json_decode($this->callAPI('GET', $this->apiAccess['api_url'] . 'customers?number=' . $customer->internal_id, []));
        //$this->info('Result: ' . json_encode($result));   
        
        $countries = TmsCountry::all();
        $countries = $countries->keyBy('id');
        $mappedData = $dataMapping->mapCustomer($customer, $addresses, $countries);

        $mappedData = [];
        if ($result->total == 0) {
            $this->info('Customer not found. Creating new customer.');
            $this->info(json_encode($this->callAPI('POST', $this->apiAccess['api_url'], json_encode($mappedData))));
        } else {
            $this->info('Customer found. Updating customer.');
            //$this->info(json_encode($result->items[0]->id));
            $this->info(json_encode($this->callAPI('PUT', $this->apiAccess['api_url'] . '/' . $result->items[0]->id, json_encode($mappedData))));
        }

        //$this->info(json_encode($order));
        //$this->info(json_encode($customer));

        //$this->mapOrder($order, $customer);
        //$this->info(json_encode($this->callAPI('GET', $this->apiAccess['api_url'], [])));
    }

    /**
     * Change Key Value of an array.
     */
    private function changeKeyValue($array) {
        $newArray = [];
        foreach ($array as $key => $value) {
            $newArray[$value] = $key;
        }
        return $newArray;
    }

    /**
     * Handle the status of the module.
     * @return $module
     */
    private function handleStatus() 
    {
        $module = Module::find('Easybill');
        $setting = $this->argument('setting');
        
        if ($setting == 'disable') {            
            $this->info('New setting ' . $setting);
            $module->disable();
            $message = ['warning' => 'Easybill module is disabled!'];
            $this->info($message['warning']);
            die(json_encode($message));
        }        
        if ($setting == 'enable') {            
            $this->info('New setting ' . $setting);
            $module->enable();
            $message = ['success' => 'Easybill module is enabled!'];
            $this->info($message['success']);
            die(json_encode($message));
        }

        if (Module::isDisabled('Easybill')) {
            $message = ['error' => 'Easybill module is disabled!'];
            $this->info($message['error']);
            die(json_encode($message));
        }

        return $module;
    }
    
    

    // Method: POST, PUT, GET etc
    // Data: array("param" => "value") ==> index.php?param=value
    
    public function callAPI($method, $url, $data = false)
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
        $authorization = "Authorization: " . $this->apiAccess['api_token_type'] . " " . $this->apiAccess['api_token'];
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

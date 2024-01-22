<?php

namespace Modules\Easybill\app\Console;

use App\Models\TmsAddress;
use App\Models\TmsCustomer;
use Illuminate\Console\Command;
use Nwidart\Modules\Facades\Module;
use App\Models\TmsApiAccess;
use App\Models\TmsCountry;
use App\Models\TmsOrder;
use Modules\Easybill\app\Helper\EasyBillDataMapping;
use Modules\Easybill\app\Helper\EasyBillApiConnector;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class CustomersCommand extends Command
{
    /** string $apiName */
    protected $apiName = '';

    /** array $apiAccess */
    protected $apiAccess = [];

    /**
     * The name and signature of the console command.
     */
    protected $signature = 'sendcustomers {customerid?} {setting=none : (setting=enable) Enables the module; (setting=disable) Disables the module} {-h|--help?}';

    /**
     * The console command description.
     */
    protected $description = 'Send customer to easybill.';

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
        $dataMapping = new EasyBillDataMapping();
        $easyBillConnector = new EasyBillApiConnector();

        $this->info('Arguments: ' . json_encode($this->arguments()));
        $this->handleStatus();
        $this->info($this->description);     
        
        $this->apiName = config('api.billingApi');                
        $this->apiAccess = TmsApiAccess::where('api_name', $this->apiName)->first();
        $this->apiAccess['api_url'] .= 'customers';

        $this->info('CustomerId: ' . $this->argument('customerid'));

        try {
            $customer = TmsCustomer::where('id', $this->argument('customerid'))->first();
        } catch (\Throwable $th) {
            $this->info('Error: ' . $th->getMessage());
            die();
        }

        $addresses = TmsAddress::where('customer_id', $customer->id)->get();
        $addresses = $this->makeAssocAddresses($addresses);
        
        $countries = TmsCountry::all();
        $countries = $countries->keyBy('id');

        $mappedData = $dataMapping->mapCustomer($customer, $addresses, $countries);

        $result = json_decode($easyBillConnector->callAPI('GET', $this->apiAccess['api_url'] . '?number=' . $customer->internal_id, $this->apiAccess, []));
        //$this->info('Result: ' . json_encode($result)); die();

        if (isset($result->total )) {
            if ($result->total == 0) {
                $this->info('Customer not found. Creating new customer.');
                $this->info(json_encode($easyBillConnector->callAPI('POST', $this->apiAccess['api_url'], $this->apiAccess, json_encode($mappedData))));
            } else {
                $this->info('Customer found. Updating customer.');
                $this->info(json_encode($easyBillConnector->callAPI('PUT', $this->apiAccess['api_url'] . '/' . $result->items[0]->id, $this->apiAccess, json_encode($mappedData))));
            }
        } else {
            $this->info('Error: ' . json_encode($result));
            die();
        }
    }

    /**
     * Make assoc array of addresses.
     * @param array $addresses
     * @return array
     */
    private function makeAssocAddresses($addresses):array
    {
        $assoc = [];
        foreach ($addresses as $address) {
            if ($address->is_billing) {
                $assoc['is_billing'] = $address;
            }
            if ($address->is_delivery) {
                $assoc['is_delivery'] = $address;
            }
            if ($address->is_headquarter) {
                $assoc['is_headquarter'] = $address;
            }
            if ($address->is_pickup) {
                $assoc['is_pickup'] = $address;
            }
        }
        return $assoc;
    }


    /**
     * Handle status.
     * For switching module status. Enable or disable.
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
}

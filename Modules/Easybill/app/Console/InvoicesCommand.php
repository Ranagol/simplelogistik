<?php

namespace Modules\Easybill\app\Console;

use App\Models\TmsCountry;
use App\Models\TmsCustomer;
use App\Models\TmsInvoice;
use App\Models\TmsOrderAddress;
use Illuminate\Console\Command;
use Nwidart\Modules\Facades\Module;
use App\Models\TmsOrder;
use App\Models\TmsApiAccess;
use Modules\Easybill\app\Helper\EasyBillDataMapping;
use Modules\Easybill\app\Helper\EasyBillApiConnector;
use stdClass;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class InvoicesCommand extends Command
{
    /** string $apiName */
    protected $apiName = '';

    /** array $apiAccess */
    protected $apiAccess = [];

    /**
     * The name and signature of the console command.
     */
    protected $signature = 'sendinvoices {orderid?} {setting=none : (setting=enable) Enables the module; (setting=disable) Disables the module} {-h|--help?}';

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
        $dataMapping = new EasyBillDataMapping();
        $easyBillConnector = new EasyBillApiConnector();

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
            $addresses = TmsOrderAddress::where('order_id',$this->argument('orderid'))->get();

            foreach($addresses as $address) {
                if ($address->address_type == 'Pickup address') {
                    $addresses['is_pickup'] = $address;
                }
                if ($address->address_type == 'Delivery address') {
                    $addresses['is_delivery'] = $address;
                }
                if ($address->address_type == 'Billing address') {
                    $addresses['is_billing'] = $address;
                }
            }            
         
            $this->info('Addresses: ' . json_encode($addresses)); 
        } catch (\Throwable $th) {
            $this->info('Error: ' . $th->getMessage());
            die();
        }        
        
        $countries  = TmsCountry::all();
        $countries  = $countries->keyBy('id');
        $mappedData = $dataMapping->mapCustomer($customer, $addresses, $countries, $order);

        //create or update customer in easybill
        $result = json_decode($easyBillConnector->callAPI('GET', $this->apiAccess['api_url'] . 'customers?number=' . $customer->internal_id, $this->apiAccess, []));

        if ($result->total == 0) {
            $this->info('Customer not found. Creating new customer.');
            $easybillData = $easyBillConnector->callAPI('POST', $this->apiAccess['api_url'] . 'customers', $this->apiAccess, json_encode($mappedData));
        } else {
            $this->info('Customer found. Updating customer.');
            $easybillData = $easyBillConnector->callAPI('PUT', $this->apiAccess['api_url'] . 'customers/' . $result->items[0]->id, $this->apiAccess, json_encode($mappedData));
            $this->info(json_encode($easybillData));
        }

        //create or update order in easybill
        $invoice = TmsInvoice::where('cargo_order_id', $order->id)->first();
        $mappedData = $dataMapping->mapOrder(json_decode($easybillData)->id,$order, $invoice, $customer, $addresses);
        $result = json_decode($easyBillConnector->callAPI('GET', $this->apiAccess['api_url'] . 'documents/' . $customer->internal_id, $this->apiAccess, []));  // Todo: change internal_id to Easybill's order_id
        if ($result->code === 404) {
            $this->info('Order not found. Creating new order.');
            $this->info(json_encode($easyBillConnector->callAPI('POST', $this->apiAccess['api_url'] . 'documents', $this->apiAccess, json_encode($mappedData))));
        } else {
            $this->info('Order found. Updating order.');
            $this->info(json_encode($easyBillConnector->callAPI('PUT', $this->apiAccess['api_url'] . 'documents/' . $result->items[0]->id, $this->apiAccess, json_encode($mappedData))));
        }
    }

    /**
     * Change Key Value of an array.
     * @param array $array
     * @return array
     */
    private function changeKeyValue(array $array):array
    {
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
}

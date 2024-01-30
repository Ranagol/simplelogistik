<?php

namespace Modules\Easybill\app\Console;

use App\Models\TmsAddress;
use App\Models\TmsCustomer;
use App\Models\TmsOrderAddress;
use Illuminate\Console\Command;
use Modules\Easybill\app\Helper\CustomerHandling;
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
    protected $signature = 'sendcustomers {behave : (behave=setting/customerId)} {detail : (detail=enable/disable) Enables or disables the module. Have to be used with command=setting. (detail=17) CustomerId.}
                                          {-h|--help?}';

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

        $countries  = TmsCountry::all();
        $countries  = $countries->keyBy('id');

        if ($this->argument('behave') == 'customerId') {    
            $this->info('OrderId: ' . $this->argument('detail'));
            $customer                     = TmsCustomer::where('id', $this->argument('detail'))->first();    
            $addresses[0]['is_billing']   = TmsAddress::where('id', $this->argument('detail'))->first();  
            $mappedData                   = $dataMapping->mapCustomer($customer, $addresses, $countries);
        }       
      
        $customerHandler = new CustomerHandling();
        $result = $customerHandler->createOrUpdateCustomer($mappedData, $this->apiAccess, $mappedData);       
        
        $easybillData = $result['easybillData'];
        $this->info($result['message']);

      
        if (isset($easybillData->id)) {
            TmsCustomer::where('id', $customer->id)->update(['easy_bill_customer_id' => $easybillData->id]);
        }
        
        if (isset($easybillData->code) && $easybillData->code !== 200) {
            $this->info('Error: ' . $easybillData->message);
        } else {            
            $this->info('Customer successfully sent to easybill.');
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
     * Handle the status of the module.
     * @return $module
     */
    private function handleStatus()
    {
        $module = Module::find('Easybill');
        $behave = $this->argument('behave') . '=' . $this->argument('detail');
        
        if ($behave == 'setting=disable') {            
            $this->info('New setting ' . $this->argument('detail'));
            $module->disable();
            $message = ['warning' => 'Easybill module is disabled!'];
            $this->info($message['warning']);
            die(json_encode($message));
        }        
        if ($behave == 'setting=enable') {            
            $this->info('New setting ' . $this->argument('detail'));
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

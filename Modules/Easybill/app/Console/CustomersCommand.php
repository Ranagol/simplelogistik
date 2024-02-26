<?php

namespace Modules\Easybill\app\Console;

use App\Models\TmsAddress;
use App\Models\TmsCustomer;
use App\Models\TmsOrderAddress;
use App\Services\ModulesService;
use Illuminate\Console\Command;
use App\Models\TmsApiAccess;
use App\Models\TmsCountry;
use Modules\Easybill\app\Helper\CustomerHandling;
use Modules\Easybill\app\Helper\EasyBillDataMapping;

class CustomersCommand extends Command
{
    /** string $apiName */
    private $apiName = '';

    /** array $apiAccess */
    private $apiAccess = [];

    /** sting $moduleStatus */
    private $moduleStatus = '';

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
        $moduleService = new ModulesService();

        $this->info('Start: ' . $this->description);

        $this->moduleStatus = $moduleService->handleArguments( ($this->argument('behave') . '=' . $this->argument('detail')), 
                                                               ['setting=enable', 'setting=disable', 'customerId=']
                                                             );        
        $this->moduleStatus = $moduleService->handleStatus('Easybill', ($this->argument('behave') . '=' . $this->argument('detail')), $this->moduleStatus);
        $this->info($this->moduleStatus['message']);
        if ($this->moduleStatus['status'] !== 'success' || $this->argument('behave') == 'setting') {       
            return;
        }        

        if ($this->argument('behave') == 'customerId') {    
        
            $this->apiName =  config('api.billingApi');
            $this->apiAccess = TmsApiAccess::where('api_name', $this->apiName)->first();            

            $countries  = TmsCountry::all();
            $countries  = $countries->keyBy('id');
            
            $this->info('OrderId: ' . $this->argument('detail'));
            $customer                     = TmsCustomer::where('id', $this->argument('detail'))->first();    
            $addresses[0]['is_billing']   = TmsOrderAddress::where('customer_id', $this->argument('detail'))
                                                           ->where('address_type', 2)
                                                           ->first();  
            $mappedData                   = $dataMapping->mapCustomer($customer, $addresses, $countries);       
            
            if ($mappedData['number'] === 'temporary testing' || $mappedData['number'] === '') {
                $lastCustomer = TmsCustomer::whereNotIn('internal_id', ['temporary testing'])
                                           ->orderBy('internal_id', 'desc')->first();
                $mappedData['number'] = (isset($lastCustomer->internal_id) && is_numeric($lastCustomer->internal_id)) ? ($lastCustomer->internal_id + 1) : 100000;
                TmsCustomer::where('id', $customer->id)->update(['internal_id' => $mappedData['number']]);
            }
        
            $customerHandler = new CustomerHandling();
            $result = $customerHandler->createOrUpdateCustomer($mappedData, $this->apiAccess, $mappedData);       
            if (!isset($result['easybillData']) || !isset($result['easybillData']->id)) {
                $this->info('Error: ' . $result['message']);
                return;
            }
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
    }        
}

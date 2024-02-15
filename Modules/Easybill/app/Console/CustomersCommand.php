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
    protected $apiName = '';

    /** array $apiAccess */
    protected $apiAccess = [];

    /** sting $moduleStatus */
    protected $moduleStatus = '';

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
        
            $this->apiName = config('api.billingApi');                
            $this->apiAccess = TmsApiAccess::where('api_name', $this->apiName)->first();

            $countries  = TmsCountry::all();
            $countries  = $countries->keyBy('id');
            
            $this->info('OrderId: ' . $this->argument('detail'));
            $customer                     = TmsCustomer::where('id', $this->argument('detail'))->first();    
            $addresses[0]['is_billing']   = TmsAddress::where('id', $this->argument('detail'))->first();  
            $mappedData                   = $dataMapping->mapCustomer($customer, $addresses, $countries);        
        
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
    }

        
}
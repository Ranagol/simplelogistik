<?php

namespace Modules\Easybill\app\Console;

use App\Models\TmsAddress;
use App\Models\TmsCountry;
use App\Models\TmsCustomer;
use App\Models\TmsInvoice;
use App\Models\TmsNativeOrder;
use App\Models\TmsOrderAddress;
use App\Models\TmsPamyraOrder;
use Illuminate\Console\Command;
use Nwidart\Modules\Facades\Module;
use App\Models\TmsOrder;
use App\Models\TmsApiAccess;
use Modules\Easybill\app\Helper\EasyBillDataMapping;
use Modules\Easybill\app\Helper\EasyBillApiConnector;
use Modules\Easybill\app\Helper\CustomerHandling;
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
    protected $signature = 'sendinvoices {behave : (behave=setting/orderId/ordersOfCustomerID)} {detail : (detail=enable/disable) Enables or disables the module. Have to be used with command=setting. (detail=17) OrderId or CustomerId.}
                                         {-h|--help?}';

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

        $mappedData = [];
        
        $this->handleStatus();
        $this->info($this->description);    

        $this->apiName = config('api.billingApi');                
        $this->apiAccess = TmsApiAccess::where('api_name', $this->apiName)->first();     
        
        $countries  = TmsCountry::all();
        $countries  = $countries->keyBy('id');

        // When a specific order should be billed
        if ($this->argument('behave') == 'orderId') {    
            $this->info('OrderId: ' . $this->argument('detail'));
            $customer = TmsCustomer::where('id', $this->argument('detail'))->first();    
            // check if customer has debt collection, if not, stop
            if ($customer->debt_collection == 1) {
                $this->info('Customer wishes debt collection!');
                die();
            } 
            $addresses[0]['is_billing']   = TmsOrderAddress::where('order_id', $this->argument('detail'))->where('address_type', 'Billing address')->first();
            $addresses[0]['is_pickup']    = TmsOrderAddress::where('order_id', $this->argument('detail'))->where('address_type', 'Pickup address')->first();
            $addresses[0]['is_delivery']  = TmsOrderAddress::where('order_id', $this->argument('detail'))->where('address_type', 'Delivery address')->first();
            $colOrders[0]                 = $this->prepareOrderData($this->argument('detail'));              
            $mappedData                   = $dataMapping->mapCustomer($customer, $addresses, $countries, $colOrders);
        } else

        // When we need collect all not billed orders of a customer
        // depending on setting customer.debt_collection get all orders 
        if ($this->argument('behave') == 'ordersOfCustomerID') {    
            $this->info('CustomerId: ' . $this->argument('detail'));
            
            $orders = TmsOrder::where('customer_id', $this->argument('detail'))->whereNull('invoice_number')->get();
            // check if customer has not billed orders, if not, stop
            if (count($orders) == 0) {
                $this->info('Customer has no open orders!');
                die();
            } 
            $customer = TmsCustomer::where('id', $orders[0]->customer_id)->first(); 
            // check if customer has debt collection, if not, stop
            if ($customer->debt_collection == 0) {
                $this->info('Customer has no debt collection!');
                die();
            } 
            $addresses[0]['is_billing']      = TmsAddress::where('customer_id', $orders[0]->customer_id)->where('is_billing', true)->first();            

            $i = 0;
            $colOrders = [];
            foreach ($orders as $order) {
                $tempColOrder = $this->prepareOrderData($order->id); 
                if (isset($tempColOrder['price_net']) && $tempColOrder['price_net'] > 0) {
                    $colOrders[$i] = $tempColOrder;
                } else {
                    $this->info('Order has no price. Not sending to easybill.'); unset($orders[$i]); $i++; continue;
                }
                $addresses[$i]['is_pickup']    = TmsOrderAddress::where('order_id', $order->id)->where('address_type', 'Pickup address')->first();
                $addresses[$i]['is_delivery']  = TmsOrderAddress::where('order_id', $order->id)->where('address_type', 'Delivery address')->first();                              
                $i++;
            }
            $mappedData = $dataMapping->mapCustomer($customer, $addresses, $countries, $colOrders);  
        } else {
            $this->info('Unknown argument: ' . $this->argument('behave'));
            die();
        }
        if (count($mappedData) === 0) {
            $this->info('mappedData empty! No data to send to easybill.');
            die();
        }

        $customerHandler = new CustomerHandling();
        $result = $customerHandler->createOrUpdateCustomer($mappedData, $this->apiAccess, $mappedData);       
        
        $easybillData = $result['easybillData'];
        $this->info('Customer update or create: ' .  $result['message']);      
      
        if (isset($easybillData->id)) {
            TmsCustomer::where('id', $customer->id)->update(['easy_bill_customer_id' => $easybillData->id]);
        }
       
        //
        // try to find invoice in DB
        //
        $invoice = TmsInvoice::where('invoice_number', $colOrders[0]['invoice_number'])->first();
        // create invoice if not exists
        if ($invoice === null) {
            // get last invoice number
            $lastInvoice      = TmsInvoice::orderBy('invoice_number', 'desc')->where('invoice_number','NOT LIKE', "%INV%")->first();
            $newInvoiceNumber = ($lastInvoice) ? ((int)$lastInvoice->invoice_number + 1) : 3000000;
            $invoice          = $this->makeInvoiceRaw($colOrders, $newInvoiceNumber);
        }

        $mappedData = $dataMapping->mapOrder($easybillData->id, $colOrders, $invoice, $customer, $addresses);
        
        //create or update invoice in easybill
        if (isset($colOrders[0]['price_net']) && $colOrders[0]['price_net'] > 0) {
            $result = json_decode($easyBillConnector->callAPI('GET', $this->apiAccess, 'documents/' . $invoice->easybill_invoice_id, []));  

            if (isset($result->code) && $result->code === 404 || $result === null) {
                $this->info('Invoice not found. Creating new invoice.');
                $response = $easyBillConnector->callAPI('POST', $this->apiAccess, 'documents',  $mappedData);
            } else {
                $this->info('Invoice found. Updating invoice.');
                $response = $easyBillConnector->callAPI('PUT', $this->apiAccess, 'documents/' . $invoice->easybill_invoice_id, $mappedData);
            }
            
            $res = json_decode($response);
            if (isset($res->id)) {
                $this->info('Fetch pdf document.');
                $response = $easyBillConnector->callAPI('GET', $this->apiAccess, 'documents/' . $res->id . '/pdf', []);

                $arrRes = json_decode($response);
                if (isset($arrRes->code) && $arrRes->code !== 200) {
                    $this->info('Error: ' . $arrRes->message);
                } else {            
                    $this->info('Invoice successfully fetched from easybill.');                
                    $invoicePathAndFile = base_path('documents/invoices/invoice_' . $res->number . '.pdf');
                    file_put_contents($invoicePathAndFile, $response);
                }
                $this->updateInvoice($res, $colOrders[0],$invoicePathAndFile);
                
                TmsCustomer::where('id', $customer->id)->update(['easy_bill_customer_id' => $res->id]);
                TmsOrder::whereIn('id', $this->getIdArray($colOrders))->update(['invoice_number' => $res->number]);
            }

            if (isset($res->code) && $res->code !== 200) {
                $this->info('Error: ' . $res->message);
            } else {            
                $this->info('Order successfully sent to easybill.');
            }
        } else {
            $this->info('Order has no price. Not sending to easybill.');
        }
    }    

    /**
     * Get id array.
     * @param array $colOrders
     * @return array
     */
    private function getIdArray($colOrders) {
        $idArray = [];
        foreach ($colOrders as $colOrder) {
            $idArray[] = $colOrder['order_id'];
        }
        return $idArray;
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

    /**
     * Prepare order data.
     * Get (main)order data from DB and merge with native or pamyra order data.
     * @param int $orderId
     * @return mixed
     */
    private function prepareOrderData(int $orderId) :mixed
    {
        //dd($orderId);
        $order = TmsOrder::where('id', $orderId)->first();            
        if (strtolower($order->origin) == 'native_sales') {
            $colOrder = collect((object)array_merge(
                $order->toArray(), 
                TmsNativeOrder::where('order_id', $orderId)->first()->toArray()
            ));
            return $colOrder;
        }
        if (strtolower($order->origin) == 'pamyra') {
            $pamyraOrder = TmsPamyraOrder::where('order_id', $orderId)->first()?->toArray();            
            $colOrder = collect((object)array_merge(
                $order->toArray(), 
                ($pamyraOrder) ? $pamyraOrder : []
            ));
            return $colOrder;
        }
        dd('no Native or Pamyra Order found');
        return ['error' => true, 'message' => 'no Native or Pamyra Order found'];
    }

    /**
     * Make invoice raw.
     * @param array $colOrder
     * @param int $newInvoiceNumber
     * @return mixed
     */
    private function makeInvoiceRaw($colOrder, $newInvoiceNumber) {
        $invoice = TmsInvoice::create([
            'easybill_invoice_id'     => '',
            'order_id'                => $colOrder[0]['order_id'],
            'customer_id'             => $colOrder[0]['customer_id'],
            'forwarder_id'            => $colOrder[0]['forwarder_id'],
            'invoice_number'          => $newInvoiceNumber,
            'invoice_type'            => 1,                                      // 1 = invoice; 2 = Credit
            'invoice_link'            => '',
            'payment_date'            => date('Y-m-d'),
            'invoice_sum_without_tax' => $colOrder[0]['price_net'],
            'invoice_sum_with_tax'    => $colOrder[0]['price_gross'],
            'invoice_date'            => date('Y-m-d'),
            'invoice_received_date'   => date('Y-m-d'),
            'currency'                => $colOrder[0]['currency'],
            'invoice_sum'             => $colOrder[0]['price_gross'],
            'tax'                     => $colOrder[0]['vat_rate'],                
        ]);

        return $invoice;
    }

    /**
     * Update invoice.
     * @param object $res
     * @param array $colOrder
     * @param string $invoicePathAndFile
     */
    private function updateInvoice($res, $colOrder, $invoicePathAndFile = '') {
        $invoice = TmsInvoice::updateOrInsert(
            ['invoice_number' => $res->number],
            [     
                'easybill_invoice_id'     => $res->id,
                'order_id'                => $colOrder['order_id'],
                'customer_id'             => $colOrder['customer_id'],
                'forwarder_id'            => $colOrder['forwarder_id'],
                'invoice_number'          => $res->number,
                'invoice_type'            => 1,                              // 1 = invoice; 2 = Credit
                'invoice_link'            => $invoicePathAndFile,            //'https://www.easybill.de/portal/document/' . $res->id . '/pdf,
                'payment_date'            => date('Y-m-d'),
                'invoice_sum_without_tax' => $res->items[0]->total_price_net / 100,
                'invoice_sum_with_tax'    => $res->items[0]->total_price_gross / 100,
                'invoice_date'            => $res->document_date,
                'invoice_received_date'   => $res->due_date,
                'currency'                => $colOrder['currency'],
                'invoice_sum'             => $colOrder['price_gross'],
                'tax'                     => $colOrder['vat_rate'],      
            ]);
    }
}

<?php

namespace Modules\Easybill\app\Helper;

use App\Models\TmsOrderAddress;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use PHPUnit\Framework\Constraint\IsEmpty;

class EasyBillDataMapping
{
    public $addressTypes = [];

    /**
     * Map address data to easybill format.
     * @param object $customer
     * @param array $addresses
     * @param object $countries
     * @param array $orders
     * @return array
     */
     
    public function mapCustomer($customer, $addresses, $countries, $orders = []) {

        $customerData = [
            'acquire_options'               =>  null,
            'additional_groups_ids'         =>  [],
            'archived'                      =>  false,
            'bank_account'                  =>  null,
            'bank_account_owner'            =>  null,
            'bank_bic'                      =>  null,
            'bank_code'                     =>  null,
            'bank_iban'                     =>  null,
            'bank_name'                     =>  null,
            'birth_date'                    =>  '' ,
            'buyer_reference'               =>  '' ,                        // thought was said that customer will have this field?
            'cash_allowance'                =>  null,
            'cash_allowance_days'           =>  $customer->payment_time,
            'cash_discount'                 =>  null,
            'cash_discount_type'            =>  null,
            'city'                          =>  $addresses[0]['is_billing']->city ?? '',
            'company_name'                  =>  ($customer->company_name === '') ? ($addresses[0]['is_billing']->company_name) : ($customer->company_name),
            'country'                       =>  $countries[$addresses[0]['is_billing']->country_id ?? 276]->alpha_2_code ?? 'DE',
            'court'                         =>  '',
            'court_registry_number'         =>  '',
            'created_at'                    =>  (isset($orders[0]->created_at)) ? ($orders[0]->created_at->format('d.m.Y')) : ((isset($addresses[0]['is_billing'])) ? $addresses[0]['is_billing']->created_at->format('d.m.Y') : ''),
            'delivery_city'                 =>  $addresses[0]['is_delivery']->city ?? '',
            'delivery_company_name'         =>  $addresses[0]['is_delivery']->company_name ?? '',
            'delivery_country'              =>  $countries[$addresses[0]['is_delivery']->country_id ?? 276]->alpha_2_code ?? 'DE',
            'delivery_first_name'           =>  $addresses[0]['is_delivery']->first_name ?? '',  
            'delivery_last_name'            =>  $addresses[0]['is_delivery']->last_name ?? '',
            'delivery_personal'             =>  false,
            'delivery_salutation'           =>  null,                                                       //2,
            'delivery_state'                =>  '',
            'delivery_street'               =>  $addresses[0]['is_delivery']->street ?? '',
            'delivery_suffix_1'             =>  null,
            'delivery_suffix_2'             =>  null,
            'delivery_title'                =>  '',
            'delivery_zip_code'             =>  $addresses[0]['is_delivery']->zip_code ?? '',
            'display_name'                  =>  $addresses[0]['is_delivery']->company_name ?? '',
            'document_pdf_type'             =>  'default',
            'due_in_days'                   =>  $customer->payment_time,
            'emails' =>  [
                'buchhaltung@simplelogistik.de'
            ],
            'fax'                           =>  null,
            'first_name'                    =>  $addresses[0]['is_billing']->first_name ?? $customer->first_name,
            'foreign_supplier_number'       =>  '',
            'grace_period'                  =>  null,
            'group_id'                      =>  null,
            'info_1'                        =>  null,
            'info_2'                        =>  null,
            'internet'                      =>  '',
            'last_name'                     =>  $addresses[0]['is_billing']->last_name ?? $customer->last_name,
            'login_id'                      =>  $customer->internal_id,
            'mobile'                        =>  null,
            'note'                          =>  null,
            'number'                        =>  $customer->internal_id,
            'payment_options'               =>  null,
            'personal'                      =>  false,
            'phone_1'                       =>  $addresses[0]['is_billing']->phone ?? $customer->phone,
            'phone_2'                       =>  null,
            'postbox'                       =>  null,
            'postbox_city'                  =>  null,
            'postbox_country'               =>  null,
            'postbox_state'                 =>  '',
            'postbox_zip_code'              =>  null,
            'sale_price_level'              =>  null,
            'salutation'                    =>  null,                                   //2,
            'sepa_agreement'                =>  null,
            'sepa_agreement_date'           =>  null,
            'sepa_mandate_reference'        =>  '',
            'since_date'                    =>  null,      
            'state'                         =>  '',
            'street'                        =>  (isset($addresses[0]['is_billing']->street, $addresses[0]['is_billing']->house_number)) ? ($addresses[0]['is_billing']->street . ' ' . $addresses[0]['is_billing']->house_number) : '',
            'suffix_1'                      =>  null,
            'suffix_2'                      =>  null,
            'tax_number'                    =>  null,
            'tax_options'                   =>  null,
            'title'                         =>  null,
            'updated_at'                    =>  (isset($addresses[0]['is_billing'])) ? $addresses[0]['is_billing']->updated_at->format('d.m.Y') : $customer->updated_at->format('d.m.Y'),
            'vat_identifier'                =>  $customer->tax_number,
            'zip_code'                      =>  $addresses[0]['is_billing']->zip_code ?? '' 
        ];
        return $customerData;
    }

    /**
     * Map order data to easybill format.
     * @param int $cid
     * @param array $orders
     * @param object $invoice
     * @param object $customer
     * @param array $addresses
     * @return array
     */
    public function mapOrder($cid, $orders, $invoice, $customer, $addresses) {

        $itmes = [];
        
        $i = 0;
        foreach ($orders as $order) {
            $itmes[] = [
                'number'                => (isset($invoice->type_of_transport)) ? $invoice->type_of_transport : '',
                'description'           => (isset($addresses[$i]['is_pickup'], $addresses[$i]['is_delivery'])) ? 
                                            ('Transport ' . $addresses[$i]['is_pickup']->city . ' nach ' . 
                                                            $addresses[$i]['is_delivery']->city .chr(13). 
                                                'Transportkosten Auftr. ' .$order['order_number']) .chr(13). 
                                                'Referenz: ' . $order['customer_reference'] : 
                                            (''),
                'document_note'         => 'note '.'Transportkosten Auftr. ' . ((isset($invoice->internal_id)) ? $invoice->internal_id : ''),
                'quantity'              => 1,
                'quantity_str'          => "1",
                'unit'                  => '',                            // Stk. | Packet | Palette
                'type'                  => 'POSITION',
                'position'              => 1,
                'single_price_net'      => (isset($order['price_net'])) ? (int)str_replace(['.',','], '', $order['price_net']) : 0,
                'single_price_gross'    => 0,
                'vat_percent'           => $order['vat_rate'],                                        
                'discount'              => null,
                'discount_type'         => null,
                'position_id'           => 1,
                'booking_account'       => null,
                'export_cost_1'         => null,
                'export_cost_2'         => null,
                'cost_price_net'        => null,
                'itemType'              => 'UNDEFINED'
            ];
            $i++;
        }
        

        $orderData = [
            'bank_debit_form'       => null,
            'calc_vat_from'         => 0,
            'cash_allowance'        => null,
            'cash_allowance_days'   => $customer->payment_time,
            'cash_allowance_text'   => null,
            'contact_id'            => null,
            'contact_label'         => '',
            'contact_text'          => '',
            'currency'              => $orders[0]['currency'],
            'customer_id'           => $cid,
            'discount'              => null,
            'discount_type'         => null,
            'document_date'         => Carbon::now()->format('Y-m-d'),
            'external_id'           => null,
            'replica_url'           => null,
            'grace_period'          => null,
            'due_in_days'           => $customer->payment_time,
            'is_acceptable_on_public_domain' => false,
            'is_archive'            => false,
            'is_replica'            => false,
            'is_oss'                => false,
            'items'                 => $itmes,
            'login_id'              => null,
            'number'                => $invoice->invoice_number ?? '',
            'order_number'          => $orders[0]['order_number'],                         // use numbers that are starting with 300 and having 4 more digits
            'buyer_reference'       => isset($customer['customer_reference']) ?? '',
            'pdf_template'          => 'DE',                                               //'316947'   // have to be dynamic when languages are added             
            'project_id'            => null,
            'recurring_options'     => [
                'next_date'                 => '',
                'frequency'                 => '',
                'frequency_special'         => null,
                'interval'                  => 1,
                'end_date_or_count'         => null,
                'status'                    => 'BILLED',
                'as_draft'                  => false,
                'is_notify'                 => false,
                'send_as'                   => null,
                'is_sign'                   => false,
                'is_paid'                   => false,
                'paid_date_option'          => 'created_date',
                'is_sepa'                   => false,
                'sepa_local_instrument'     => null,
                'sepa_sequence_type'        => null,
                'sepa_reference'            => null,
                'sepa_remittance_information' => null,
                'target_type'               => 'DE'                                           //'316947'   // have to be dynamic when languages are added     
            ],
            'ref_id'        => null,
            'service_date'  => [
                'type'          => 'DEFAULT',
                'date'          => (isset($orders[0]['order_date'])) ? $orders[0]['order_date'] : '',                      //->format('Y-m-d'),
                'date_from'     => null,
                'date_to'       => null,
                'text'          => null
            ],
            'shipping_country'      => null,
            'status'                => null,
            'text'                  => 'Vielen Dank für Ihren Auftrag.' . chr(13). 'Bitte begleichen Sie den offenen Betrag bis zum %DOKUMENT.DATUM-FAELLIG%.' . chr(13).chr(13) . 'Mit freundlichen Grüßen' . chr(13).chr(13) . '%FIRMA.FIRMA%',
            'text_prefix'           => '%KUNDE.ANREDE%,' . chr(13).chr(13) . 'nachfolgend berechnen wir Ihnen wie vorab besprochen.' . chr(13) . '',
            'text_tax'              => null,
            'title'                 => 'Invoice for Order ' . (isset($orders[0]['order_number'])) ? $orders[0]['order_number'] : '',
            'type'                  => 'INVOICE',
            'use_shipping_address'  => false,
            'vat_country'           => null,
            'fulfillment_country'   => null,
            'vat_option'            => null,
            'file_format_config' => array([
                'type' => 'default'
            ]),
        ];

        return $orderData;
    }
}
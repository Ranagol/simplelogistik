<?php

namespace Modules\Easybill\app\Helper;

use App\Models\TmsOrderAddress;
use Illuminate\Support\Facades\Http;
use PHPUnit\Framework\Constraint\IsEmpty;

class EasyBillDataMapping
{
    public $addressTypes = [];

    public function mapCustomer($customer, $addresses, $countries, $order = []) {

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
            'city'                          =>  (isset($customer->city)) ? ($customer->city) : ($addresses['Billing address']->city ?? ''),
            'company_name'                  =>  ($customer->company_name === '') ? ($addresses['Billing address']->company_name) : ($customer->company_name),
            'country'                       =>  $countries[$addresses['Billing address']->country_id ?? 276]->alpha_2_code ?? 'DE',
            'court'                         =>  '',
            'court_registry_number'         =>  '',
            'created_at'                    =>  (isset($order->created_at)) ? ($order->created_at->format('d.m.Y')) : ((isset($addresses['Billing address'])) ? $addresses['Billing address']->created_at->format('d.m.Y') : ''),
            'delivery_city'                 =>  $addresses['Delivery address']->city ?? '',
            'delivery_company_name'         =>  $addresses['Delivery address']->company_name ?? '',
            'delivery_country'              =>  $countries[$addresses['Delivery address']->country_id ?? 276]->alpha_2_code ?? 'DE',
            'delivery_first_name'           =>  $addresses['Delivery address']->first_name ?? '',  
            'delivery_last_name'            =>  $addresses['Delivery address']->last_name ?? '',
            'delivery_personal'             =>  false,
            'delivery_salutation'           =>  0,
            'delivery_state'                =>  '',
            'delivery_street'               =>  $addresses['Delivery address']->street ?? '',
            'delivery_suffix_1'             =>  null,
            'delivery_suffix_2'             =>  null,
            'delivery_title'                =>  '',
            'delivery_zip_code'             =>  $addresses['Delivery address']->zip_code ?? '',
            'display_name'                  =>  $addresses['Delivery address']->company_name ?? '',
            'document_pdf_type'             =>  'default',
            'due_in_days'                   =>  $customer->payment_time,
            'emails' =>  [
                'buchhaltung@simplelogistik.de'
            ],
            'fax'                           =>  null,
            'first_name'                    =>  $addresses['Billing address']->first_name ?? $customer->first_name,
            'foreign_supplier_number'       =>  '',
            'grace_period'                  =>  null,
            'group_id'                      =>  null,
            'info_1'                        =>  null,
            'info_2'                        =>  null,
            'internet'                      =>  '',
            'last_name'                     =>  $addresses['Billing address']->last_name ?? $customer->last_name,
            'login_id'                      =>  $customer->internal_id,
            'mobile'                        =>  null,
            'note'                          =>  null,
            'number'                        =>  $customer->internal_id,
            'payment_options'               =>  null,
            'personal'                      =>  false,
            'phone_1'                       =>  $addresses['Billing address']->phone ?? $customer->phone,
            'phone_2'                       =>  null,
            'postbox'                       =>  null,
            'postbox_city'                  =>  null,
            'postbox_country'               =>  null,
            'postbox_state'                 =>  '',
            'postbox_zip_code'              =>  null,
            'sale_price_level'              =>  null,
            'salutation'                    =>  1,
            'sepa_agreement'                =>  null,
            'sepa_agreement_date'           =>  null,
            'sepa_mandate_reference'        =>  '',
            'since_date'                    =>  null,      
            'state'                         =>  '',
            'street'                        =>  $addresses['Billing address']->street ?? '',
            'suffix_1'                      =>  null,
            'suffix_2'                      =>  null,
            'tax_number'                    =>  null,
            'tax_options'                   =>  null,
            'title'                         =>  null,
            'updated_at'                    =>  (isset($addresses['Billing address'])) ? $addresses['Billing address']->updated_at->format('d.m.Y') : $customer->updated_at->format('d.m.Y'),
            'vat_identifier'                =>  $customer->tax_number,
            'zip_code'                      =>  $addresses['Billing address']->zip ?? '' 
        ];
        return $customerData;
    }

    public function mapOrder($cid, $order, $invoice, $customer, $addresses) {

        $orderData = [
            'bank_debit_form'       => null,
            'calc_vat_from'         => 0,
            'cash_allowance'        => null,
            'cash_allowance_days'   => $customer->payment_time,
            'cash_allowance_text'   => null,
            'contact_id'            => null,
            'contact_label'         => '',
            'contact_text'          => '',
            'currency'              => 'EUR',
            'customer_id'           => $cid,
            'discount'              => null,
            'discount_type'         => null,
            'document_date'         => (isset($invoice->invoice_date)) ? $invoice->invoice_date : '',                     //->format('Y-m-d'),
            'external_id'           => null,
            'replica_url'           => null,
            'grace_period'          => null,
            'due_in_days'           => $customer->payment_time,
            'is_acceptable_on_public_domain' => false,
            'is_archive'            => false,
            'is_replica'            => false,
            'is_oss'                => false,
            'items' => array(
            [
                'number'                => (isset($invoice->type_of_transport)) ? $invoice->type_of_transport : '',
                'description'           => 'Desc. '.(isset($addresses['Pickup address'], $addresses['Delivery address'])) ? ('Transport ' . ($addresses['Pickup address']->city ?? '') . ' nach ' . ($addresses['Delivery address']->city ?? '')) : (''),
                'document_note'         => 'note '.'Transportkosten Auftr. ' . ((isset($invoice->internal_id)) ? $invoice->internal_id : ''),
                'quantity'              => 1,
                'quantity_str'          => "1",
                'unit'                  => '',                            // Stk. | Packet | Palette
                'type'                  => 'POSITION',
                'position'              => 1,
                'single_price_net'      => (isset($invoice->invoice_sum)) ? (int)str_replace(['.',','], '',$invoice->invoice_sum) : 0,
                'single_price_gross'    => 0,
                'vat_percent'           => 19,                                                            // have to be dynamic when countries are added
                'discount'              => null,
                'discount_type'         => null,
                'position_id'           => 1,
                'booking_account'       => null,
                'export_cost_1'         => null,
                'export_cost_2'         => null,
                'cost_price_net'        => null,
                'itemType'              => 'UNDEFINED'
            ]),
            'login_id'          => null,
            'number'            => (isset($invoice->invoice_id)) ? $invoice->internal_id : '',
            'order_number'      => $order->internal_id,                           // use numbers that are starting with 300 and having 4 more digits
            'buyer_reference'   => ($order->customer_reference !== '') ? ($order->customer_reference) : (isset($customer->customer_reference) ?? ''),
            'pdf_template'      => 'DE',                         //'316947'   // have to be dynamic when languages are added                                      // have to be dynamic when languages are added              
            'project_id'        => null,
            'recurring_options' => [
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
                'target_type'               => 'DE'                         //'316947'   // have to be dynamic when languages are added     
            ],
            'ref_id'        => null,
            'service_date'  => [
                'type'          => 'DEFAULT',
                'date'          => (isset($order->order_date)) ? $order->order_date : '',                      //->format('Y-m-d'),
                'date_from'     => null,
                'date_to'       => null,
                'text'          => null
            ],
            'shipping_country'      => null,
            'status'                => null,
            'text'                  => 'Vielen Dank für Ihren Auftrag!!!\r\n\nBitte begleichen Sie den offenen Betrag bis zum %DOKUMENT.DATUM-FAELLIG%.\n\nMit freundlichen Grüßen\n\n%FIRMA.FIRMA%\\n',
            'text_prefix'           => '%KUNDE.ANREDE%,\nnachfolgend berechnen wir Ihnen wie vorab besprochen.\n',
            'text_tax'              => null,
            'title'                 => 'Invoice for Order ' . (isset($order->internal_id)) ? $order->internal_id : '',
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
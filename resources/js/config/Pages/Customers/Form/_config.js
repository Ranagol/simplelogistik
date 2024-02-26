export default {
    sections: [
        {
            "title": "pages.customers.form.sections.customer_information",
            "cols": 12,
            "fields": [
                {
                    "name": "forwarder_id", 
                    "size": "col-span-4",
                    "label": "pages.customers.form.forwarder_id", 
                    "placeholder": "pages.customers.form.forwarder_id", 
                    "type": "select",
                    "options": "forwarders",
                    "displayKey": "name",
                    "match": "id",
                },
                // {
                //     "name": "salutation_id", 
                //     "size": "col-span-4",
                //     "label": "pages.customers.form.salutation_id", 
                //     "placeholder": "pages.customers.form.salutation_id", 
                //     "type": "text"
                // },
                // {
                //     "name": "title_id", 
                //     "size": "col-span-4",
                //     "label": "pages.customers.form.title_id", 
                //     "placeholder": "pages.customers.form.title_id", 
                //     "type": "text"
                // },
                {
                    "name": "company_name", 
                    "size": "col-span-4",
                    "label": "pages.customers.form.company_name", 
                    "placeholder": "pages.customers.form.company_name", 
                    "type": "text"
                },
                {
                    "name": "internal_id", 
                    "size": "col-span-4",
                    "label": "pages.customers.form.internal_id", 
                    "placeholder": "pages.customers.form.internal_id", 
                    "type": "text"
                },
                {
                    "name": "first_name", 
                    "size": "col-span-4",
                    "label": "pages.customers.form.first_name", 
                    "placeholder": "pages.customers.form.first_name", 
                    "type": "text"
                },
                {
                    "name": "last_name", 
                    "size": "col-span-4",
                    "label": "pages.customers.form.last_name", 
                    "placeholder": "pages.customers.form.last_name", 
                    "type": "text"
                },
                {
                    "name": "email", 
                    "size": "col-span-4",
                    "label": "pages.customers.form.email", 
                    "placeholder": "pages.customers.form.email", 
                    "type": "text"
                },
                {
                    "name": "phone", 
                    "size": "col-span-4",
                    "label": "pages.customers.form.phone", 
                    "placeholder": "pages.customers.form.phone", 
                    "type": "text"
                },
                {
                    "name": "tax_number", 
                    "size": "col-span-4",
                    "label": "pages.customers.form.tax_number", 
                    "placeholder": "pages.customers.form.tax_number", 
                    "type": "text"
                },
                {
                    "name": "rating", 
                    "size": "col-span-4",
                    "label": "pages.customers.form.rating", 
                    "placeholder": "pages.customers.form.rating", 
                    "type": "text"
                },
                {
                    "name": "comments", 
                    "size": "col-span-4",
                    "label": "pages.customers.form.comments", 
                    "placeholder": "pages.customers.form.comments", 
                    "type": "text"
                },
                {
                    "name": "payment_time", 
                    "size": "col-span-4",
                    "label": "pages.customers.form.payment_time", 
                    "placeholder": "pages.customers.form.payment_time", 
                    "type": "text"
                },
                {
                    "name": "auto_book_as_private", 
                    "size": "col-span-4",
                    "label": "pages.customers.form.auto_book_as_private", 
                    "placeholder": "pages.customers.form.auto_book_as_private", 
                    "type": "check"
                },
                {
                    "name": "dangerous_goods", 
                    "size": "col-span-4",
                    "label": "pages.customers.form.dangerous_goods", 
                    "placeholder": "pages.customers.form.dangerous_goods", 
                    "type": "check"
                },
                {
                    "name": "bussiness_customer", 
                    "size": "col-span-4",
                    "label": "pages.customers.form.bussiness_customer", 
                    "placeholder": "pages.customers.form.bussiness_customer", 
                    "type": "check"
                },
                {
                    "name": "debt_collection", 
                    "size": "col-span-4",
                    "label": "pages.customers.form.debt_collection", 
                    "placeholder": "pages.customers.form.debt_collection", 
                    "type": "check"
                },
                {
                    "name": "direct_debit", 
                    "size": "col-span-4",
                    "label": "pages.customers.form.direct_debit", 
                    "placeholder": "pages.customers.form.direct_debit", 
                    "type": "check"
                },
                {
                    "name": "manual_collective_invoicing", 
                    "size": "col-span-4",
                    "label": "pages.customers.form.manual_collective_invoicing", 
                    "placeholder": "pages.customers.form.manual_collective_invoicing", 
                    "type": "check"
                },
                {
                    "name": "private_customer", 
                    "size": "col-span-4",
                    "label": "pages.customers.form.private_customer", 
                    "placeholder": "pages.customers.form.private_customer", 
                    "type": "check"
                },
                {
                    "name": "invoice_customer", 
                    "size": "col-span-4",
                    "label": "pages.customers.form.invoice_customer", 
                    "placeholder": "pages.customers.form.invoice_customer", 
                    "type": "check"
                },
                {
                    "name": "poor_payment_morale", 
                    "size": "col-span-4",
                    "label": "pages.customers.form.poor_payment_morale", 
                    "placeholder": "pages.customers.form.poor_payment_morale", 
                    "type": "check"
                },
                {
                    "name": "can_login", 
                    "size": "col-span-4",
                    "label": "pages.customers.form.can_login", 
                    "placeholder": "pages.customers.form.can_login", 
                    "type": "check"
                },
                {
                    "name": "customer_type", 
                    "size": "col-span-4",
                    "label": "pages.customers.form.customer_type", 
                    "placeholder": "pages.customers.form.customer_type", 
                    "type": "text"
                },
                {
                    "name": "invoice_dispatch", 
                    "size": "col-span-4",
                    "label": "pages.customers.form.invoice_dispatch", 
                    "placeholder": "pages.customers.form.invoice_dispatch", 
                    "type": "text"
                },
                {
                    "name": "invoice_shipping_method", 
                    "size": "col-span-4",
                    "label": "pages.customers.form.invoice_shipping_method", 
                    "placeholder": "pages.customers.form.invoice_shipping_method", 
                    "type": "text"
                },
                {
                    "name": "payment_method", 
                    "size": "col-span-4",
                    "label": "pages.customers.form.payment_method", 
                    "placeholder": "pages.customers.form.payment_method", 
                    "type": "text"
                },
                {
                    "name": "email_for_invoice", 
                    "size": "col-span-4",
                    "label": "pages.customers.form.email_for_invoice", 
                    "placeholder": "pages.customers.form.email_for_invoice", 
                    "type": "text"
                },
                {
                    "name": "email_for_label", 
                    "size": "col-span-4",
                    "label": "pages.customers.form.email_for_label", 
                    "placeholder": "pages.customers.form.email_for_label", 
                    "type": "text"
                },
                {
                    "name": "email_for_pod", 
                    "size": "col-span-4",
                    "label": "pages.customers.form.email_for_pod", 
                    "placeholder": "pages.customers.form.email_for_pod", 
                    "type": "text"
                },
                {
                    "name": "customer_reference", 
                    "size": "col-span-4",
                    "label": "pages.customers.form.customer_reference", 
                    "placeholder": "pages.customers.form.customer_reference", 
                    "type": "text"
                },
                {
                    "name": "payment_method_options_to_offer", 
                    "size": "col-span-4",
                    "label": "pages.customers.form.payment_method_options_to_offer", 
                    "placeholder": "pages.customers.form.payment_method_options_to_offer", 
                    "type": "text"
                },
                {
                    "name": "easy_bill_customer_id", 
                    "size": "col-span-4",
                    "label": "pages.customers.form.easy_bill_customer_id", 
                    "placeholder": "pages.customers.form.easy_bill_customer_id", 
                    "type": "text"
                },
                {
                    "name": "invoice_send_date", 
                    "size": "col-span-4",
                    "label": "pages.customers.form.invoice_send_date", 
                    "placeholder": "pages.customers.form.invoice_send_date", 
                    "type": "text"
                },
            ]
        }
        
    ]
}







































export default {
    sections: [
        {
            title: "pages.customers.form.customer_information",
            rows: [
                {className: 'grid-flow-row gap-4', fields: [
                    {
                        name: "forwarder_id",
                        className: "col-auto",
                        label: "pages.customers.form.forwarder", 
                        placeholder: "pages.customers.form.forwarder", 
                        type: "select",
                        options: "forwarders",
                        displayKey: "name",
                        match: "id",
                    },
                ]},
                {className: 'grid-flow-row gap-4', fields: [
                    {
                        name: "company_name",
                        className: "col-auto",
                        label: "pages.customers.form.company_name", 
                        placeholder: "pages.customers.form.company_name", 
                        type: "text"
                    },
                    {
                        name: "internal_id",
                        className: "col-auto",
                        label: "pages.customers.form.internal_id", 
                        placeholder: "pages.customers.form.internal_id", 
                        type: "text"
                    },
                ]},
                {className: 'grid-flow-row gap-4', fields: [
                    {
                        name: "first_name",
                        className: "col-auto",
                        label: "pages.customers.form.first_name", 
                        placeholder: "pages.customers.form.first_name", 
                        type: "text"
                    },
                    {
                        name: "last_name",
                        className: "col-auto",
                        label: "pages.customers.form.last_name", 
                        placeholder: "pages.customers.form.last_name", 
                        type: "text"
                    },
                ]},
                {className: 'grid-flow-row gap-4', fields: [
                    {
                        name: "email",
                        className: "col-auto",
                        label: "pages.customers.form.email", 
                        placeholder: "pages.customers.form.email", 
                        type: "text"
                    },
                    {
                        name: "phone",
                        className: "col-auto",
                        label: "pages.customers.form.phone", 
                        placeholder: "pages.customers.form.phone", 
                        type: "text"
                    },
                ]},
                {className: 'grid-flow-row gap-4', fields: [
                    {
                        name: "tax_number",
                        className: "col-auto",
                        label: "pages.customers.form.tax_number", 
                        placeholder: "pages.customers.form.tax_number", 
                        type: "text"
                    },
                    {
                        name: "rating",
                        className: "col-auto",
                        label: "pages.customers.form.rating", 
                        placeholder: "pages.customers.form.rating", 
                        type: "text"
                    },
                ]},
                {className: 'grid-flow-row gap-4', fields: [
                    {
                        name: "comments",
                        className: "col-auto",
                        label: "pages.customers.form.comments", 
                        placeholder: "pages.customers.form.comments", 
                        type: "text"
                    },
                    {
                        name: "payment_time",
                        className: "col-auto",
                        label: "pages.customers.form.payment_time", 
                        placeholder: "pages.customers.form.payment_time", 
                        type: "text"
                    },
                ]},
                {className: 'grid-flow-row gap-4', fields: [
                    {
                        name: "auto_book_as_private",
                        className: "col-auto",
                        label: "pages.customers.form.auto_book_as_private", 
                        placeholder: "pages.customers.form.auto_book_as_private", 
                        type: "check"
                    },
                    {
                        name: "dangerous_goods",
                        className: "col-auto",
                        label: "pages.customers.form.dangerous_goods", 
                        placeholder: "pages.customers.form.dangerous_goods", 
                        type: "check"
                    },
                    {
                        name: "bussiness_customer",
                        className: "col-auto",
                        label: "pages.customers.form.bussiness_customer", 
                        placeholder: "pages.customers.form.bussiness_customer", 
                        type: "check"
                    },
                    {
                        name: "debt_collection",
                        className: "col-auto",
                        label: "pages.customers.form.debt_collection", 
                        placeholder: "pages.customers.form.debt_collection", 
                        type: "check"
                    }
                ]},
                {className: 'grid-flow-row gap-4', fields: [
                    {
                        name: "direct_debit",
                        className: "col-auto",
                        label: "pages.customers.form.direct_debit", 
                        placeholder: "pages.customers.form.direct_debit", 
                        type: "check"
                    },
                    {
                        name: "manual_collective_invoicing",
                        className: "col-auto",
                        label: "pages.customers.form.manual_collective_invoicing", 
                        placeholder: "pages.customers.form.manual_collective_invoicing", 
                        type: "check"
                    },
                    {
                        name: "private_customer",
                        className: "col-auto",
                        label: "pages.customers.form.private_customer", 
                        placeholder: "pages.customers.form.private_customer", 
                        type: "check"
                    },
                    {
                        name: "invoice_customer",
                        className: "col-auto",
                        label: "pages.customers.form.invoice_customer", 
                        placeholder: "pages.customers.form.invoice_customer", 
                        type: "check"
                    },
                ]},
                {className: 'grid-flow-row gap-4', fields: [
                    {
                        name: "poor_payment_morale",
                        className: "col-auto",
                        label: "pages.customers.form.poor_payment_morale", 
                        placeholder: "pages.customers.form.poor_payment_morale", 
                        type: "check"
                    },
                    {
                        name: "can_login",
                        className: "col-auto",
                        label: "pages.customers.form.can_login", 
                        placeholder: "pages.customers.form.can_login", 
                        type: "check"
                    },
                ]},
                {className: 'grid-flow-row gap-4', fields: [
                    {
                        name: "customer_type",
                        className: "col-auto",
                        label: "pages.customers.form.customer_type", 
                        placeholder: "pages.customers.form.customer_type", 
                        type: "select",
                        options: "customertypes",
                        displayKey: "name",
                        match: "id",
                    },
                    {
                        name: "invoice_dispatch",
                        className: "col-auto",
                        label: "pages.customers.form.invoice_dispatch", 
                        placeholder: "pages.customers.form.invoice_dispatch", 
                        type: "select",
                        options: "invoicedispatch",
                        displayKey: "title",
                        match: "id",
                    },
                    {
                        name: "invoice_shipping_method",
                        className: "col-auto",
                        label: "pages.customers.form.invoice_shipping_method", 
                        placeholder: "pages.customers.form.invoice_shipping_method", 
                        type: "select",
                        options: "ism",
                        displayKey: "title",
                        match: "id",

                    },
                    {
                        name: "payment_method",
                        className: "col-auto",
                        label: "pages.customers.form.payment_method", 
                        placeholder: "pages.customers.form.payment_method", 
                        type: "select",
                        options: "paymentmethods",
                        displayKey: "internal_name",
                        match: "id",
                    },
                ]},
                {className: 'grid-flow-row gap-4', fields: [
                    {
                        name: "email_for_invoice",
                        className: "col-auto",
                        label: "pages.customers.form.email_for_invoice", 
                        placeholder: "pages.customers.form.email_for_invoice", 
                        type: "text"
                    },
                    {
                        name: "email_for_label",
                        className: "col-auto",
                        label: "pages.customers.form.email_for_label", 
                        placeholder: "pages.customers.form.email_for_label", 
                        type: "text"
                    },
                    {
                        name: "email_for_pod",
                        className: "col-auto",
                        label: "pages.customers.form.email_for_pod", 
                        placeholder: "pages.customers.form.email_for_pod", 
                        type: "text"
                    }
                ]},
                {className: 'grid-flow-row gap-4', fields: [
                    {
                        name: "customer_reference",
                        className: "col-auto",
                        label: "pages.customers.form.customer_reference", 
                        placeholder: "pages.customers.form.customer_reference", 
                        type: "text"
                    },
                    {
                        name: "payment_method_options_to_offer",
                        className: "col-auto",
                        label: "pages.customers.form.payment_method_options_to_offer", 
                        placeholder: "pages.customers.form.payment_method_options_to_offer", 
                        type: "text"
                    },
                    {
                        name: "easy_bill_customer_id",
                        className: "col-auto",
                        label: "pages.customers.form.easy_bill_customer_id", 
                        placeholder: "pages.customers.form.easy_bill_customer_id", 
                        type: "text"
                    },
                    {
                        name: "invoice_send_date",
                        className: "col-auto",
                        label: "pages.customers.form.invoice_send_date", 
                        placeholder: "pages.customers.form.invoice_send_date", 
                        type: "text"
                    },
                ]},
            ],
        }
    ]
}







































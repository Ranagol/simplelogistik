export default {
    title: "forms.customers.title",
    preset: "table",
    fields: [
        {
            editable: {
                edit: true,
                create: true
            },
            name: "auto_book_as_private",
            type: "check",
            options: false,
            label: 'forms.customers.fields.auto_book_as_private',
            placeholder: 'forms.customers.fields.auto_book_as_private',
            hint: false,
            class: ' col-span-6 ',
        },
        {
            editable: {
                edit: true,
                create: true
            },
            name: "dangerous_goods",
            type: "check",
            options: false,
            label: 'forms.customers.fields.dangerous_goods',
            placeholder: 'forms.customers.fields.dangerous_goods',
            hint: false,
            class: ' col-span-6 ',
        },
        {
            editable: {
                edit: true,
                create: true
            },
            name: "business_customer",
            type: "check",
            options: false,
            label: 'forms.customers.fields.business_customer',
            placeholder: 'forms.customers.fields.business_customer',
            hint: false,
            class: ' col-span-6 ',
        },
        {
            editable: {
                edit: true,
                create: true
            },
            name: "debt_collection",
            type: "check",
            options: false,
            label: 'forms.customers.fields.debt_collection',
            placeholder: 'forms.customers.fields.debt_collection',
            hint: false,
            class: ' col-span-6 ',
        },
        {
            editable: {
                edit: true,
                create: true
            },
            name: "direct_debit",
            type: "check",
            options: false,
            label: 'forms.customers.fields.direct_debit',
            placeholder: 'forms.customers.fields.direct_debit',
            hint: false,
            class: ' col-span-6 ',
        },
        {
            editable: {
                edit: true,
                create: true
            },
            name: "manual_collective_invoicing",
            type: "check",
            options: false,
            label: 'forms.customers.fields.manual_collective_invoicing',
            placeholder: 'forms.customers.fields.manual_collective_invoicing',
            hint: false,
            class: ' col-span-6 ',
        },
        {
            editable: {
                edit: true,
                create: true
            },
            name: "private_customer",
            type: "check",
            options: false,
            label: 'forms.customers.fields.private_customer',
            placeholder: 'forms.customers.fields.private_customer',
            hint: false,
            class: ' col-span-6 ',
        },
        {
            editable: {
                edit: true,
                create: true
            },
            name: "invoice_customer",
            type: "check",
            options: false,
            label: 'forms.customers.fields.invoice_customer',
            placeholder: 'forms.customers.fields.invoice_customer',
            hint: false,
            class: ' col-span-6 ',
        },
        {
            editable: {
                edit: true,
                create: true
            },
            name: "poor_payment_morale",
            type: "check",
            options: false,
            label: 'forms.customers.fields.poor_payment_morale',
            placeholder: 'forms.customers.fields.poor_payment_morale',
            hint: false,
            class: ' col-span-6 ',
        },
        {
            editable: {
                edit: true,
                create: true
            },
            name: "can_login",
            type: "check",
            options: false,
            label: 'forms.customers.fields.can_login',
            placeholder: 'forms.customers.fields.can_login',
            hint: false,
            class: ' col-span-6 ',
        },
        {
            editable: {
                edit: true,
                create: true
            },
            name: "customer_type",
            type: "searchable",
            searchResource: "customer",
            resultKeys: {"id": "id", "first_name": "name"},
            options: false,
            label: 'forms.customers.fields.customer_type',
            placeholder: 'forms.customers.fields.customer_type',
            hint: false,
            class: ' col-span-6 ',
        },
        {
            editable: {
                edit: true,
                create: true
            },
            name: "invoice_dispatch",
            type: "searchable",
            searchResource: "forwarder",
            resultKeys: {"id": "id", "company_name": "name"},
            options: false,
            label: 'forms.customers.fields.invoice_dispatch',
            placeholder: 'forms.customers.fields.invoice_dispatch',
            hint: false,
            class: ' col-span-6 ',
        },
        {
            editable: {
                edit: true,
                create: true
            },
            name: "invoice_shipping_method",
            type: "searchable",
            searchResource: "",
            resultKeys: {"id": "id", "name": "name"},
            options: false,
            label: 'forms.customers.fields.invoice_shipping_method',
            placeholder: 'forms.customers.fields.invoice_shipping_method',
            hint: false,
            class: ' col-span-6 ',
        },
        {
            editable: {
                edit: true,
                create: true
            },
            name: "payment_method_options_to_offer",
            type: "searchable",
            searchResource: "",
            resultKeys: {"id": "id", "name": "name"},
            options: false,
            label: 'forms.customers.fields.payment_method_options_to_offer',
            placeholder: 'forms.customers.fields.payment_method_options_to_offer',
            hint: false,
            class: ' col-span-6 ',
        },
        {
            editable: {
                edit: true,
                create: true
            },
            name: "payment_method",
            type: "searchable",
            searchResource: "",
            resultKeys: {"id": "id", "name": "name"},
            options: false,
            label: 'forms.customers.fields.payment_method',
            placeholder: 'forms.customers.fields.payment_method',
            hint: false,
            class: ' col-span-6 ',
        },
        {
            editable: {
                edit: true,
                create: true
            },
            name: "email_for_invoice",
            type: "text",
            options: false,
            label: 'forms.customers.fields.email_for_invoice',
            placeholder: 'forms.customers.fields.email_for_invoice',
            hint: false,
            class: ' col-span-6 ',
        },
        {
            editable: {
                edit: true,
                create: true
            },
            name: "email_for_label",
            type: "text",
            options: false,
            label: 'forms.customers.fields.email_for_label',
            placeholder: 'forms.customers.fields.email_for_label',
            hint: false,
            class: ' col-span-6 ',
        },
        {
            editable: {
                edit: true,
                create: true
            },
            name: "email_for_pod",
            type: "text",
            options: false,
            label: 'forms.customers.fields.email_for_pod',
            placeholder: 'forms.customers.fields.email_for_pod',
            hint: false,
            class: ' col-span-6 ',
        },
        {
            editable: {
                edit: true,
                create: true
            },
            name: "customer_reference",
            type: "searchable",
            searchResource: "",
            resultKeys: {"id": "id", "name": "name"},
            options: false,
            label: 'forms.customers.fields.customer_reference',
            placeholder: 'forms.customers.fields.customer_reference',
            hint: false,
            class: ' col-span-6 ',
        }
    ]    
}


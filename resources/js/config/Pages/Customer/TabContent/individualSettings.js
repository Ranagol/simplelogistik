import { create, destroy, index, store, update } from "@/config/actionPresets";

export default {
    title: "forms.customers.individualSettings",
    preset: "form",
    actions: [
        {
            position: "top",
            alignment: "justify-between",
            buttons: [
                index, store
            ]
        },
        {
            position: "bottom",
            alignment: "justify-end",
            buttons: [
                index,create,store,destroy,update
            ]
        },
        
    ],
    fields: [
        {
            editable: {
                edit: true,
                create: true
            },
            name: "auto_book_as_private",
            type: "check",
            options: false,
            label: 'forms.fields.autoBookAsPrivate',
            placeholder: 'forms.fields.autoBookAsPrivate',
            hint: false,
            class: 'col-span-4',
        },
        {
            editable: {
                edit: true,
                create: true
            },
            name: "dangerous_goods",
            type: "check",
            options: false,
            label: 'forms.fields.dangerousGoods',
            placeholder: 'forms.fields.dangerousGoods',
            hint: false,
            class: 'col-span-4',
        },
        {
            editable: {
                edit: true,
                create: true
            },
            name: "business_customer",
            type: "check",
            options: false,
            label: 'forms.fields.businessCustomer',
            placeholder: 'forms.fields.businessCustomer',
            hint: false,
            class: 'col-span-4',
        },
        {
            editable: {
                edit: true,
                create: true
            },
            name: "debt_collection",
            type: "check",
            options: false,
            label: 'forms.fields.debtCollection',
            placeholder: 'forms.fields.debtCollection',
            hint: false,
            class: 'col-span-4',
        },
        {
            editable: {
                edit: true,
                create: true
            },
            name: "direct_debit",
            type: "check",
            options: false,
            label: 'forms.fields.directDebit',
            placeholder: 'forms.fields.directDebit',
            hint: false,
            class: 'col-span-4',
        },
        {
            editable: {
                edit: true,
                create: true
            },
            name: "manual_collective_invoicing",
            type: "check",
            options: false,
            label: 'forms.fields.manualCollectiveInvoicing',
            placeholder: 'forms.fields.manualCollectiveInvoicing',
            hint: false,
            class: 'col-span-4',
        },
        {
            editable: {
                edit: true,
                create: true
            },
            name: "private_customer",
            type: "check",
            options: false,
            label: 'forms.fields.privateCustomer',
            placeholder: 'forms.fields.privateCustomer',
            hint: false,
            class: 'col-span-4',
        },
        {
            editable: {
                edit: true,
                create: true
            },
            name: "invoice_customer",
            type: "check",
            options: false,
            label: 'forms.fields.invoiceCustomer',
            placeholder: 'forms.fields.invoiceCustomer',
            hint: false,
            class: 'col-span-4',
        },
        {
            editable: {
                edit: true,
                create: true
            },
            name: "poor_payment_morale",
            type: "check",
            options: false,
            label: 'forms.fields.poorPaymentMorale',
            placeholder: 'forms.fields.poorPaymentMorale',
            hint: false,
            class: 'col-span-4',
        },
        {
            editable: {
                edit: true,
                create: true
            },
            name: "can_login",
            type: "check",
            options: false,
            label: 'forms.fields.canLogin',
            placeholder: 'forms.fields.canLogin',
            hint: false,
            class: 'col-span-4',
        },
        {
            type: "separator",
        },
        {
            editable: {
                edit: true,
                create: true
            },
            name: "customer_type",
            type: "text",
            searchResource: false,
            // resultKeys: {"id": "id", "first_name": "name"}, > if you want to use a different key for the result
            options: false,
            label: 'forms.fields.customerType',
            placeholder: 'forms.fields.customerType',
            hint: false,
            class: 'col-span-4',
        },
        {
            editable: {
                edit: true,
                create: true
            },
            name: "invoice_dispatch",
            type: "text",
            searchResource: false,
            // resultKeys: {"id": "id", "company_name": "name"},
            options: false,
            label: 'forms.fields.invoiceDispatch',
            placeholder: 'forms.fields.invoiceDispatch',
            hint: false,
            class: 'col-span-4',
        },
        {
            editable: {
                edit: true,
                create: true
            },
            name: "invoice_shipping_method",
            type: "text",
            // searchResource: "",
            // resultKeys: {"id": "id", "name": "name"},
            options: false,
            label: 'forms.fields.invoiceShippingMethod',
            placeholder: 'forms.fields.invoiceShippingMethod',
            hint: false,
            class: 'col-span-4',
        },
        {
            editable: {
                edit: true,
                create: true
            },
            name: "payment_method_options_to_offer",
            type: "text",
            // searchResource: "",
            // resultKeys: {"id": "id", "name": "name"},
            options: false,
            label: 'forms.fields.paymentMethodOptionsToOffer',
            placeholder: 'forms.fields.paymentMethodOptionsToOffer',
            hint: false,
            class: 'col-span-4',
        },
        {
            editable: {
                edit: true,
                create: true
            },
            name: "payment_method",
            type: "text",
            // searchResource: "",
            // resultKeys: {"id": "id", "name": "name"},
            options: false,
            label: 'forms.fields.paymentMethod',
            placeholder: 'forms.fields.paymentMethod',
            hint: false,
            class: 'col-span-4',
        },
        {
            editable: {
                edit: true,
                create: true
            },
            name: "email_for_invoice",
            type: "text",
            options: false,
            label: 'forms.fields.emailForInvoice',
            placeholder: 'forms.fields.emailForInvoice',
            hint: false,
            class: 'col-span-4',
        },
        {
            editable: {
                edit: true,
                create: true
            },
            name: "email_for_label",
            type: "text",
            options: false,
            label: 'forms.fields.emailForLabel',
            placeholder: 'forms.fields.emailForLabel',
            hint: false,
            class: 'col-span-4',
        },
        {
            editable: {
                edit: true,
                create: true
            },
            name: "email_for_pod",
            type: "text",
            options: false,
            label: 'forms.fields.emailForPod',
            placeholder: 'forms.fields.emailForPod',
            hint: false,
            class: 'col-span-4',
        },
        {
            editable: {
                edit: true,
                create: true
            },
            name: "customer_reference",
            type: "text",
            // searchResource: "",
            // resultKeys: {"id": "id", "name": "name"},
            options: false,
            label: 'forms.fields.customerReference',
            placeholder: 'forms.fields.customerReference',
            hint: false,
            class: 'col-span-4',
        }
    ]    
}


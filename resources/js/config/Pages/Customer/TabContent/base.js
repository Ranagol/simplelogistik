import { create, destroy, index, store, update } from "@/config/actionPresets";
export default {
    title: "forms.customers.generalCustomerData",
    preset: "form",
    actions: [
        {
            position: "top",
            alignment: "justify-end",
            buttons: [
                store
            ]
        },
        {
            position: "bottom",
            alignment: "justify-end",
            buttons: []
        },
        
    ],
    contentLoader: {
        create: {
            load: false
        },
        edit: {
            load: true,
            resource: 'customers.base',
        },
    },
    fields: [
        {
            editable: {
                edit: true,
                create: true,
            },
            name: 'company_name',
            type: 'text',
            label: 'forms.customers.fields.companyName',
            placeholder: 'forms.customers.fields.companyName',
            options: false,
            hint: false,
            class: 'col-span-6',
        },
        {
            editable: {
                edit: true,
                create: true,
            },
            name: 'internal_id',
            type: 'text',
            label: 'forms.customers.fields.companyName',
            placeholder: 'forms.customers.fields.companyName',
            options: false,
            hint: false,
            class: 'col-span-6',
        },
        {
            editable: {
                edit: true,
                create: true,
            },
            name: 'first_name',
            type: 'text',
            label: 'forms.customers.fields.companyName',
            placeholder: 'forms.customers.fields.companyName',
            options: false,
            hint: false,
            class: 'col-span-6',
        },
        {
            editable: {
                edit: true,
                create: true,
            },
            name: 'last_name',
            type: 'text',
            label: 'forms.customers.fields.companyName',
            placeholder: 'forms.customers.fields.companyName',
            options: false,
            hint: false,
            class: 'col-span-6',
        },
        {
            editable: {
                edit: true,
                create: true,
            },
            name: 'phone_number',
            type: 'text',
            label: 'forms.customers.fields.companyName',
            placeholder: 'forms.customers.fields.companyName',
            options: false,
            hint: false,
            class: 'col-span-6',
        },
        {
            editable: {
                edit: true,
                create: true,
            },
            name: 'email_address',
            type: 'text',
            label: 'forms.customers.fields.companyName',
            placeholder: 'forms.customers.fields.companyName',
            options: false,
            hint: false,
            class: 'col-span-6',
        },
        {
            editable: {
                edit: true,
                create: true,
            },
            name: 'tax_number',
            type: 'text',
            label: 'forms.customers.fields.companyName',
            placeholder: 'forms.customers.fields.companyName',
            options: false,
            hint: false,
            class: 'col-span-6',
        },
        {
            editable: {
                edit: true,
                create: true,
            },
            name: 'rating',
            type: 'text',
            label: 'forms.customers.fields.companyName',
            placeholder: 'forms.customers.fields.companyName',
            options: false,
            hint: false,
            class: 'col-span-6',
        },
        {
            editable: {
                edit: true,
                create: true,
            },
            name: 'payment_time',
            type: 'text',
            label: 'forms.customers.fields.companyName',
            placeholder: 'forms.customers.fields.companyName',
            options: false,
            hint: false,
            class: 'col-span-6',
        },
        {
            editable: {
                edit: true,
                create: true,
            },
            name: 'standard_forwarder',
            type: 'text',
            label: 'forms.customers.fields.companyName',
            placeholder: 'forms.customers.fields.companyName',
            options: false,
            hint: false,
            class: 'col-span-6',
        }
    ]
}
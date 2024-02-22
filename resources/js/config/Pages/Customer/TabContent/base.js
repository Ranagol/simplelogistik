import { create, destroy, index, store, update } from "@/config/actionPresets";
export default {
    title: "forms.customers.generalCustomerData",
    preset: "form",
    actions: [
        {
            position: "top",
            alignment: "justify-end",
            buttons: []
        },
        {
            position: "bottom",
            alignment: "justify-end",
            buttons: [
                store
            ]
        },
        
    ],
    fields: [
        {
            editable: {
                edit: true,
                create: true,
            },
            name: 'company_name',
            type: 'text',
            label: 'forms.fields.companyName',
            placeholder: 'forms.fields.companyName',
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
            label: 'forms.fields.internalId',
            placeholder: 'forms.fields.internalId',
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
            label: 'forms.fields.firstName',
            placeholder: 'forms.fields.firstName',
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
            label: 'forms.fields.lastName',
            placeholder: 'forms.fields.lastName',
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
            label: 'forms.fields.phoneNumber',
            placeholder: 'forms.fields.phoneNumber',
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
            label: 'forms.fields.emailAddress',
            placeholder: 'forms.fields.emailAddress',
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
            label: 'forms.fields.taxNumber',
            placeholder: 'forms.fields.taxNumber',
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
            label: 'forms.fields.rating',
            placeholder: 'forms.fields.rating',
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
            label: 'forms.fields.paymentTime',
            placeholder: 'forms.fields.paymentTime',
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
            type: 'searchable',
            searchResource: 'forwarder',
            accessKeys: {'id': "id" , 'name': "email"},
            label: 'forms.fields.forwarder',
            placeholder: 'forms.fields.forwarder',
            options: false,
            hint: false,
            class: 'col-span-6',
        }
    ]
}
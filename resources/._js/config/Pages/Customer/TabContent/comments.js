import { create, store } from "@/config/actionPresets";

export default {
    title: "forms.customers.comments",
    preset: "timeline|input",
    actions:[
        {
            position: "top",
            alignment: "justify-end",
            buttons: [
                store
            ]
        }
    ],
    fields: [
        {
            editable: {
                edit: true,
                create: true
            },
            name: "comment",
            type: "textarea",
            options: false,
            label: 'forms.fields.enter-comment',
            placeholder: 'forms.fields.enter-comment',
            hint: false,
            class: 'col-span-12',
        }
    ],
    contentLoader: {
        create: {
            load: false
        },
        edit: {
            load: true,
            resource: 'customers.comments',
        },
    },
}


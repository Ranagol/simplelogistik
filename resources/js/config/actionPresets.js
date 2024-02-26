import { Delete, Edit, Plus, ArrowLeft } from "@element-plus/icons-vue";

const index = {
    action: "index",
    type: "link",
    target: "page",
    label: "actions.back-to-index",
    icon: ArrowLeft,
}

const create = {
    action: "create",
    type: "button",
    target: "page",
    label: "actions.create",
    icon: Plus,
}

const store = {
    action: "store",
    type: "button",
    target: "form",
    label: "actions.save",
    icon: false,
}

const destroy = {
    action: "destroy",
    type: "button",
    target: "form",
    label: "actions.delete",
    icon: Delete,
}

const edit = {
    action: "edit",
    type: "link",
    target: "page",
    label: "actions.edit",
    icon: Edit,
}

const update = {
    action: "update",
    type: "button",
    target: "form",
    label: "actions.update",
    icon: false,
}

const cancel = {
    action: "void",
    type: "button",
    target: "form",
    label: "actions.void",
    icon: false,
}

export {
    index as index,
    create as create,
    store as store,
    destroy as destroy,
    edit as edit,
    update as update,
    cancel as cancel,
}
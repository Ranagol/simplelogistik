import { router } from "@inertiajs/vue3"

export default class Action {
    constructor(){
        this.page = route().current().split('.')[0]
    }

    index = () => {
        router.visit(route(`${this.page}.index`))
    }

    create = () => {
        router.visit(route(`${this.page}.create`))
    }

    show = (id) => {
        router.visit(route(`${this.page}.show`, id))
    }

    edit = (id) => {
        router.visit(route(`${this.page}.edit`, id))
    }

    // These functions transport data to handle the request in Background

    store = (data, options) => {
        router.post(route(`${this.page}.store`), data, options)
    }

    save = (id, data, options ) => {
        router.put(route(`${this.page}.update`, id), data, options)
    }

    delete = (id) => {
        router.delete(route(`${this.page}.destroy`, id))
    }
}
export default class TableHeaders {
    key = ""
    defaults = []
    items = []
    
    constructor(defaults = [], key) {
        this.defaults = JSON.stringify(defaults)
        this.key = key
        this.__load()
    }

    __load = () => {
        if(sessionStorage.getItem(this.key) === null) {
            this.items = this.defaults
        } else {
            this.items = sessionStorage.getItem(this.key)
        }

        this.items = JSON.parse(this.items)
    }

    __save = () => {
        if(typeof this.items === 'object') {
            this.items = JSON.stringify(this.items)
        }
        sessionStorage.setItem(this.key, this.items)
    }

    update = (key, value) => {
        this.__load()
        this.items = this.items.map(item => item.key === key ? {...item, show: value} : item )
        this.__save()
        this.__load()
    }
    
    reset = () => {
        this.items = this.defaults
        this.__save()
    }

    get = () => {
        this.__load()
        return this.items
    }
};
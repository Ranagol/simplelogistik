export default class PageHelper {
    page = null
    mode = null
    id = null
    
    constructor(page, mode, id = null) {
        this.reset(page, mode, id)
    }

    reset(page, mode, id) {
        this.page = page
        this.mode = mode
        this.id = id
    }
}
import { Histogram, Folder, Avatar, TakeawayBox, More, ArrowDown, Location} from "@element-plus/icons-vue"

const items =  [
    {
        "title": "menu.dashboard",
        "route": 'dashboard',
        "icon": Histogram,
    },
    {
        "title": "menu.orders",
        "route": 'orders.index',
        "icon": Folder,
    },
    {
        "title": "menu.customers",
        "route": 'customers.index',
        "icon": Avatar,
    },
    {
        "title": "menu.addresses",
        "route": 'addresses.index',
        "icon": TakeawayBox,
    },
    {
        "title": "menu.more",
        "submenu": [
            {
                "title": "menu.pamyra",
                // "route": 'pamyra.index',
            },
        ],
        "icon": More,
    },

]

export default items;
import { Histogram, Folder, Avatar, TakeawayBox, More, ArrowDown, Location, Van} from "@element-plus/icons-vue"
import TranslateIcon from "@/Components/Icons/TranslateIcon.vue"
const items =  [
    {
        "title": "menu.languages",
        "route": 'languages.index',
        "icon": TranslateIcon,
        "customIcon": true
    },
    {
        "title": "menu.documents",
        "route": 'documents.index',
        "icon": Folder,
    },
    {
        "title": "menu.archive",
        "route": 'archives.index',
        "icon": Avatar,
    },
    {
        "title": "menu.help",
        "route": 'support.index',
        "icon": TakeawayBox,
    }

]

export default items;
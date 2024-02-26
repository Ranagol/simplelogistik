import moment from "moment";

export function useDateTimeFormatter(dateString) {
    const dateObject = moment(dateString);
    return dateObject.format("DD.MM.YYYY HH:mm");
}
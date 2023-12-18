/**
 * Used to format the date in the table
 */
import moment from 'moment';

export function useDateFormatter(dateString) {
    const dateObject = moment(dateString);
    return dateObject.format('DD.MM.YYYY');
}


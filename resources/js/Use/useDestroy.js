import { router } from '@inertiajs/vue3';

/**
 * Deletes a record from the database.
 * 
 * @param {String} warningMessage Example: Are you sure you want to delete this address?
 * @param {String} url Example: addresses
 * @param {String} id  Example: 32
 * @param {String} modelName Example: address
 * @param {String} propNameForPageReload Example: record
 * @param {String} reRoutingUrl Example: http://localhost/addresses/32/localhost/addresses
 * 
 * At the end of delete, we either simply refresh the page (then we use propNameForPageReload), or 
 * we reroute to a new page (then we use reRoutingUrl).
 */
export function useDestroy(
    warningMessage, 
    url, 
    id, 
    modelName, 
    propNameForPageReload = null,
    reRoutingUrl = null
) {

    // Asks for confirmation message, for deleting the address.
    ElMessageBox.confirm(
        warningMessage,
        'Warning',
        {
            confirmButtonText: 'OK',
            cancelButtonText: 'Cancel',
            type: 'warning',
        }
    )
    .then(() => {
        //If the deleting wish is confirmed, then we send the delete request to the backend.
        router.delete(
            `/${url}/${id}`, 
            {
                onSuccess: () => {
                    console.log('useDestroy onSuccess triggered')
                    ElMessage({
                        message: `${modelName} deleted successfully`,
                        type: 'success',
                    });

                    //If we want to just refresh the current page
                    if(propNameForPageReload) {
                        router.reload({ only: [propNameForPageReload] })
                    }

                    //rerouting to the listing/index page, when all is done.
                    if(reRoutingUrl) {
                        console.log('reRoutingUrl: ', reRoutingUrl)
                        router.visit(reRoutingUrl, { method: 'get' });//http://localhost/addresses/32/localhost/addresses 404 (Not Found)
                    }
                    
                },
                onError: (errors) => {
                    console.log('useDestroy onError triggered')
                    ElMessage.error('Oops, something went wrong while deleting a address.')
                    ElMessage(errors);
                }
            }
        );
    })
    .catch(() => {
        //If the deleting wish is canceled, then we show a message.
        ElMessage({
            type: 'info',
            message: 'Delete canceled',
        })
    })  
}

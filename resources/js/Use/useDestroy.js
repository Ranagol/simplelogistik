import { router } from '@inertiajs/vue3';

export function useDestroy(warningMessage, url, id, modelName, propNameForPageReload) {

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
                    router.reload({ only: [propNameForPageReload] })
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

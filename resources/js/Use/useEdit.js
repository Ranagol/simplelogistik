import { router } from '@inertiajs/vue3';

/**
 * This is used for general editing for all models.
 * 
 * @param {*} url the base url where we send the request. Example: /addresses
 * @param {*} id the id of the model we want to edit. Example: 1
 * @param {*} modelName the name of the model we want to edit. Example: address
 * @param {*} editableObject the object we want to edit. Example: an address object 
 * @param {*} propNameForPageReload the name of the prop (defined in controller) we want to reload. 
 * Example: record. 
 */
export function useEdit(url, id, editableObject, modelName, propNameForPageReload) {

    router.put(
        `/${url}/${id}`, 
        editableObject,
        {
            onSuccess: () => {
                console.log('useEdit onSuccess triggered')
                ElMessage({
                    message: `${modelName} edited successfully`,
                    type: 'success',
                });
                router.reload({ only: [propNameForPageReload] })
            },
            onError: (errors) => {
                console.log('useEdit onError triggered')
                ElMessage.error('Oops, something went wrong while editing a address.')
                ElMessage(errors);
            }
        }
    );
}
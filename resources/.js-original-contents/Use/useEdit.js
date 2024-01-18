import { router } from '@inertiajs/vue3';

/**
 * This is used for general editing for all models.
 * 
 * @param {String} url the base url where we send the request. Example: /addresses
 * @param {String} id the id of the model we want to edit. Example: 1
 * @param {String} modelName the name of the model we want to edit. Example: address
 * @param {Object} editableObject the object we want to edit. Example: an address object 
 * @param {String} propNameForPageReload the name of the prop (defined in controller) we want to reload. 
 * Example: record. 
 */
export function useEdit(url, id, editableObject, modelName, propNameForPageReload) {

    router.put(
        `/${url}/${id}`, 
        editableObject,
        {
            onSuccess: () => {
                ElMessage({
                    message: `${modelName} edited successfully`,
                    type: 'success',
                });
                router.reload({ only: [propNameForPageReload] })
            },
            onError: (errors) => {
                ElMessage.error('Oops, something went wrong while editing a address.')
                ElMessage(errors);
            }
        }
    );
}
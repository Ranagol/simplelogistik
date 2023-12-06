import { router } from '@inertiajs/vue3';

/**
 * @param {*} url The base url where we send the request. Example: /addresses
 * @param {*} newObject The object we want to create. Example: an address object
 * @param {*} modelName The name of the model we want to create. Example: address
 * @param {*} propNameForPageReload The name of the prop (defined in controller) we want to reload.
 */
export function useCreate(url, newObject, modelName, propNameForPageReload) {

    router.post(
        `/${url}`, 
        newObject,
        {
            onSuccess: () => {
                console.log('useCreate onSuccess triggered')
                ElMessage({
                    message: `${modelName} created successfully`,
                    type: 'success',
                });
                router.reload({ only: [propNameForPageReload] })
            },
            onError: (errors) => {
                console.log('useCreate onError triggered')
                ElMessage.error('Oops, something went wrong while creating a address.')
                ElMessage(errors);
            }
        }
    );
}
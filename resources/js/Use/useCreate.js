import { router } from '@inertiajs/vue3';

/**
 * @param {String} url The base url where we send the request. Example: /addresses
 * @param {Object} newObject The object we want to create. Example: an address object
 * @param {String} modelName The name of the model we want to create. Example: address
 * @param {String} propNameForPageReload The name of the prop (defined in controller) we want to reload.
 * @param {String} reRoutingUrl The url we want to reroute to, after the create is done.
 * 
 * This composable can create new object in the backend db. It can send the request, and it can display
 * a feedback message, if the create was successful or not.
 */
export function useCreate(url, newObject, modelName, propNameForPageReload, reRoutingUrl) {

    router.post(
        `/${url}`, 
        newObject,
        {
            onSuccess: (testing) => {
                ElMessage({
                    message: `${modelName} created successfully`,
                    type: 'success',
                });
                
                /**
                     * If we want to just refresh the current page.
                     */
                if(propNameForPageReload) {
                    router.reload({ only: [propNameForPageReload] })
                }
                
                /**
                 * rerouting to the listing/index page, when all is done. This is a full redirect.
                 * However, here we must use an absolute url, because we are redirecting to a new domain.
                 * Example: http://localhost/addresses
                 */
                if(reRoutingUrl) {
                    router.visit(reRoutingUrl, { method: 'get' });
                }
            },
            onError: (errors) => {
                ElMessage.error('Oops, something went wrong while creating a address.')
                ElMessage(errors);
            }
        }
    );
}
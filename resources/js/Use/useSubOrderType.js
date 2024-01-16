import { computed, props } from 'vue';

export function useSubOrderType() {

    /**
     * The order can have either a pamyra_order or a native_order property. Either, or. We have a lot
     * of data, that we must render from this property. Since we don't know which property is set in
     * the order, we must display this key dynamically. This dynamic key rendering is done in this
     * computed property.
     * Now, in order to use dynamic keyes in an object, we must use the [] notation. Not dot notation.
     * This happens in the hmtl part of this component.
     */
    const subOrderType = computed(
        () => {
            if (props.order.pamyra_order !== null) {
                return 'pamyra_order';
            }
            if (props.order.native_order !== null) {
                return 'native_order';
            }
        }
    );

    return {
        subOrderType,
    }
}
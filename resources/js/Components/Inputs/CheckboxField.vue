<script setup>
    import { onMounted } from 'vue';

    const props = defineProps({
        store: Object,
        field: Object,
        data: Object,
    })

    const onInput = (name, value) => {
        console.log(props.store)
        console.log(name, value)
        props.store.update(name,value)
    }

    // var value = ref(props.store?.record[props.field.name])
    var value = props.data[props.field.name]

    onMounted(() => {
        initFlowbite()
    })

    const _id = Math.random().toString(36).substring(7);
</script>

<template>
    <div class="grid justify-start grid-flow-col pt-2 place-items-center">
        <input :id="_id" :checked="value" @change="(e) => onInput(field.name, e.target.checked)" type="checkbox">
        <label :for="_id" class="pl-2">{{ $t(field.label ?? field.placeholder) }}</label>
    </div>
</template>
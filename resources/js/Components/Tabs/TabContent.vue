<template>
    <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" :id="target" role="tabpanel" :aria-labelledby="'tab-' + target" >
        <slot name="content">
            <component :is="content" />
        </slot>
    </div>
</template>

<script>
export default {
    props: {
        content: {
            type: Object,
            required: true
        },
        target: {
            type: String,
            required: true
        }
    }
}
</script>
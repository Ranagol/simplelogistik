<template>
    <div class="hidden rounded-lg" :id="target" role="tabpanel" :aria-labelledby="'tab-' + target" >
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
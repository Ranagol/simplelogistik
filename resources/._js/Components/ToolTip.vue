<template>
    <div class="absolute -right-6 translate-x-full z-70 bg-gray-800 text-white p-3 text-[18px] py-2 rounded text-nowrap whitespace-nowrap anchor-arrow">
        {{ $t(text) }}
    </div>
</template>

<script>
export default {
    name: 'ToolTip',
    props: {
        text: {
            type: String,
            default: ''
        }
    }
}
</script>

<style scoped>
    .anchor-arrow::before {
        content: "";
        position: absolute;
        top: 50%;
        right: 100%;
        margin-top: -5px;
        border-width: 5px;
        border-style: solid;
        border-color: transparent #000 transparent transparent;

    }
</style>

<script setup>
import {store as useStore} from "@/Stores/customerStore";
const store = useStore();


</script>
<template>
    {{ store.getOne() }}
</template>

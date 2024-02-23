<script setup>
defineProps({
    type: String,
    click: Function
})
</script>

<template>
    <button :class="getButtonStyle('index')" v-if="type==='index'">{{ $t('buttons.' + `${route().current().split(".")[0]}` + '.index') }}</button>
    <button :class="getButtonStyle('create')" v-else-if="type==='create'">{{ $t('buttons.' + `${route().current().split(".")[0]}` + '.create') }}</button>
    <button :class="getButtonStyle('store')" v-else-if="type==='store'">{{ $t('buttons.' + `${route().current().split(".")[0]}` + '.store') }}</button>
    <button :class="getButtonStyle('edit')" v-else-if="type==='edit'">{{ $t('buttons.' + `${route().current().split(".")[0]}` + '.edit') }}</button>
    <button :class="getButtonStyle('update')" v-else-if="type==='update'">{{ $t('buttons.' + `${route().current().split(".")[0]}` + '.update') }}</button>
    <button :class="getButtonStyle('destroy')" v-else-if="type==='destroy'">{{ $t('buttons.' + `${route().current().split(".")[0]}` + '.destroy') }}</button>
    <button :class="getButtonStyle('void')" v-else-if="type==='void'">{{ $t('buttons.' + `${route().current().split(".")[0]}` + '.void') }}</button>
    <button v-else>{{ $t('buttons.' + `${route().current().split(".")[0]}` + '.void') }}</button>
</template>
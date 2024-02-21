<script setup>
import Card from '@/Shared/Card.vue';
import TabContainer from '@/Components/Tab/TabContainer.vue';
defineProps({
    config: {
        type: Object,
        required: true
    }
});
</script>
<template>
    <Head
        :title="$t(config.title)"
    />
    <Card>
        <TabContainer v-if="config.type === 'tabs'" :config='config'  class="" />
    </Card>
</template>
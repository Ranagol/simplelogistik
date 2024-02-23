<script setup>
import Card from '@/Shared/Card.vue';
import TabContainer from '@/Components/Tab/TabContainer.vue';
import PageTitle from '@/Components/Page/PageTitle.vue';
import PageActions from '@/Components/Page/PageActions.vue';
import FormContainer from '@/Components/Forms/FormContainer.vue';
const props = defineProps({
    config: {
        type: Object,
        required: true
    },
    edit: {
        type: Boolean,
        required: false,
        default: false
    }
});

</script>
<template>
    <Head
        :title="$t(config.title)"
    />
    <PageTitle :title="config.title" />
    <PageActions position="top" :actions="config" />
    <Card>
        <TabContainer v-if="config.type === 'tabs'" :config='config'  />
        <FormContainer v-else-if="config.type === 'form'" :config='config'  />
    </Card>
</template>
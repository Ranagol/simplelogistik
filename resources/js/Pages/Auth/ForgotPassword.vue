<template>
        <Head title="Forgot Password" />

        
        <form @submit.prevent="submit" class="flex w-full">
            <div class="flex flex-1 w-3/6 h-screen shadow-lg bg-slate-900 bg-auth backdrop-blur-2xl shadow-slate-800"></div>
            <div class="grid w-3/6 h-screen place-items-center">
                <div class="w-full p-6 md:w-3/5">
                    <div v-if="status" class="p-3 mb-4 text-sm font-bold text-green-600 bg-green-300 border border-green-400 rounded-md shadow-md shadow-gray-300">
                        {{ status }}
                    </div>
                    <div class="mb-4 text-lg font-bold text-center text-gray-600">
                        {{ $t('password.forgot.headline') }}
                    </div>
                    <div class="mb-4 text-sm text-center text-gray-600">
                        {{ $t('password.forgot.info') }}
                    </div>
                    <div class="relative pb-8">
                        <InputLabel :for="form.email">{{ $t('labels.mail') }}</InputLabel>
                        <TextInput
                            class="w-full p-3 text-gray-700 rounded-lg"
                            type="email"
                            v-model="form.email"
                            :error="form.errors.email"
                            required
                            autofill="None" />
                        <InputError class="absolute w-full text-right" :message="form.errors.email" />
                    </div>
                    <div class="grid grid-flow-col place-items-between">
                        <Link :href="route('login')" class="hover:underline">{{ $t('button.back-login') }}</Link>
                        <PrimaryButton class="place-self-end" @click="submit">
                            {{ $t('button.request-password') }}</PrimaryButton>
                    </div>
                </div>
            </div>
        </form>
</template>

<script setup lang="ts">
    import InputError from '@/Components/InputError.vue';
    import InputLabel from '@/Components/InputLabel.vue';
    import PrimaryButton from '@/Components/PrimaryButton.vue';
    import TextInput from '@/Components/TextInput.vue';
    import { Head, useForm } from '@inertiajs/vue3';

    defineProps<{
        status?: string;
    }>();

    const form = useForm({
        email: '',
    });

    const submit = () => {
        form.post(route('password.email'));
    };
</script>
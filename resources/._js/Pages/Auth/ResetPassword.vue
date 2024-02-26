<template>
    <Head title="Forgot Password" />
   
    <form @submit.prevent="submit" class="flex w-full">
        <div class="flex flex-1 w-3/6 bg-slate-900 h-screen bg-auth backdrop-blur-2xl shadow-lg shadow-slate-800"></div>
        <div class="grid w-3/6 place-items-center h-screen">
            <div class="p-6 w-full md:w-3/5">
                <div class="mb-4 text-lg font-bold text-gray-600 text-center">
                    {{ $t('password.forgot.headline') }}
                </div>
                <div class="mb-4 text-sm text-gray-600 text-center">
                    {{ $t('password.forgot.info') }}
                </div>
                <div class="pb-8 relative">
                    <InputLabel :for="form.email">{{ $t('mail') }}</InputLabel>
                    <TextInput
                        class="p-3 rounded-lg w-full"
                        type="email"
                        v-model="form.email"
                        :error="form.errors.email"
                        required
                        autofill="None" />
                    <InputError class="absolute text-right w-full" :message="form.errors.email" />
                </div>
                <div class="pb-8 relative">
                    <InputLabel :for="form.password">{{ $t('password') }}</InputLabel>
                    <TextInput
                        class="p-3 rounded-lg w-full"
                        type="password"
                        v-model="form.password"
                        :error="form.errors.password"
                        required
                        autofill="None" />
                    <InputError class="absolute text-right w-full" :message="form.errors.password" />
                </div>
                <div class="pb-8 relative">
                    <InputLabel :for="form.password_confirmation">{{ $t('password.confirmation') }}</InputLabel>
                    <TextInput
                        class="p-3 rounded-lg w-full"
                        type="password"
                        v-model="form.password_confirmation"
                        :error="form.errors.password_confirmation"
                        required
                        autofill="None" />
                    <InputError class="absolute text-right w-full" :message="form.errors.password_confirmation" />
                </div>
                <div class="grid grid-flow-col place-items-between">
                    <Link :href="route('login')" class="hover:underline">{{ $t('back.login') }}</Link>
                    <PrimaryButton class="place-self-end" @click="submit">
                    {{ $t('password.save') }}</PrimaryButton>
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

const props = defineProps<{
    email: string;
    token: string;
}>();

const form = useForm({
    token: props.token,
    email: props.email,
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('password.store'), {
        onFinish: () => {
            form.reset('password', 'password_confirmation');
        },
    });
};
</script>

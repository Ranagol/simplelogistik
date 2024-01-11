<template>
    <Head title="Login" />

    <div class="flex flex-1 w-3/6 bg-slate-900 h-screen bg-auth backdrop-blur-2xl shadow-lg shadow-slate-800"></div>
    <div class="grid w-3/6 place-items-center h-screen">
        <div class="p-6 w-full md:w-3/5">
            <div class="p-8 w-full flex justify-center">
                <img src="/images/logo.png" alt="logo" class="h-12 object-contain ">
            </div>
            <div class="pb-6 relative">
                <InputLabel :for="form.email">{{ $t('mail') }}</InputLabel>
                <TextInput
                    class="p-3 text-gray-700 rounded-lg w-full"
                    label="Email"
                    type="email"
                    v-model="form.email"
                    :error="form.errors.email"
                    required
                    autofill="None" />
                <InputError class="absolute text-right w-full" :message="form.errors.email" />
            </div>
            <div class="pb-6 relative">
                <InputLabel :for="form.password">{{ $t('password') }}</InputLabel>
                <TextInput
                    class="p-3 text-gray-700 rounded-lg w-full"
                    label="Email"
                    type="email"
                    v-model="form.password"
                    :error="form.errors.password"
                    required
                    autofill="None" />
                <InputError class="absolute text-right w-full" :message="form.errors.email" />
            </div>
            <div class="pb-6 relative">
                <InputLabel :for="form.remember">
                    <Checkbox 
                        name="remember"
                        v-model:checked="form.remember"
                    />
                    <span class="pl-3">{{ $t('remember.login') }}</span>
                </InputLabel>
                <InputError class="absolute text-right w-full" :message="form.errors.email" />
            </div>
            <div class="grid grid-flow-col place-items-between">
                <Link v-if="canResetPassword" :href="route('password.request')" class="hover:underline">{{ $t('password.forgot') }}</Link>
                <PrimaryButton class="place-self-end" @click="submit">
                    {{ $t('login') }}</PrimaryButton>
            </div>
        </div>
    </div>
    
</template>

<script setup lang="ts">
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import Card from '@/Shared/Card.vue';


defineProps<{
    canResetPassword?: boolean;
    status?: string;
}>();

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => {
            form.reset('password');
        },
    });
};
</script>


<template>
    <Head title="Login" />

    <Card>
        <div class="vertical-distancer"></div>

        <el-row justify="center">
            <el-col :span="8">

                <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
                    {{ status }}
                </div>

                <form class="w-full" @submit.prevent="submit">

                    <!-- EMAIL ADDRESS -->
                    <div>
                        <InputLabel for="email" value="Email" class="text-color" />

                        <TextInput
                            id="email"
                            type="email"
                            class="mt-1 block w-full"
                            v-model="form.email"
                            required
                            autofocus
                            autocomplete="username"
                        />

                        <InputError class="mt-2" :message="form.errors.email" />
                    </div>

                    <!-- PASSWORD -->
                    <div class="mt-4">
                        <InputLabel for="password" value="Password" class="text-color" />

                        <TextInput
                            id="password"
                            type="password"
                            class="mt-1 block w-full"
                            v-model="form.password"
                            required
                            autocomplete="current-password"
                        />

                        <InputError class="mt-2" :message="form.errors.password" />
                    </div>

                    <!-- REMEMBER ME -->
                    <div class="block mt-4">
                        <label class="flex items-center text-color">
                            <Checkbox name="remember" v-model:checked="form.remember" />
                            <span class="ml-2 text-sm">Remember me</span>
                        </label>
                    </div>

                    <!-- FORGOT PASSWORD? -->
                    <div class="flex items-center justify-end mt-4">
                        <Link
                            v-if="canResetPassword"
                            :href="route('password.request')"
                            class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        >
                            <span class="text-color">Forgot your password?</span>

                        </Link>

                        <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            Log in
                        </PrimaryButton>
                    </div>
                </form>
            </el-col>
        </el-row>
    </Card>
</template>

<script setup lang="ts">
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
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

<style scoped>
.vertical-distancer {
    height: 25%;
}


</style>


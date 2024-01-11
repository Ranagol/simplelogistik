<template>
    <Head title="Login" />
    <Card>
        <el-row justify="center">
            <el-col>
                <div v-if="status">
                    {{ status }}
                </div>
                <form @submit.prevent="submit">
                    <!-- EMAIL ADDRESS -->
                    <div>
                        <InputLabel for="email" value="Email" />
                        <TextInput class="w-full" id="email" type="email" v-model="form.email" required autofocus autocomplete="username" />
                        <InputError :message="form.errors.email" />
                    </div>

                    <!-- PASSWORD -->
                    <div class="mt-4">
                        <InputLabel for="password" value="Password" />
                        <TextInput class="w-full" id="password" type="password" v-model="form.password" required autocomplete="current-password" />
                        <InputError  :message="form.errors.password" />
                    </div>

                    <!-- REMEMBER ME -->
                    <div class="block mt-4">
                        <label class="flex items-center text-color">
                            <Checkbox name="remember" v-model:checked="form.remember" />
                            <span class="ps-2">Remember me</span>
                        </label>
                    </div>
                    <!-- FORGOT PASSWORD? -->
                    <div class="flex items-center justify-between mt-4">
                        <Link v-if="canResetPassword" :href="route('password.request')">
                            <span class="text-color">Forgot your password?</span>
                        </Link>
                        <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
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

</style>


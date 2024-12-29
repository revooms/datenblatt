medium.com
How to Install Laravel Jetstream with InertiaJs and Bootstrap 5
Giovanni López Orenday
8–11 minutes

Hi everyone!

This is my first post, and I’m going to show you how to Install Laravel Jetstream with InertiaJs and Bootstrap 5

By default Jetstream use tailwindcss, It’s a nice tool but some times you need to make an MVP quickly, and Bootstrap could be a helpfull tool for that. So let’s go:

First you will need a clear installation of Laravel Jetstream with InertiaJs.

After that, We need to install Bootstrap, popperjs and sass via npm:
```
npm i --save bootstrap @popperjs/core 
npm i --save-dev sass
```

Next, We will to add bootstrap alias in the vite.config.js like this way:
```
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';const path = require('path')export default defineConfig({
    resolve: {
        alias: {
          '~bootstrap': path.resolve(__dirname, 'node_modules/bootstrap'),
        }
    },
    plugins: [
        laravel({
            input: 'resources/js/app.js',
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
});
```
Create the app.scss on this path resources/scss and import the Bootstrap styles:
```
// Import all of Bootstrap's CSS 
@import "~bootstrap/scss/bootstrap";
```
Then, import this file and Bootstrap Scripts in your resources/js/app.js file:
```
import '../scss/app.scss';  // Import all of Bootstrap's JS 
import * as bootstrap from 'bootstrap'
```
Good! Now you have Bootstrap on your app.. If you want you can remove Tailwindcss.

I will give you some Vue view examples that you can replace to use Bootstrap components:

resources/js/Pages/Welcome.vue
```
<script setup>
import { Head, Link } from "@inertiajs/inertia-vue3";defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
});
</script><template>
    <Head title="Welcome" /><div class="container-fluid text-end py-2">
        <Link
            v-if="$page.props.user"
            :href="route('dashboard')"
            class="btn btn-primary"
            >Dashboard</Link
        ><template v-else>
            <Link
                :href="route('login')"
                class="btn btn-primary me-2"
                >Log in</Link
            ><Link
                v-if="canRegister"
                :href="route('register')"
                class="btn btn-secondary"
                >Register</Link
            >
        </template>
    </div>
</template>
```
resources/js/Pages/Auth/Login.vue
```
<script setup>
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";defineProps({
    canResetPassword: Boolean,
    status: String,
});const form = useForm({
    email: "",
    password: "",
    remember: false,
});const submit = () => {
    form.transform((data) => ({
        ...data,
        remember: form.remember ? "on" : "",
    })).post(route("login"), {
        onFinish: () => form.reset("password"),
    });
};
</script><template>
    <Head title="Log in" /><div class="container">
        <div class="row">
            <div class="col-md-4 offset-md-4">
                <div class="card mt-5">
                    <div class="card-body">
                        <div v-if="status" class="alert alert-success">
                            {{ status }}
                        </div>
                        <form @submit.prevent="submit">
                            <div class="mb-3">
                                <label for="email" class="form-label"
                                    >Email</label
                                >
                                <input
                                    type="email"
                                    class="form-control"
                                    id="email"
                                    v-model="form.email"
                                    required
                                    autofocus
                                />
                                <p class="text-danger" v-if="form.errors.email" v-text="form.errors.email"></p>
                            </div><div class="mb-3">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" required v-model="form.password">
                                <p class="text-danger" v-if="form.errors.password" v-text="form.errors.password"></p>
                            </div><div class="form-check">
                                <input id="remember" type="checkbox" class="form-check-input" v-model="form.remember">
                                <label for="remember" class="form-check-label">Remember me</label>
                            </div><div class="d-flex align-items-center justify-content-end mt-4">
                                <Link
                                    v-if="canResetPassword"
                                    :href="route('password.request')"
                                    class="btn btn-link"
                                >
                                    Forgot your password?
                                </Link>
                                <button type="submit" class="btn btn-primary" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Log in</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
```
resources/js/Layouts/AppLayout.vue
```
<script setup>
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import { Head, Link } from '@inertiajs/inertia-vue3';
import Menu from './Menu.vue';defineProps({
    title: String,
});const showingNavigationDropdown = ref(false);const switchToTeam = (team) => {
    Inertia.put(route('current-team.update'), {
        team_id: team.id,
    }, {
        preserveState: false,
    });
};const logout = () => {
    Inertia.post(route('logout'));
};
</script><template>
    <div>
        <Head :title="title" /><!-- <Banner /> -->
        <Menu/><div class="min-h-screen bg-gray-100">

                                    <!-- Page Heading -->
            <header v-if="$slots.header" class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>
<!-- Page Content -->
            <main class="container pt-5">
                <slot />
            </main>
        </div>
    </div>
</template>
```

resources/js/Layouts/Menu.vue
```
<script setup>
import { ref } from "vue";
import { Inertia } from "@inertiajs/inertia";
import { Head, Link } from "@inertiajs/inertia-vue3";const logout = () => {
    Inertia.post(route("logout"));
};
</script>
<template>
    <nav class="navbar navbar-expand-lg bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">App</a>
            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent"
                aria-expanded="false"
                aria-label="Toggle navigation"
            >
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <Link class="nav-link" aria-current="page" :href="route('dashboard')"
                            >Dashboard</Link
                        >
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a
                            href="#"
                            class="nav-link dropdown-toggle"
                            role="button"
                            data-bs-toggle="dropdown"
                            aria-expanded="false"
                        >
                            {{ $page.props.user.name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><hr class="dropdown-divider" /></li>
                            <li>
                                <a
                                    href="#"
                                    @click="logout"
                                    role="button"
                                    class="dropdown-item"
                                    >Log out</a
                                >
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>
```
Thank for reading and have a good day! ;)

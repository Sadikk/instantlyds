<template>
    <app-layout title="API Tokens">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                API Tokens
                <span class="text-right float-right text-lg">
                    <a href="/docs" target="_blank" class="btn btn-outline-primary btn-sm mx-3">API documentation</a>
                </span>
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <api-token-manager :tokens="tokens"
                                   :available-permissions="availablePermissions"
                                   :default-permissions="defaultPermissions" />
            </div>
        </div>
    </app-layout>
</template>

<script>
    import { defineComponent } from 'vue'
    import ApiTokenManager from '@/Pages/API/Partials/ApiTokenManager.vue'
    import AppLayout from '@/Layouts/AppLayout.vue'

    export default defineComponent({
        props: [
            'tokens',
            'availablePermissions',
            'defaultPermissions',
        ],

        components: {
            ApiTokenManager,
            AppLayout,
        },
    })
</script>

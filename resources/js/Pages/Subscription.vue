<template>
    <app-layout title="Subscription">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Subscription
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div v-if="subscribed" class="flex pt-10 pb-3">
                        <p class="text-gray-800 text-xl px-10 mt-1">
                            You're currently subscribed to : <b>{{ getSubscriptionName() }}</b>
                        </p>
                        <a href="/billing-portal" class="ml-4 btn btn-primary">Manage my subscription</a>
                    </div>
                    <plans :subscribed="subscribed" />
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import { defineComponent } from 'vue'
    import AppLayout from '@/Layouts/AppLayout.vue'
    import Plans from '@/Components/Plans.vue'

    export default defineComponent({
        components: {
            AppLayout,
            Plans,
        },
        methods: {
            getSubscriptionName() {
                if (this.subscribed) {
                    /*if (this.subscription.stripe_price === '') {
                        return 'Basic'
                    }*/
                    return 'basic'
                }
                return '';
            }
        },
        props: {
            subscribed: Boolean,
            subscription: Object
        }
    })
</script>

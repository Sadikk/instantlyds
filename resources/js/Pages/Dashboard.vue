<template>
    <app-layout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <label>Industry</label>
               <filter-dropdown field="industry" class="mb-2"></filter-dropdown>

                <label>Job title</label>
                <filter-dropdown field="job_title" class="mb-2"></filter-dropdown>

                <label>Employees</label>
                <filter-dropdown field="job_company_size" class="mb-2"></filter-dropdown>

                <label>Country</label>
                <filter-dropdown field="job_company_location_country" class="mb-2"></filter-dropdown>

                <label>Only with email</label>
                <input id="only_with_email" type="checkbox" v-model="filters.only_with_email">

                <div class="py-3 text-right">
                    <a :href="exportUrl" target="_blank" class="inline-flex justify-center py-2 px-4 border border-transparent
            shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700
            focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50 disabled:cursor-not-allowed">
                        Export CSV
                    </a>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import { defineComponent } from 'vue'
    import AppLayout from '@/Layouts/AppLayout.vue'
    import Welcome from '@/Jetstream/Welcome.vue'
    import {Link} from "@inertiajs/inertia-vue3";
    import FilterDropdown from "../Components/FilterDropdown";

    export default defineComponent({
        components: {
            FilterDropdown,
            AppLayout,
            Welcome,
            Link
        },
        props: {

        },
        data() {
            return {
                filters: {
                    only_with_email: false
                }
            }
        },
        computed: {
            exportUrl() {
                let params = new URLSearchParams(this.filters);
                return '/export?' + params;
            }
        }
    })
</script>

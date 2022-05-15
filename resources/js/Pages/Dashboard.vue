<template>
    <app-layout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
                <span class="text-right float-right text-lg">
                    <remaining-credits></remaining-credits>
                </span>
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <label>Industry</label>
               <filter-dropdown v-model:value="filters.job_company_industry" field="industry" multiple class="mb-2"></filter-dropdown>

                <label>Job title</label>
                <filter-dropdown v-model:value="filters.job_title" field="job_title" multiple class="mb-2"></filter-dropdown>

                <label>Job title level</label>
                <filter-dropdown v-model:value="filters.job_title_levels" field="job_title_levels"  multiple class="mb-2"></filter-dropdown>

                <label>Employees</label>
                <filter-dropdown v-model:value="filters.job_company_size" field="job_company_size" multiple class="mb-2"></filter-dropdown>

                <label>Country</label>
                <filter-dropdown v-model:value="filters.job_company_location_country" field="job_company_location_country"  multiple class="mb-2"></filter-dropdown>

                <label>Locality</label>
                <filter-dropdown :param="filters.job_company_location_country" v-if="filters.job_company_location_country.length > 0" v-model:value="filters.job_company_location_locality" field="job_company_location_locality"  multiple class="mb-2"></filter-dropdown>

                <div class="mt-3">
                    <input id="only_with_email" type="checkbox" v-model="filters.only_with_email"  class="form-checkbox">
                    <span @click="filters.only_with_email = !filters.only_with_email" class="ml-2 cursor-pointer">Only export with email</span>
                </div>

                <div class="py-3 text-right">
                    <div v-if="countLoading" class="spinner mr-4 w-5 h-5" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <span class="mr-4">
                        {{ previewCount }} leads will be exported
                    </span>
                    <button :disabled="!enabled" class="inline-flex justify-center py-2 px-4 border border-transparent
            shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700
            focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50 disabled:cursor-not-allowed">
                        <a :href="exportUrl" target="_blank">
                            Export CSV
                        </a>
                    </button>
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
    import {debounce} from "lodash";
    import RemainingCredits from "../Components/RemainingCredits";

    export default defineComponent({
        components: {
            FilterDropdown,
            AppLayout,
            Welcome,
            Link,
            RemainingCredits
        },
        props: {

        },
        data() {
            return {
                filters: {
                    job_company_industry: [],
                    job_title: [],
                    job_title_levels: [],
                    job_company_size: [],
                    job_company_location_country: [],
                    job_company_location_locality: [],
                    only_with_email: false
                },
                previewCount: 0,
                countLoading : false,
                previewId: ''
            }
        },
        computed: {
            exportUrl() {
                if (!this.enabled) {
                    return '#';
                }
                let params = this.buildParams(this.filters);
                return '/export?' + params;
            },
            enabled() {
                return (this.filters.job_company_industry.length > 0) || (this.filters.job_title_levels.length > 0) ||
                    (this.filters.job_company_location_country.length > 0);
            }
        },
        mounted() {
            this.getPreviewCount();
        },
        methods: {
            debounce,
            buildParams(data) {
                const params = new URLSearchParams()

                Object.entries(data).forEach(([key, value]) => {
                    if (Array.isArray(value)) {
                        value.forEach(value => params.append(key + '[]', value.toString()))
                    } else if (value != null) {
                        params.append(key, value.toString())
                    }
                });

                return params.toString()
            },
            getPreviewCount() {
                this.countLoading = true;
                this.previewId = this.getRandom();
                let r = this.previewId;
                axios.get('/count?' + this.buildParams(this.filters)).then(
                    ans => {
                        if (r === this.previewId) {
                            this.previewCount = (ans.data.count).toLocaleString(
                                undefined, // leave undefined to use the visitor's browser
                                { minimumFractionDigits: 0 }
                            );
                            this.countLoading = false;
                        }
                    }
                )
            },
            getRandom() {
                return (Math.random() + 1).toString(36).substring(7);
            }
        },
        watch: {
            filters: {
                handler() {
                    this.getPreviewCount();
                },
                deep: true
            }
        }
    })
</script>

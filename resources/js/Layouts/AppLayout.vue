<template>
    <section class="min-h-screen bg-gray-50">
        <nav
            :class="sidebarClasses">
            <Link :href="route('dashboard')">
                <jet-application-mark class="block h-9 w-auto text-gray-800" />
            </Link>
            <nav class="font-medium text-gray-600 mt-5" aria-label="Main Navigation">
                <Link class="flex items-center px-4 py-3 transition cursor-pointer group hover:bg-gray-100 hover:text-gray-900" :href="route('dashboard')" :active="route().current('features.contacts')">
                    <svg class="shrink-0 w-5 h-5 mr-2 text-gray-400 transition group-hover:text-gray-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentcolor"><path d="M10.707 2.293a1 1 0 00-1.414.0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path></svg>
                    Dashboard
                </Link>
            </nav>
        </nav>
        <div class="ml-0 transition md:ml-60">
            <nav class="flex items-center justify-between w-full px-4 h-14">
                <button class="block btn btn-light-secondary md:hidden" @click="sideBar = true">
                    <span class="sr-only">Menu</span>
                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                              d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                              clip-rule="evenodd" />
                    </svg>
                </button>
                <div class="hidden -ml-3 form-icon md:block w-96">
                    <!--<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <input class="bg-transparent border-0 form-input" placeholder="Search for articles..." />
                    -->
                </div>
                <div class="flex items-center">
                    <jet-dropdown align="right" width="48">
                        <template #trigger>
                            <button v-if="$page.props.jetstream.managesProfilePhotos" class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                <img class="h-8 w-8 rounded-full object-cover" :src="$page.props.user.profile_photo_url" :alt="$page.props.user.name" />
                            </button>

                            <span v-else class="inline-flex rounded-md">
                                            <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition">
                                                {{ $page.props.user.name }}

                                                <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </span>
                        </template>

                        <template #content>
                            <!-- Account Management -->
                            <div class="block px-4 py-2 text-xs text-gray-400">
                                Manage Account
                            </div>

                            <jet-dropdown-link :href="route('profile.show')">
                                Profile
                            </jet-dropdown-link>

                            <jet-dropdown-link :href="route('api-tokens.index')" v-if="$page.props.jetstream.hasApiFeatures">
                                API Tokens
                            </jet-dropdown-link>

                            <div class="border-t border-gray-100"></div>

                            <!-- Authentication -->
                            <form @submit.prevent="logout">
                                <jet-dropdown-link as="button">
                                    Log Out
                                </jet-dropdown-link>
                            </form>
                        </template>
                    </jet-dropdown>
                </div>
            </nav>
            <header class="bg-white shadow" v-if="$slots.header">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <slot name="header"></slot>
                </div>
            </header>
            <div class="p-4">
                <main @click="sideBar = false">
                    <jet-banner />
                    <slot></slot>
                </main>
            </div>
        </div>

        <!-- Sidebar Backdrop -->
        <div class="fixed inset-0 z-10 w-screen h-screen bg-black bg-opacity-25 md:hidden"
             x-cloak></div>
    </section>
</template>

<script>
    import { defineComponent } from 'vue'
    import JetApplicationMark from '@/Jetstream/ApplicationMark.vue'
    import JetBanner from '@/Jetstream/Banner.vue'
    import JetDropdown from '@/Jetstream/Dropdown.vue'
    import JetDropdownLink from '@/Jetstream/DropdownLink.vue'
    import JetNavLink from '@/Jetstream/NavLink.vue'
    import JetResponsiveNavLink from '@/Jetstream/ResponsiveNavLink.vue'
    import { Head, Link } from '@inertiajs/inertia-vue3';

    export default defineComponent({
        props: {
            title: String,
        },

        components: {
            Head,
            JetApplicationMark,
            JetBanner,
            JetDropdown,
            JetDropdownLink,
            JetNavLink,
            JetResponsiveNavLink,
            Link,
        },

        data() {
            return {
                showingNavigationDropdown: false,
                sideBar: false
            }
        },

        computed: {
            sidebarClasses() {
                if (this.sideBar) {
                    return "fixed top-0 left-0 z-20 h-full pb-10 overflow-x-hidden overflow-y-auto transition origin-left transform bg-white border-r w-60 md:translate-x-0 translate-x-0"
                }
                else {
                    return "fixed top-0 left-0 z-20 h-full pb-10 overflow-x-hidden overflow-y-auto transition origin-left transform bg-white border-r w-60 md:translate-x-0 -translate-x-full"
                }
            }
        },

        methods: {
            switchToTeam(team) {
                this.$inertia.put(route('current-team.update'), {
                    'team_id': team.id
                }, {
                    preserveState: false
                })
            },

            logout() {
                this.$inertia.post(route('logout'));
            },
        }
    })
</script>

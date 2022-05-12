<template>
    <section class="max-w-7xl px-4 py-8 mx-auto">
        <div class="w-full mx-auto xl:w-4/5">
            <div class="grid grid-cols-1 gap-16 lg:grid-cols-1 sm:gap-8">
                <div class="border-0 rounded-none shadow-none card sm:rounded-lg md:border">
                    <div class="flex flex-col justify-between p-6 border-b border-gray-200">
                        <div>
                            <div class="flex items-center justify-between">
                                <p class="mb-1 text-lg font-semibold text-purple-700">Basic</p>
                            </div>
                            <p class="my-2 font-mono text-4xl font-extrabold text-gray-900">$500</p>
                            <p class="text-sm text-gray-500">/ month</p>
                        </div>
                        <a v-if="!subscribed" :href="getLink('prod_Lfy2ww7lcH1K2S', 'price_1Kyc6QBfA3rv93pdDFz0yLnb')" class="w-full mt-6 btn btn-primary btn-lg">Subscribe &rarr;</a>
                    </div>
                    <ul class="flex flex-col flex-grow p-6 space-y-3">
                        <li class="flex items-start">
                            <svg viewBox="0 0 20 20" fill="currentColor" class="flex-none w-4 h-4 mt-1 mr-2 text-yellow-600">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-gray-700 font-bold">1 000 000 leads </span>
                            <span class="text-xs mt-1 text-gray-600 ml-3">that's ~ $0,0005 / lead</span>
                        </li>
                        <li class="flex items-start">
                            <svg viewBox="0 0 20 20" fill="currentColor" class="flex-none w-4 h-4 mt-1 mr-2 text-yellow-600">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-gray-700">Unlimited exports</span>
                        </li>
                        <li class="flex items-start">
                            <svg viewBox="0 0 20 20" fill="currentColor" class="flex-none w-4 h-4 mt-1 mr-2 text-yellow-600">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-gray-700">Unlimited filtering</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import { defineComponent } from 'vue'
export default defineComponent({
    components: {
    },
    props: {
        subscribed: Boolean
    },
    methods: {
        getLink(prod, price) {
            if (window.Rewardful) {
                return "/subscription-checkout?prod=" + prod + "&price=" + price + "&ref=" + Rewardful.referral
            }
            else {
                return "/subscription-checkout?prod=" + prod + "&price=" + price + "&ref="
            }

        }
    }
})
</script>

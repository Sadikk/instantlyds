<template>
    <Link :href="'/'">
        <span class="text-gray-900 text-3xl text-center py-3">
            Leadbase
        </span>
    </Link>
</template>

<script>
    import { defineComponent } from 'vue'
    import { Link } from '@inertiajs/inertia-vue3';

    export default defineComponent({
        components: {
            Link,
        },
    })
</script>

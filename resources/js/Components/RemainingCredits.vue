<template>
    <span v-if="credits === 0" class="text-red-700 text-bold text-xl mb-1 mx-auto"><b>{{ credits }}</b> remaining credits</span>
    <span v-else class="mb-1 mx-auto"><b>{{ credits }}</b> remaining credits</span>
</template>

<script>
export default {
    data() {
        return {
            credits: 0,
        }
    },
    created() {
        this.load();
    },
    methods: {
        load() {
            let answer = axios.get('/credits').then(
                answer => {
                    if (answer.data) {
                        this.credits = (answer.data.credits).toLocaleString(
                            undefined, // leave undefined to use the visitor's browser
                            { minimumFractionDigits: 0 }
                        );
                    }
                }
            );
        }
    },
};
</script>

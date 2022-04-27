<template>
    <div>
        <VueMultiselect v-model="value"
                        :options="options"
                        :multiple="multiple"
        >
        </VueMultiselect>
    </div>
</template>

<script>
import {defineComponent} from "vue";
import VueMultiselect from 'vue-multiselect'

export default defineComponent({
    components: {
        VueMultiselect
    },
    methods: {
        load() {
            axios.get('/dropdown?field=' + this.field).then(
                ans => {
                    this.options = ans.data.options;
                }
            )
        }
    },
    mounted() {
        this.load();
    },
    props: {
        field: String,
        multiple:Boolean
    },
    data() {
        return {
            value: null,
            options: []
        }
    },
    computed:{

    },
    watch: {
        value() {
            this.$emit('update:value', this.value);
        }
    }
})
</script>

<style src="vue-multiselect/dist/vue-multiselect.css"></style>

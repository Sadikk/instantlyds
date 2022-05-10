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
            axios.get('/dropdown?' + this.buildParams({ field: this.field, countries: this.param })).then(
                ans => {
                    this.options = ans.data.options;
                }
            )
        },
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
        }
    },
    mounted() {
        this.load();
    },
    props: {
        field: String,
        multiple:Boolean,
        param: Array
    },
    data() {
        return {
            value: null,
            options: []
        }
    },
    watch: {
        value() {
            this.$emit('update:value', this.value);
        },
        param() {
            this.load();
        }
    }
})
</script>

<style src="vue-multiselect/dist/vue-multiselect.css"></style>

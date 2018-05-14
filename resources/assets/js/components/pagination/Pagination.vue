<template>
    <b-pagination align="right" :total-rows="options.total" v-model="options.currentPage" @change="onPaginationChange($event)" :per-page="options.perPage"></b-pagination>
</template>
<script>
    export default {
        props: {
            options: {
                type: Object
            }
        },
        methods: {
            onPaginationChange(page){
                this.$emit('change', page)
            } 
        }
    }
</script>

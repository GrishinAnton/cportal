<template>
    <b-pagination align="right" 
        v-show="showPagination" 
        :total-rows="options.total"
        v-model="options.currentPage" 
        @change="onPaginationChange($event)" 
        :per-page="options.perPage"
        >
    </b-pagination>
</template>
<script>
    export default {
        props: {
            options: {
                type: Object
            }
        },
        computed: {
            showPagination(){

                return this.options.total > this.options.perPage
            }
        },
        methods: {
            onPaginationChange(page){
                this.$emit('change', page)
            } 
        }
    }
</script>

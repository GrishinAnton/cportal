<template>
    <div>
        <div class="flex flex_jc-fs mr-2">
            <div class="pb-2 pr-2" v-for="item in load.companies" :key="item.id">
                <b-button :size="'sm'" :variant="activeCompanies.indexOf(item.id) === -1 ? 'outline-success' : 'success'" @click.prevent="onChange(item.id, 'company')">
                    {{ item.name }}
                </b-button>
            </div>
        </div>

        <div class="flex flex_jc-fs mr-2">
            <div class="pb-2 pr-2" v-for="item in load.groups" :key="item.id">
                <b-button :size="'sm'" :variant="activeGroups.indexOf(item.id) === -1 ? 'outline-success' : 'success'" @click.prevent="onChange(item.id, 'group')">
                    {{ item.name }}
                </b-button>
            </div>
        </div>
    </div>
    
</template>


<script>
    import { personalMixin } from './../../mixins/personalMixin';

    export default {
        mixins: [personalMixin],
        props: {
            activeCompanies: {
                type: Array,
                required: true
            },
            activeGroups: {
                type: Array,
                required: true
            }
        },
        methods: {
            onChange(id, item){
                var obj = {
                    id: id,
                    item: item
                }      
                this.$emit('filterButtonChange', obj)
                
            }
        }
    }
</script>

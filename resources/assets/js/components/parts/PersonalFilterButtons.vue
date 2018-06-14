<template>
    <div>
        <div class="flex flex_jc-fs mr-2" v-if="activeCompanies">
            <div class="pb-2 pr-2" v-for="item in load.companies" :key="item.id">
                <b-button :size="'sm'" :variant="activeCompanies.indexOf(item.id) === -1 ? 'outline-success' : 'success'" @click.prevent="onChange(item.id, 'company')">
                    {{ item.name }}
                </b-button>
            </div>
        </div>

        <div class="flex flex_jc-fs mr-2" v-if="activeGroups">
            <div class="pb-2 pr-2" v-for="item in load.groups" :key="item.id">
                <b-button :size="'sm'" :variant="activeGroups.indexOf(item.id) === -1 ? 'outline-success' : 'success'" @click.prevent="onChange(item.id, 'group')">
                    {{ item.name }}
                </b-button>
            </div>
        </div>

        <div class="flex flex_jc-fs mr-2" v-if="activeStatus">
            <div class="pb-2 pr-2" v-for="item in load.status" :key="item.id">
                <b-button :size="'sm'" :variant="activeStatus.indexOf(item.id) === -1 ? 'outline-success' : 'success'" @click.prevent="onChange(item.id, 'status')">
                    {{ item.name }}
                </b-button>
            </div>
        </div>

    </div>
    
</template>


<script>
    import { loadGroupAndCompany } from './../../mixins/loadGroupAndCompany';

    export default {
        mixins: [loadGroupAndCompany],
        props: {
            activeCompanies: {
                type: Array,
            },
            activeGroups: {
                type: Array,
            },
            activeStatus: {
                type: Array,
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

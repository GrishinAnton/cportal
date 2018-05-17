<template>
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Список сотрудников</h3>
        </div>
        <div class="box-header">
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

        <div class="box-body">
            <b-table bordered hover :items="table.items" :fields="table.fields">
                <template slot="index" slot-scope="data">
                    {{data.index + 1}}
                </template>
                <template slot="firstName" slot-scope="data">
                    <a :href="data.item.url">
                        {{data.item.firstName}} {{data.item.lastName}}
                    </a>
                </template>
            </b-table>
        </div>

        <div class="box-footer">
            <b-pagination align="right" 
                v-show="showPagination" 
                :total-rows="paginationData.total"
                v-model="paginationData.currentPage" 
                @change="onPaginationChange($event)" 
                :per-page="paginationData.perPage"
                >
            </b-pagination>
        </div>
    </div>
</template>

<script>
    import { personalMixin } from './../../mixins/personalMixin';
    import { paginationMixin } from './../../mixins/paginationMixin';
    import { personalFilter } from './../../mixins/personalFilter';

    export default {
        mixins: [paginationMixin, personalMixin, personalFilter],
        data: ()=> ({
            personalInformation: [],            
            table: {
                fields: {},
                items: []
            }
        }),        
        methods: {         
            sortTableData(data){
                
                this.table.fields = {
                    index: {label: '#'},
                    firstName: {label: 'Имя Фамилия'},
                    email: {label: 'E-mail'},
                    coefficient: {label: 'К'},
                    closedHours: {label: 'Закрыто ч.', sortable: true},
                    previousWeeksCloseHours: {label: 'Закрыто ч. неделя', sortable: true},
                    company: {key: 'company.name', label: 'Компания'},
                    group: {key: 'group.name', label: 'Группа'},
                    fine: {label: 'Штрафы', sortable: true},
                    salary: {label: 'ЗП', sortable: true},
                }
                this.table.items = data
            }
        }       
    }
</script>


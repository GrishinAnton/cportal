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

            <button-toggle @toggle="salaryShowToggle" :toggleText="toggleText"></button-toggle>            

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
                <template slot="salary" slot-scope="data">
                    <span v-show="toggleText">
                        {{data.item.salary}}
                    </span>
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

    import buttonToggle from './../parts//buttonToggle'

    export default {
        mixins: [paginationMixin, personalMixin, personalFilter],
        components: {
            buttonToggle
        },
        data: ()=> ({
            personalInformation: [],            
            table: {
                fields: {},
                items: []
            },
            toggleText: ''

        }),        
        methods: {         
            sortTableData(data){
                
                this.table.fields = {
                    index: {label: '#'},
                    firstName: {label: 'Имя Фамилия'},
                    email: {label: 'E-mail'},
                    coefficient: {label: 'К'},
                    closedHours: {label: 'Закрыто ч.', sortable: true, tdClass: this.showHowWeekHours},
                    previousWeeksCloseHours: {label: 'Закрыто ч. неделя', sortable: true},
                    company: {key: 'company.name', label: 'Компания'},
                    group: {key: 'group.name', label: 'Группа'},
                    fine: {label: 'Штрафы', sortable: true},
                    salary: {label: 'ЗП', sortable: true},
                }
                this.table.items = data
            },
            showHowWeekHours(value){
                 return value <= 30 ? 'table-danger' : '';
                 
            },
            salaryShowToggle(){                
                this.toggleText = !this.toggleText
                localStorage.setItem('showTableSalary', this.toggleText)
            }
        },
        mounted() {            
            this.toggleText = localStorage.getItem('showTableSalary') ? JSON.parse(localStorage.getItem('showTableSalary')) : true;           
        }       
    }
</script>


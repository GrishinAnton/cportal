<template>
  <div class="box">
        <div class="box-header">
            <h3 class="box-title">Список сотрудников</h3>
        </div>
        <div class="box-header">
            
            <personal-filter-buttons @filterButtonChange="onChange" :activeGroups="activeGroups" :activeCompanies="activeCompanies"></personal-filter-buttons>
            
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

    import { paginationMixin } from './../../mixins/paginationMixin';
    import { personalFilter } from './../../mixins/personalFilter';

    import PersonalFilterButtons from './../parts/PersonalFilterButtons'

     export default {
        mixins: [paginationMixin, personalFilter],
        components: {
            PersonalFilterButtons
        },
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
                    coefficient: {label: '14.05-20.05', sortable: true},
                    closedHours: {label: '7.05-13.05', sortable: true},
                    previousWeeksCloseHours: {label: '30.04-6.05', sortable: true},
                    fine: {label: '23.04-29.04', sortable: true},
                    salary: {label: '16.04-22.04', sortable: true},
                }
                this.table.items = data
            },      
        },
        mounted() {
            axios.get('/api/report/productivity')
                .then(response => {
                    
                })
                .catch();
        }
    }
</script>

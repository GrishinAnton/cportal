<template>
  <div class="box">
        <div class="box-header">
            <h3 class="box-title">Список сотрудников</h3>
        </div>
        <div class="box-header">
            
            <personal-filter-buttons @filterButtonChange="onChange" :activeGroups="activeGroups" :activeCompanies="activeCompanies"></personal-filter-buttons>
            
        </div>

        <div class="box-body">
            <b-table bordered hover :items="table.items" :fields="table.fields" :sort-compare="sort">
                <template slot="index" slot-scope="data">
                    {{data.index + 1}}
                </template>
                <template slot="firstName" slot-scope="data">
                    <a :href="data.item.url">
                        {{data.item.first_name}} {{data.item.last_name}}
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
            },
            requestUrl: `/api/report/productivity`
        }),        
        methods: {      
            sort(a, b, key){  
                var key = key.slice(0,-6)

                return a[key].hours < b[key].hours ? -1 : (a[key].hours > b[key].hours ? 1 : 0);         
            },   
            sortTableData(data){
               
                this.table.fields = {
                    index: {label: '#'},
                    firstName: {label: 'Имя Фамилия'},
                    week1: {key: 'week1.hours', label: data[0].week1.date, sortable: true, tdClass: this.showHowWeekHours},
                    week2: {key: 'week2.hours', label: data[0].week2.date, sortable: true, tdClass: this.showHowWeekHours},
                    week3: {key: 'week3.hours', label: data[0].week3.date, sortable: true, tdClass: this.showHowWeekHours},
                    week4: {key: 'week4.hours', label: data[0].week4.date, sortable: true, tdClass: this.showHowWeekHours},
                    week5: {key: 'week5.hours', label: data[0].week5.date, sortable: true, tdClass: this.showHowWeekHours},
                    week6: {key: 'week6.hours', label: data[0].week6.date, sortable: true, tdClass: this.showHowWeekHours},
                }

                this.table.items = data
            },  
            showHowWeekHours(value){
                
                if (value <= 30) {
                    return 'table-danger';
                } else if (value <= 35) {
                    return 'table-warning';
                }
                
                return '';                 
            },    
        }
    }
</script>

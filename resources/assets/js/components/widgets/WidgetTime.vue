<template>
  <div class="box">
        <div class="box-header">
            <h3 class="box-title">Отработанное время</h3>
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
            requestUrl: `/api/report/productivity-two-week`
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
                    last_week: {key: 'last_week.hours', label: data[0].last_week.date, sortable: true, tdClass: this.showHowWeekHours},
                    current_week: {key: 'current_week.hours', label: data[0].current_week.date, sortable: true, tdClass: this.showHowWeekHours},
                    Mon: {key: 'Mon.hours', label: data[0].Mon == undefined ? '' : data[0].Mon.date, sortable: true, tdClass: this.showHowDayHours},
                    Tue: {key: 'Tue.hours', label: data[0].Tue == undefined ? '' : data[0].Tue.date, sortable: true, tdClass: this.showHowDayHours},
                    Wed: {key: 'Wed.hours', label: data[0].Wed == undefined ? '' : data[0].Wed.date, sortable: true, tdClass: this.showHowDayHours},
                    Thu: {key: 'Thu.hours', label: data[0].Thu == undefined ? '' : data[0].Thu.date, sortable: true, tdClass: this.showHowDayHours},
                    Fri: {key: 'Fri.hours', label: data[0].Fri == undefined ? '' : data[0].Fri.date, sortable: true, tdClass: this.showHowDayHours},
                    Holidays: {key: 'Holidays.hours', label: data[0].Holidays  == undefined ? '' : data[0].Holidays.date, sortable: true, tdClass: this.showHowDayHours},
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
            showHowDayHours(value){
                
                if (value <= 4) {
                    return 'table-danger';
                } else if (value <= 6) {
                    return 'table-warning';
                } else if (value <= 7) {
                    return 'table-info';
                } else if (value > 7) {
                    return 'table-success';
                }
                
                return '';                 
            },   
        }
    }
</script>
<style>

.table th:empty,
 .table td:empty {
    display: none;
}
</style>

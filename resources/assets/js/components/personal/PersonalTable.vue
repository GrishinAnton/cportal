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
            <b-table bordered hover :items="table.items" :fields="table.fields"></b-table>
        </div>
        

        <!-- <div class="box-body">
            <table class="table table-hover table-bordered">
                <tbody>
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>Имя Фамилия</th>
                        <th>E-mail</th>
                        <th>К</th>
                        <th>Закрыто ч.</th>
                        <th>Закрыто ч. неделя</th>
                        <th>Компания</th>
                        <th>Группа</th>
                        <th>Штрафы</th>
                        <th>ЗП</th>
                    </tr>
                    <tr v-for="item in personalInformation" :key="item.id">
                        <td>{{ item.id }}</td>
                        <td><a :href="item.url">{{ item.firstName }} {{ item.lastName }}</a></td>
                        <td>{{ item.email }}</td>
                        <td>{{ item.coefficient }}</td>
                        <td>{{ item.closedHours }}</td>
                        <td>{{ item.previousWeeksCloseHours }}</td>
                        <td>{{ item.company ? item.company.name : '' }}</td>
                        <td>{{ item.group ? item.group.name : ''}}</td>
                        <td>{{ item.fine }}</td>
                        <td>{{ item.solary }}</td>
                       </tr>
                </tbody>
            </table>
        </div> -->

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

    export default {
        mixins: [paginationMixin, personalMixin],
        data: ()=> ({
            personalInformation: [],
            activeGroups: [],
            activeCompanies: [],
            table: {
                fields: {},
                items: []
            }
        }),        
        methods: {
            onChange(id, item){

                var arrName;

                if(item === 'group'){
                    arrName = this.activeGroups;
                }
                if(item === 'company'){
                    arrName = this.activeCompanies;      
                }

                var arrPosition = arrName.indexOf(id);

                if(arrPosition === -1){
                    arrName.push(id);
                } else {         
                    arrName.splice(arrPosition, 1);
                } 

                this.requestFilter()
                
            },
            requestFilter(){

                axios.get('/api/personal', {
                    params: {
                        group: this.activeGroups,
                        company: this.activeCompanies
                    }
                })
                .then(response => {

                    this.activeGroups.length ? localStorage.setItem('activeGroup', this.activeGroups) : localStorage.removeItem('activeGroup');

                    this.activeCompanies.length ? localStorage.setItem('activeCompanies', this.activeCompanies) : localStorage.removeItem('activeCompanies');
              
                    this.sortTableData(response.data.data);                 

                    //pagination
                    this.paginationDataChange(response.data)
                    
                })
                .catch(e=> {
                    console.log(e);
                    
                })

            },
            sortTableData(data){
                console.log(data);
                
                this.table.fields = {
                    id: {label: '#'},
                    firstName: {label: 'Имя Фамилия', formatter: 'fullName'},
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
            },

        },
        mounted(){
            if(!localStorage.length){
                
                axios.get('/api/personal')
                    .then(response => {
                        this.sortTableData(response.data.data);

                        //pagination
                        this.paginationDataChange(response.data)
                    })
                    .catch(e => {
                        console.log(e);
                    })
            } else {      

                var localGroup = localStorage.getItem('activeGroup');
                var localCompany = localStorage.getItem('activeCompanies');
                 
                var arrGroup = localGroup ? localGroup.split(',') : localStorage.removeItem('activeGroup');
                this.activeGroups = _.map(arrGroup, _.parseInt) 

                var arrCompany = localCompany ? localCompany.split(',') : localStorage.removeItem('activeCompanies');     
                this.activeCompanies = _.map(arrCompany, _.parseInt) 

                this.requestFilter()

            } 
        }
    }
</script>


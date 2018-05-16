<template>
    <div class="box">
        <div class="box-header flex flex_jc-sb">
            <h3 class="box-title">Отчет</h3>
            <div class="col-sm-1">
                <select class="form-control" v-model="year" @change="renderTableByYaer">
                    <option value="2017">2017</option>
                    <option value="2018">2018</option>
                </select>
            </div>
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
            <!-- <table class="table table-hover table-bordered">
                <thead>
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>Имя Фамилия</th>
                        <th class="text-center">Январь</th>
                        <th class="text-center">Февраль</th>
                        <th class="text-center">Март</th>
                        <th class="text-center">Апрель</th>
                        <th class="text-center">Май</th>
                        <th class="text-center">Июнь</th>
                        <th class="text-center">Июль</th>
                        <th class="text-center">Август</th>
                        <th class="text-center">Сентябрь</th>
                        <th class="text-center">Октябрь</th>
                        <th class="text-center">Ноябрь</th>
                        <th class="text-center">Декабрь</th>
                    </tr>
                </thead>
                <tbody v-for="personal in personals" :key="personal.id">
                    <tr>
                        <td>{{ personal.id }}</td>
                        <td v-b-toggle="personal.id">{{ personal.first_name }} {{ personal.last_name }}</td>
                        <td @click="openmodal()"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <b-collapse :id="personal.id" tag="tr">
                        <td></td>
                        <td class="text-right">проект</td>
                        <td>data 1</td>  
                        <td>data 1</td>
                    </b-collapse>
                </tbody>
            </table>     -->
            <b-table bordered hover :items="table.items" :fields="table.fields">
                <template slot="index" slot-scope="data">
                    {{data.index + 1}}
                </template>
                <template slot="firstName" slot-scope="data">
                    <a @click.stop="data.toggleDetails">
                        {{data.item.firstName}} {{data.item.lastName}}
                        
                    </a>                   
                </template>
                <template slot="row-details" @change="rowChange()" slot-scope="data">
                    <tr>
                        <ul>
                            <li >{{data.item.email}}</li>
                        </ul>
                    </tr>
                </template>
            </b-table>
            <b-modal ref="modal" title="Фиксированная зарплата">
                <input type="text" class="form-control">
                <div slot="modal-footer" class="w-100 d-flex justify-content-between">
                    <button type="button" class="btn btn-default pull-left" @click="closeModal()">Закрыть</button>
                    <button type="button" class="btn btn-primary">Сохранить</button>
                </div>
            </b-modal>  
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
    import { personalMixin } from './../mixins/personalMixin';
    import { paginationMixin } from './../mixins/paginationMixin';

    export default {
        mixins: [paginationMixin, personalMixin],
        data: ()=> ({
            personalInformation: [],
            activeGroups: [],
            activeCompanies: [],
            table: {
                fields: {},
                items: [] 
            },
            year: 2018,
         }), 
        methods: {
            openmodal(){
                this.$refs.modal.show()
            },
            closeModal(){
                this.$refs.modal.hide()
            },
            renderTableByYaer() {
                axios.get('/api/report/worktime/'+this.year)
                    .then(response => {
                        console.log(response);
                    })
                    .catch();
            },
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
            },
            rowChange(){
                console.log("++++");
                
            }
        },
        mounted() {
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

<style>

    .collapsing {
        transition: none;
        display: table-row!important;
    }
</style>



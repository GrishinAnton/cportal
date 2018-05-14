<template>
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Список сотрудников</h3>
        </div>
        <div class="box-header">
            <div class="flex flex_jc-fs mr-2">
                <div class="pb-2 pr-2" v-for="item in load.companies" :key="item.id">
                    <b-button :size="'sm'" :variant="activeGroups.indexOf(item.id) === -1 ? 'outline-success' : 'success'" @click.prevent="onChange(item.id, 'group')">
                        {{ item.name }}
                    </b-button>
                </div>
            </div>

            <div class="flex flex_jc-fs mr-2">
                <div class="pb-2 pr-2" v-for="item in load.groups" :key="item.id">
                    <b-button :size="'sm'" :variant="activeCompanies.indexOf(item.id) === -1 ? 'outline-success' : 'success'" @click.prevent="onChange(item.id, 'company')">
                        {{ item.name }}
                    </b-button>
                </div>
            </div>
        </div>
        

        <div class="box-body">
            <table class="table table-hover table-bordered">
                <tbody>
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>Имя Фамилия</th>
                        <th>E-mail</th>
                        <th>К</th>
                        <th>Закрыто ч.</th>
                        <th>Закрыто ч. неделя</th>
                        <th>Штрафы</th>
                        <th>ЗП</th>
                    </tr>
                    <tr v-for="item in personalInformation" :key="item.id">
                        <td>{{ item.id }}</td>
                        <td><a :href="item.url">{{ item.first_name }} {{ item.last_name }}</a></td>
                        <td>{{ item.email }}</td>
                        <td>{{ item.coefficient }}</td>
                        <td>{{ item.closedHours }}</td>
                        <td>1</td>
                        <td>{{ item.fine }}</td>
                        <td>{{ item.solary }}</td>
                       </tr>
                </tbody>
            </table>
        </div>

        <div class="box-footer">
            <pagination @change="onPagination($event)" :options="paginationData"></pagination>
        </div>
    </div>
</template>

<script>
    import { personalMixin } from './../../mixins/personalMixin';
    import Pagination from './../pagination/Pagination';

    export default {
        mixins: [personalMixin],
        components: {
            Pagination
        },
        data: ()=> ({
            personalInformation: [],
            activeGroups: [],
            activeCompanies: [],
            paginationData: {
                links: {
                    first: '',
                    last: '',
                    next: '',
                    prev: ''
                },
                currentPage: 0,
                perPage: 0,
                total: 0
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
              
                    this.personalInformation = response.data.data;
                })
                .catch(e=> {
                    console.log(e);
                    
                })

            },
            onPagination(data){

                axios.get(`/api/personal`, {
                    params: {
                        page: data
                    }
                })
                    .then(response => {
                        this.personalInformation = response.data.data;   

                        //pagination
                        this.paginationData.links = response.data.links
                        this.paginationData.currentPage = response.data.meta.current_page
                        this.paginationData.perPage = response.data.meta.per_page
                        this.paginationData.total = response.data.meta.total
                    })
                    .catch(e => {
                        console.log(e);
                    }) 
            }
        },
        mounted(){
            if(!localStorage.length){
                
                axios.get('/api/personal')
                    .then(response => {
                        this.personalInformation = response.data.data;   

                        //pagination
                        this.paginationData.links = response.data.links
                        this.paginationData.currentPage = response.data.meta.current_page
                        this.paginationData.perPage = response.data.meta.per_page
                        this.paginationData.total = response.data.meta.total
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


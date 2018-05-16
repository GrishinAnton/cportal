<template>
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
</template>
<script>
    import { personalMixin } from './../../mixins/personalMixin';

     export default {
        mixins: [personalMixin],
        data: ()=> ({
            personalInformation: [],
            activeGroups: [],
            activeCompanies: [],
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

                    //pagination
                    this.paginationDataChange(response.data)
                })
                .catch(e=> {
                    console.log(e);
                    
                })

            },
        },
        mounted(){
            if(!localStorage.length){
                
                axios.get('/api/personal')
                    .then(response => {
                        this.personalInformation = response.data.data;   

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

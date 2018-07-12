<template>
    <div class="flex">

        <div class="input-group mb-3 mr-4" v-if="load.groups.length">
            <form>
                <label for="group">Группы</label>
                <select  class="custom-select" id="group"                   
                    v-model="input.group"
                    @change="onChangeGroup()"
                    >
                    <option 
                    :value="item.id"
                     v-for="item in load.groups" :key="item.id"
                    >{{ item.name }}</option>
                </select>
            </form>
        </div>
        <div class="input-group mb-3 mr-4" v-if="load.companies.length">
            <form>
                <label for="company">Компании</label>
                <select class="custom-select" id="company" 
                    
                    v-model="input.company"
                    @change="onChangeCompany()"
                    >
                    <option 
                    :value="item.id"
                    v-for="item in load.companies" :key="item.id"
                    >{{ item.name }}</option>
                </select>
            </form>
        </div> 
        <div class="input-group mb-3 mr-4" v-if="load.teamlide.length">
            <form>
                <label for="teamlide">Тимлиды</label>
                <select class="custom-select" id="teamlide" 
                    
                    
                    @change="onChangeTeamlide($event)"
                    >
                    <option 
                    :value="item.id"
                    v-for="item in load.teamlide" :key="item.id"
                    >{{ item.firstName }} {{ item.lastName }}</option>
                </select>
            </form>
        </div> 
        <b-alert :show="dismissCountDown"
                dismissible
                :variant="alertVariant"
                @dismissed="dismissCountdown=0"
                @dismiss-count-down="countDownChanged">
                <p>Данные обновлены. Закроюсь через {{dismissCountDown}} сукунд.</p>                 
        </b-alert>
    </div>           

</template>
<script>
    import { loadGroupAndCompany } from './../../mixins/loadGroupAndCompany';
    import Api from '../../utils/api'

    export default {
        mixins: [loadGroupAndCompany],
        props: {
            personalId: {
                type: Number
            }
        },
        data: () => ({            
            input: {
                group: '',
                company: '',
                
            },
            load: {
                teamlide: ''
            },
            dismissSecs: 5,
            dismissCountDown: 0,
            alertVariant: ''

        }),
        methods: {
            onChangeGroup(){                
                  
                Api.postPersonalGroup(this.personalId, {groupId: this.input.group})
                    .then(response => {

                        if(response.data.success){
                            this.alertVariant = 'success';
                            this.dismissCountDown = 5;
                        }
                    })
                    .catch(e => {
                        console.log(e)
                    })
            },
            onChangeCompany(){    

                Api.postPersonalCompany(this.personalId, {companyId: this.input.company})
                    .then(response => {
                        
                        if(response.data.success){
                            this.alertVariant = 'success';
                            this.dismissCountDown = 5;
                        }
                    })
                    .catch(e => {
                        console.log(e)
                    })

            },
            countDownChanged (dismissCountDown) {
                this.dismissCountDown = dismissCountDown;
            },

            onChangeTeamlide(e) {        
                var params = {
                    user_id: Number(e.target.value),
                    owner_id: this.personalId
                }        
                axios.post(`/api/personal/${this.personalId}/add/personal`, params)
                    .then(response => {
                        console.log(response);       
                        console.log(this.load.teamlide);
                                     
                    })
                    .catch(e=> {
                        console.log(e)
                    })
            }
        },
        mounted(){     
            
            Api.getPersonalGroupAndCompany(this.personalId)
                .then(response => {

                    if(response.data.data.group){
                        this.input.group = response.data.data.group.id;
                    }
                    if(response.data.data.company){
                        this.input.company = response.data.data.company.id;  
                    }                          
                    
                })
                .catch(e=> {
                    console.log(e)
                })

            axios.get(`/api/personal/groups/teamleads`)
                .then(response => {
                    if(response.data){
                        this.load.teamlide = response.data.data; 
                        console.log(this.load.teamlide);
                        
                    }                                       
                    
                })
                .catch(e=> {
                    console.log(e)
                })
        }
    }
</script>



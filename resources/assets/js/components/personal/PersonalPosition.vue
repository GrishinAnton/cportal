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
                    
                    v-model="input.teamlide"
                    @change="onChangeTeamlide()"
                    >
                    <option 
                    :value="item.id"
                    v-for="item in load.teamlide" :key="item.id"
                    >{{ item.firstName }} {{ item.lastName }}</option>
                </select>
            </form>
        </div> 
        <div class="input-group mb-3 mr-4" v-if="load.personal.length">
            <form>
                <label for="personal">Перейти на страницу другого сотрудника</label>
                <select class="custom-select" id="personal" 
                    v-model="input.personal"
                    @change="onChangePersonal()"
                    >
                    <option 
                    :value="item.url"
                    v-for="item in load.personal" :key="item.url"
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
        <b-modal ref="myModalRef" hide-footer class="teamlide-modal" title="Смена тимлида">
            <div class="d-block text-center" v-if="load.users.length">
                <h5>Сотрудники привязанные к тимлиду:</h5>
                <b-list-group class="mb-3 mt-3">
                    <b-list-group-item  v-for="item in load.users" :key="item.id">{{ item.firstName }} {{ item.lastName }}</b-list-group-item>
                </b-list-group>
            </div>
            <div class="d-block text-center" v-if="load.users.length">
                <h5>Сотрудников переводим тимлиду:</h5>
                <div class="input-group mb-3 mt-3">
                    <form>
                        <select class="custom-select" id="teamlide" 
                            v-model="input.teamlide"
                            >                            
                            <option 
                            :value="item.id"
                            v-for="item in load.teamlide" :key="item.id"
                            >{{ item.firstName }} {{ item.lastName }}</option>
                        </select>
                    </form>
                </div> 
            </div>
            <div class="d-block text-center">
                <h5>Новая группа:</h5>
                <div class="input-group mb-3 mt-3" v-if="load.groups.length">
                    <form>
                        <select  class="custom-select" id="group"                   
                            v-model="input.group"
                            >
                            <option 
                            :value="item.id"
                            v-for="item in load.groups" :key="item.id"
                            >{{ item.name }}</option>
                        </select>
                    </form>
                </div>
            </div>
            <b-btn class="mt-3" variant="outline-success" block @click="onSaveNewTeamlide">Сохранить</b-btn>
        </b-modal>
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
                teamlide: '',
                personal: ''             
            },
            load: {
                teamlide: '',
                users: '',
                personal: ''
            },
            dismissSecs: 5,
            dismissCountDown: 0,
            alertVariant: '',
            teamlide: false,
            requestUrl: `/api/personal`

        }),
        methods: {
            onChangeGroup(){       
                  
                if(this.input.group !== 6 &&  this.teamlide && this.load.users.length){
                    this.onChangeTeamlideGroup()
                } else {
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
                }               
                  
                
            },
            onChangeTeamlideGroup(){
                this.$refs.myModalRef.show()
                
            },
            onSaveNewTeamlide(){
                 var params = {
                    action: 'change',
                    group_id: this.input.group,
                    new_teamlead_id: this.input.teamlide,
                }

                Api.postOnSaveTeamlead(this.personalId, params)
                    .then(response => {
                        this.input.teamlide = '';
                        if(response.data.success){
                            this.alertVariant = 'success';
                            this.dismissCountDown = 5;
                            this.teamlide = false
                            this.$refs.myModalRef.hide()
                        }                        
                    })
                    .catch(e=> {
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

            onChangeTeamlide() {        
                
                var params = {
                    teamlead_id: this.input.teamlide
                } 
                Api.postOnChangeTeamLead(this.personalId, params)
                    .then(response => {                        
                        if(response.data.success){
                            this.alertVariant = 'success';
                            this.dismissCountDown = 5;
                        }      
                    })
                    .catch(e=> {
                        console.log(e)
                    })
            },
            onChangePersonal(){               
                window.location.href = this.input.personal
            }
        },
        mounted(){     
            
            Api.getPersonalGroupAndCompany(this.personalId)
                .then(response => {

                    if(response.data.data.group){
                        this.input.group = response.data.data.group.id;
                        if(response.data.data.group.id === 6){
                            this.teamlide = true
                        }
                    }
                    if(response.data.data.company){
                        this.input.company = response.data.data.company.id;  
                    }                          
                    
                })
                .catch(e=> {
                    console.log(e)
                })

            Api.getTeamleadsGroup()
                .then(response => {
                    if(response.data){
                        this.load.teamlide = response.data.data;
                    } 
                })
                .catch(e=> {
                    console.log(e)
                })            

            Api.getPersonalTeamlead(this.personalId)
                .then(response => {
                    if(response.data.data){
                        this.input.teamlide = response.data.data.id;
                    } 
                })
                .catch(e=> {
                    console.log(e)
                })
       
            if(localStorage.getItem('activeGroup') || localStorage.getItem('activeCompanies')){
              
                Api.getSomeAxiosRequest(this.requestUrl, {
                    params: {
                        group: localStorage.getItem('activeGroup').split(','),
                        company: localStorage.getItem('activeCompanies').split(',')
                    }
                })
                .then(response => {   
                    this.load.personal = response.data.data;
                })
                .catch(e => console.log(e));
            }


            this.$store.dispatch('personal/loadUsers', this.personalId);
            this.$watch(() => this.$store.getters['personal/teamLeadUsers'], () => {                
                this.load.users = this.$store.getters['personal/teamLeadUsers']                
            });
        }
    }
</script>


<style>

.teamlide-modal .input-group {
    justify-content: center;
}

.teamlide-modal .list-group {
    align-items: center;
}
</style>

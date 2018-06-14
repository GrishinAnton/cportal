<template>
    <div class="flex">

        <div class="input-group mb-3 mr-4" v-if="load.groups.length">
            <form method = "get">
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
            <form method = "get">
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
                company: ''
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
                this.dismissCountDown = dismissCountDown
            },
        },
        mounted(){           

            Api.getPersonalGroupAndCompany(this.personalId)
                .then(response => {

                    this.input.group = response.data.data.group.id
                    this.input.company = response.data.data.company.id
                    
                })
                .catch(e=> {
                    console.log(e)
                })
        }
    }
</script>



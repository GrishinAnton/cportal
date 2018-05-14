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
    import { personalMixin } from './../../mixins/personalMixin';

    export default {
        mixins: [personalMixin],
        data: () => ({            
            input: {
                group: '',
                company: ''
            },
            persId: '',
            dismissSecs: 5,
            dismissCountDown: 0,
            alertVariant: ''

        }),
        methods: {
            onChangeGroup(){                
                  
                axios.post(`/api/personal/${this.input.persId}/add/group`, {
                    groupId: this.input.group
                })
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

                axios.post(`/api/personal/${this.input.persId}/add/company`, {
                    companyId: this.input.company
                })
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

            this.$watch(() => this.$store.getters['personal/personalInformation'], () => {               
                this.input.group = this.$store.getters['personal/personalInformation'].first.group_id;
                this.input.company = this.$store.getters['personal/personalInformation'].first.company_id;
                this.input.persId = this.$store.getters['personal/personalInformation'].first.pers_id;
            }); 
        }
    }
</script>



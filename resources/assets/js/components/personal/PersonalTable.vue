<template>
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Список сотрудников</h3>
        </div>
        <div class="box-header">
            <div class="flex flex_jc-fs mr-2">
                <div class="pb-2 pr-2" v-for="item in load.companies" :key="item.id">
                    <b-button :size="'sm'" :variant="activeGroups.indexOf(item.id) === -1 ? 'outline-success' : 'success'" @click.prevent="onGroupClick(item.id)">
                        {{ item.name }}
                    </b-button>
                </div>
            </div>

            <div class="flex flex_jc-fs mr-2">
                <div class="pb-2 pr-2" v-for="item in load.groups" :key="item.id">
                    <b-button :size="'sm'" :variant="activeCompanies.indexOf(item.id) === -1 ? 'outline-success' : 'success'" @click.prevent="onCompanyClick(item.id)">
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
                        <th>Коэффициент</th>
                        <th>Закрыто часов</th>
                        <th>Штрафы</th>
                        <th>ЗП</th>
                    </tr>
                    <tr v-for="item in personalInformation" :key="item.id">
                        <td>{{ item.id }}</td>
                        <td><a :href="item.url">{{ item.first_name }} {{ item.last_name }}</a></td>
                        <td>{{ item.email }}</td>
                        <td>{{ item.coefficient }}</td>
                        <td>{{ item.closedHours }}</td>
                        <td>{{ item.fine }}</td>
                        <td>{{ item.solary }}</td>
                       </tr>
                </tbody>
            </table>
        </div>

        <div class="box-footer">
           <!-- pagination -->
        </div>
    </div>
</template>

<script>
    import { personalMixin } from './../../mixins/personalMixin'

    export default {
        mixins: [personalMixin],
        data: ()=> ({
            personalInformation: [],
            activeGroups: [],
            activeCompanies: []
        }),
        methods: {
            onGroupClick(id){

                var arrPosition = this.activeGroups.indexOf(id);

                if(arrPosition === -1){
                    this.activeGroups.push(id)
                } else {         
                    this.activeGroups.splice(arrPosition, 1)
                }  
                
                console.log(this.activeGroups);
                

                axios.get('/api/personal', {
                    group: this.activeGroups,
                    company: this.activeCompanies
                })
                .then(response => {
                    console.log(response.data);
                    
                })
                .catch(e=> {
                    console.log(e);
                    
                })
                
            },
            onCompanyClick(id){

                var arrPosition = this.activeCompanies.indexOf(id);

                if(arrPosition === -1){
                    this.activeCompanies.push(id)
                } else {         
                    this.activeCompanies.splice(arrPosition, 1)
                }  
                
                console.log(this.activeCompanies);
                

                axios.get('/api/personal', {
                    group: this.activeGroups,
                    company: this.activeCompanies
                })
                .then(response => {
                    console.log(response.data);
                    
                })
                .catch(e=> {
                    console.log(e);
                    
                })
                
            }
        },
        mounted(){
            axios.get('/api/personal')
            .then(response => {
                this.personalInformation = response.data.data
                console.log(this.personalInformation);
                
            })
            .catch(e => {
                console.log(e)
            })
        }
    }
</script>


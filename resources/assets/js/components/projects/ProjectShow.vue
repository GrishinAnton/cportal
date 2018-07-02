<template>
    <div>
        <div class="box">
            <div class="box-header flex flex_jc-sb">
                <h3 class="box-title">
                    {{ projectName }}
                </h3>
            </div>
            <div class="box-body box-body_personal-select-group flex flex_jc-fs">
                <div class="form-item form-item_bold mr-3">
                    <label for="start">Старт</label>
                    <input type="text" placeholder="Старт" id="start" class="form-control" v-model="data.start" v-mask="'##/##/####'">
                </div>  
                <div class="form-item form-item_bold mr-3">
                    <label for="finish">Финиш</label>
                    <input type="text" placeholder="Финиш" id="finish" class="form-control" v-model="data.finish" v-mask="'##/##/####'">
                </div>
                <div class="form-item form-item_bold mr-3">
                    <label for="status">Статус</label>
                    <select id="status" class="form-control" v-model="data.status">
                        <option v-for="item in projectStatus" :key="item.id" :value="item.id">{{ item.name }}</option>
                    </select>
                </div>
                <div class="form-item form-item_bold mr-3">
                    <label for="company">Компания</label>
                    <select id="company" class="form-control"  v-model="data.company">
                        <option v-for="item in projectCompany" :key="item.id" :value="item.id">{{ item.name }}</option>
                    </select>
                </div>
                <div class="form-item form-item_bold align-self-end mr-3">
                    <b-button class="project-save-button" :size="''" :variant="'success'" @click="projectStatusChange()">
                        {{ 'Сохранить' }}
                    </b-button>
                </div>
                <b-alert :show="dismissCountDown"
                    dismissible
                    :variant="alertVariant"
                    @dismissed="dismissCountdown=0"
                    @dismiss-count-down="countDownChanged">
                    <p>{{ alertMessage }}. Закроюсь через {{dismissCountDown}} сукунд.</p>                 
                </b-alert>
            </div>
            <div class="box-body box-body_personal-select-group flex flex_jc-fs">
                <table class="table table-striped table-hover w-25">
                    <tbody>
                        <tr>
                            <th class="va_m">Часов потрачено</th>
                            <td @click="openmodal('modalHour')">{{ allHoursSumm }}</td>
                        </tr>
                        <tr>
                            <th class="va_m">Часов заложено</th>
                            <td class="w-50"><input type="text" placeholder="Введите данные" id="start" class="form-control" v-model="data.hoursLaid"></td>
                        </tr>
                        <tr>
                            <th class="va_m">Стоимость часа</th>
                            <td class="w-50"><input type="text" placeholder="Введите данные" id="start" class="form-control" v-model="data.costPerHour"></td>
                        </tr>

                    </tbody>
                </table>
            </div>
            <div class="box-body box-body_personal-select-group flex flex_jc-fs">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Бюджет</th>
                            <th>Затраты</th>
                            <th>Остаток</th>
                            <th>Средний расход в неделю</th>
                            <th>Осталось недель</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="w-15"><input type="text" placeholder="Введите данные" id="start" class="form-control" v-model="data.budget"></td>
                            <td class="va_m">{{ costsFotSumm + ' ₽' }}</td>
                            <td class="va_m">{{ balanceFn + ' ₽' }}</td>
                            <td class="va_m">60 000,00 ₽</td>
                            <td class="va_m">4</td>
                        </tr>
                    </tbody>
                </table>
            </div>       
            
            <div class="box-body box-body_personal-select-group">
                <div class="box-header flex flex_jc-sb">
                    <h3 class="box-title">
                        Списания
                    </h3>
                </div>
                <table class="table table-striped table-hover w-25">
                    <tbody>
                        <tr>
                            <th>ФОТ:</th>
                            <td @click="openmodal('modalFot')">{{ allForSumm }}</td>
                        </tr>
                        <tr>
                            <th>Издержки:</th>
                            <td @click="openmodal('modalCosts')">{{  allCostsSumm }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <b-modal ref="modalHour" title="Потрачено" size="lg">
            <table class="table table-striped table-hover">
                <th v-for="item in tableHeader" :key="item">{{ item }}</th>
                <tr v-for="items in tableHoursData" :key="`${items.first_name}${items.last_name}`">
                    <td>{{ items.id }}</td>
                    <td><a :href="items.url">{{ items.first_name }} {{ items.last_name }}</a></td>
                    <td v-for="(mounth, index) in items.times" :class="tableColor(mounth)" :key="index">{{ mounth ? mounth : '' }}</td>
                </tr>
            </table>
            <div slot="modal-footer" class="w-100 d-flex justify-content-start">
                <button type="button" class="btn btn-default pull-left" @click="closeModal('modalHour')">Закрыть</button>
            </div>
        </b-modal>

        <b-modal ref="modalFot" title="Потрачено" size="lg">
            <table class="table table-striped table-hover">
                <th v-for="item in tableHeader" :key="item">{{ item }}</th>
                <tr v-for="items in tableFotData" :key="`${items.first_name}${items.last_name}`">
                    <td>{{ items.id }}</td>
                    <td><a :href="items.url">{{ items.first_name }} {{ items.last_name }}</a></td>
                    <td v-for="(mounth, index) in items.salaries" :key="index">{{ mounth ? mounth.toFixed(0) : '' }}</td>
                </tr>
            </table>
            <div slot="modal-footer" class="w-100 d-flex justify-content-start">
                <button type="button" class="btn btn-default pull-left" @click="closeModal('modalFot')">Закрыть</button>
            </div>
        </b-modal>

         <b-modal ref="modalCosts" title="Потрачено" size="lg">
            <table class="table table-striped table-hover">
                <th v-for="item in tableHeader" :key="item">{{ item }}</th>
                <tr v-for="items in tableCostsData" :key="`${items.first_name}${items.last_name}`">
                    <td>{{ items.id }}</td>
                    <td><a :href="items.url">{{ items.first_name }} {{ items.last_name }}</a></td>
                    <td v-for="(mounth, index) in items.costs" :key="index">{{ mounth ? mounth.toFixed(0) : '' }}</td>
                </tr>
            </table>
            <div slot="modal-footer" class="w-100 d-flex justify-content-start">
                <button type="button" class="btn btn-default pull-left" @click="closeModal('modalCosts')">Закрыть</button>
            </div>
        </b-modal>
    </div> 
    
</template>

<script>
    import {TheMask} from 'vue-the-mask';
    import Api from '../../utils/api'
    export default {
        props: {
            projectId: String
        },
        components: {TheMask},
        data: () => ({
            tableHoursData: '',
            tableFotData: '',
            tableCostsData: '',
            tableHeader: '',
            allHoursSumm: '',
            allForSumm: '',
            allCostsSumm: '',
            costsSumm: '',
            balance: '',
            projectStatus: '', 
            projectCompany: '',
            data: {
                start: '',
                finish: '',
                budget: '',
                costPerHour: '',
                hoursLaid: '',
                status: 1,
                company: 1,
            },
            projectName: '',
            dismissSecs: 5,
            dismissCountDown: 0,
            alertVariant: '',
            alertMessage: ''

        }),
        computed: {
            costsFotSumm() {
                this.costsSumm = Number(this.allForSumm) + Number(this.allCostsSumm);
                return  this.costsSumm;
            },
            balanceFn() {
                this.balance = Number(this.data.budget) - Number(this.costsSumm);
                return  this.balance;
            }
        },
          methods: {
            openmodal(e){ 
                this.$refs[e].show();
            },
            closeModal(e){
                this.$refs[e].hide();
            }, 
            allHours(){
                
                this.allHoursSumm = _.sumBy(this.tableHoursData, function(o) {
                    var summ = 0;

                    for(let item of o.times){
                        summ+= Number(item.split(' ')[0]);
                    } 
                    return summ;
                }).toFixed(2);        
            },
            allWriteOff(data, requestData){
                var data = data === 'fot' ? 'allForSumm' : 'allCostsSumm';             

                this[data] = _.sumBy(requestData, function(o) {           
                    var summ = 0;
                    var obj = o.salaries || o.costs;

                    for(let item in obj ){
                        summ+= obj[item];
                    };

                    return summ;
                }).toFixed(0);                  
            },
            tableColor(str){
                var number = Number(str.split(' ')[1].slice(1, -2));
                
                if(number >= 70){
                    return 'table-success';
                }

                if(number >= 30 && number < 70){
                    return 'table-warning';
                }        
            },
            projectStatusChange() {

            Api.postProjectHoursSpent(this.projectId, this.data)
                .then(response => {
                    this.alertVariant = 'success';
                    this.dismissCountDown = 5;
                    this.alertMessage = 'Данные обновлены';
                })
                .catch(e=>{
                    this.alertVariant = 'danger';
                    this.dismissCountDown = 5;
                    this.alertMessage = 'Ошибка';
                    console.log(e)
                });
            },
            countDownChanged (dismissCountDown) {
                this.dismissCountDown = dismissCountDown
            },       
        },
        mounted() {          
            Api.getProjectHoursSpent(this.projectId)
                .then(response => {
                    this.tableHoursData = response.data.data;
                    this.tableHeader = response.data.header;                    

                    this.allHours();
                    
                })
                .catch(e=>console.log(e));

            Api.getProjectFot(this.projectId)
                .then(response => {
                    this.tableFotData = response.data.data;
                    this.tableHeader = response.data.header;    

                    this.allWriteOff('fot', response.data.data);           
                })
                .catch(e=>console.log(e));

            Api.getProjectCosts(this.projectId)
                .then(response => {
                    this.tableCostsData = response.data.data;
                    this.tableHeader = response.data.header;

                    this.allWriteOff('costs', response.data.data );
                            
                })
                .catch(e=>console.log(e));

            Api.getProjectStatuses()
                .then(response => {
                    this.projectStatus = response.data.data;   
                          
                })
                .catch(e=>console.log(e));

            Api.getProject(this.projectId)
                .then(response => {
                    this.data = response.data.data;
                    this.projectName = response.data.data.name;                    
                })
                .catch(e=>console.log(e));

            Api.getCompanies(this.projectId)
                .then(response => {
                    this.projectCompany = response.data.data
                })
                .catch(e=>console.log(e));
           
        }
    }
</script>

<style>
    .modal-open .modal {
        overflow-x: auto;
    }

    .table .va_m {
        vertical-align: middle;
    }

    .alert-success {
        margin-bottom: 0;
    }
</style>

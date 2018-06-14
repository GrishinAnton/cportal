<template>

    <div>
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">
                    Зарплата
                </h3>
            </div>

            <div class="box-body">
                <div class="form-group flex form-group_w20 ">
                    <div class="form-item form-item_bold mr-5">
                        <p>Фикс ЗП</p>
                        <button type="button"  class="btn mr-1" :class="{'btn-success': changeData.fixSalary}" @click="changeData.fixSalary = true">Да</button>
                        <button type="button" class="btn" :class="{'btn-success': !changeData.fixSalary}" @click="changeData.fixSalary = false">Нет</button>
                    </div>

                    <div class="form-item form-item_bold">
                        <label for="coef">Коэффициент</label>
                        <input type="text" v-model="changeData.coef" class="form-control" placeholder="Коэффициент" id="coef">
                    </div> 
                </div>

                <div class="form-group flex form-group_w20 ">
                    <div class="form-item form-item_bold mr-5">
                        <label for="hour">Стоимость часа</label>
                        <div class="flex">
                            <input type="text" name="hours" :value="Math.trunc(staticData.salaryHour)" class="form-control mr-1" placeholder="Стоимость часа" disabled>
                            <input type="text" id="hour" class="form-control" @input="onChangeSalaryHour()" v-model="changeData.salaryHour" placeholder="Стоимость часа">
                        </div> 
                    </div> 

                    <div class="form-item form-item_bold">
                        <label for="closeHour">Закрыто часов</label>
                        <div class="flex">
                            <input type="text" name="close_hours" :value="staticData.closeHours" class="form-control mr-1" placeholder="Закрыто часов" disabled>
                            <input type="text" id="closeHour" class="form-control" @input="onChangeCloseHour()" v-model.number="changeData.closeHours" placeholder="Закрыто часов">
                        </div> 
                    </div>
                </div>

                <div class="form-group flex form-group_w20 ">
                    <div class="form-item form-item_bold mr-5">
                        <label for="fineHours">Штрафных часов</label>
                        <div class="flex">
                            <input type="text" :value="staticData.penaltyTime" class="form-control mr-1" placeholder="Штрафных часов" disabled>
                            <input type="text" class="form-control" @input="onChangeCloseHour()" v-model="changeData.penaltyTime" placeholder="Штрафных часов" id="fineHours">
                        </div> 
                    </div> 

                    <div class="form-item form-item_bold">
                        <label for="zp">ЗП</label>
                        <div class="flex">
                            <input type="text" :value="Math.trunc(staticData.salary)" class="form-control mr-1" placeholder="Зарплата" disabled>
                            <input type="text" id="zp" @input="onChangeSalary()" v-model.number="changeData.salary" class="form-control" placeholder="Зарплата">
                        </div> 
                    </div>
                </div>

                <button type = "button" @click="saveSalary()" class = "btn btn-primary w-15 mb-2">Сохранить</button>
                <b-alert :show="dismissCountDown"
                    dismissible
                    :variant="alertVariant"
                    @dismissed="dismissCountdown=0"
                    @dismiss-count-down="countDownChanged"
                    class="w-50">
                    <p>{{ alertMessage }}. Закроюсь через {{dismissCountDown}} сукунд.</p>                 
                </b-alert>
            </div>
        </div>
        <div class="box" v-if="noCosts">
            <div class="box-header">
                <h3 class="box-title">
                    Расходы по проектам
                </h3>
            </div>
            <div class="box-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Проект</th>
                            <th>Часы</th>
                            <th>% от проекта</th>
                            <th>Расход по проекту</th>
                            <th>Расход в ручную</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item, index) in costsProject.data" :key="index">
                            <td>{{ item.project }}</td>
                            <td>{{ item.worktime }}</td>
                            <td>{{ item.percent }} %</td>                           
                            <td>{{ costsProjectSalaryPercent(item.percent, item) }}</td>
                            <td>       

                                <span v-if="costsProject.costProject">{{ item.costOverride }}</span>
                                <input v-if="! costsProject.costProject" type="text" class="form-control w-25" v-model="item.costOverride">
                                
                            </td>
                        </tr>
                    </tbody>
                </table>
                <button type="button" v-if="! costsProject.costProject" class="btn btn-primary" @click="saveCosts()">Списать</button>
                <b-alert :show="costsProjectAlertCountDown"
                    dismissible
                    :variant="alertVariant"
                    @dismissed="costsProjectAlertCountDown=0"
                    @dismiss-count-down="countDownChangedCostsProgectCd"
                    class="w-50">
                    <p>{{ alertMessage }}. Закроюсь через {{costsProjectAlertCountDown}} сукунд.</p>                 
                </b-alert>
            </div>
        </div>
    </div>

</template>


<script>
    import Api from '../../utils/api'
 export default {
    props: {
        personalId: {
            type: Number,
            required: true
        },
        date: {
            type: String,
            required: true
        },
        penaltyTime: {
            type: String
        },
        closeHours: {
            type: String
        },
        noCosts: {
            type: Boolean,
            default: true
        }
    },
    data: () => ({
        flagHours: '',
        changeData: {
            fixSalary: false,
            coef: '',
            salaryHour: 0,
            closeHours: 0,
            penaltyTime: 0,
            salary: 0
        },
        staticData: {
            salaryHour: 0,
            closeHours: 0,
            penaltyTime: 0,
            salary: 0
        },
        postData: {
            salaryId: ''
        },
        costsProject: {
            data: '',
            sum: '', 
            costsMonth: '',
            costProject: ''
        },
        dismissSecs: 5,
        dismissCountDown: 0,
        costsProjectAlertCountDown: 0,
        alertVariant: '',
        alertMessage: ''
    }),
    methods: {
        onChangeSalaryHour(){
            this.staticData.salary = this.changeData.salaryHour * ((this.changeData.closeHours || this.staticData.closeHours) - (this.changeData.penaltyTime || this.staticData.penaltyTime))    
            this.flagHours = true; 
        },
        onChangeSalary(){
            this.staticData.salary = this.changeData.salary;           
            this.staticData.salaryHour = Number(this.changeData.closeHours || this.staticData.closeHours) ? Math.trunc(this.changeData.salary / (this.changeData.closeHours || this.staticData.closeHours)) : 0;
            this.flagHours = false; 
        },
        onChangeCloseHour(){
            if(this.flagHours){
                this.onChangeSalaryHour()
            } else {
                this.onChangeSalary()
            }
        },
        saveSalary(){
            var day = new Date();
            var dayForBack = `0${day.getDate()}`.slice(-2)
            var url; 

            
          
            if (this.postData.salaryId) {
                url = `/api/personal/salary/${this.postData.salaryId}/update`;
            } else {
                url = `/api/personal/${this.personalId}/salary/store`;
            }
            
            Api.getSalaryPersonalStoreUpdate(url, {
                salary: this.flagHours ? this.staticData.salary : this.changeData.salary,
                coefficient: this.changeData.coef,
                salaryHours: this.flagHours ? this.changeData.salaryHour : this.staticData.salaryHour,
                closeHours: this.changeData.closeHours || this.staticData.closeHours,
                penaltyHours: this.changeData.penaltyTime || this.staticData.penaltyTime,
                fix: this.changeData.fixSalary,
                date: `${this.date}-${dayForBack}`
            })
            .then(response => {
                if(response.data.success){
                    this.alertVariant = 'success';
                    this.dismissCountDown = 5;
                    this.alertMessage = 'Данные обновлены';
                }

                this.salary();
            })
            .catch(e=> {
                this.alertVariant = 'danger';
                this.dismissCountDown = 5;
                this.alertMessage = 'Ошибка';
                console.log(e);
                
            });
        },
        saveCosts(){
            var data = this.costsProject.data;

            this.costsProject.data.forEach((item) => {
                item.date = `${this.date}-07`
            });
           
            Api.getSalaryPersonalProjectCostStore(this.personalId, data)
            .then(response => {
                this.alertVariant = 'success';
                this.costsProjectAlertCountDown = 5;
                this.alertMessage = 'Данные обновлены'
                
                
            })
            .catch(e => {
                this.alertVariant = 'danger';
                this.costsProjectAlertCountDown = 5;
                this.alertMessage = 'Ошибка';                
                console.log(e);
            })
        },
        countDownChanged (dismissCountDown) {
            this.dismissCountDown = dismissCountDown
        },
        countDownChangedCostsProgectCd (costsProjectAlertCountDown) {
            this.costsProjectAlertCountDown = costsProjectAlertCountDown
        },
        salary() {
            this.staticData.penaltyTime = this.penaltyTime ? this.penaltyTime : 0;
            this.staticData.closeHours = this.closeHours ? this.closeHours : 0;

            Api.getSalaryPersonalSalary(this.personalId, { params: {
                    date: this.date
                }})
            .then(response => {

                if(response.data.success){
                    var data = response.data.data;
                
                    this.changeData.fixSalary = data.fix;
                    this.changeData.coef = data.coefficient;
                    this.staticData.salaryHour = data.salaryHours;
                    this.changeData.closeHours = data.closeHours;
                    this.staticData.salary = data.salary;
                    this.changeData.penaltyTime = data.penaltyHours;

                    this.postData.salaryId = data.id ;
                }
                
                
            })
            .catch(e => console.log(e));
        },
        costsProjectPercent(data){
            for (let item of data) {
                item.percent = (100 / (this.costsProject.sum / item.worktime)).toFixed(2)          
            }  
         },
        costsProjectSalaryPercent(per, obj){
            var persentSalary = ((((this.flagHours ? this.staticData.salary : this.changeData.salary) + this.costsProject.costsMonth.cost) / 100) * per).toFixed(2)
            obj.projectCost = persentSalary;  
            
            return persentSalary
        }      
    },
    created() {
        this.salary();

        Api.getSalaryProjectCosts(this.personalId, {params: {
                date: this.date
            }})
        .then(response => {
            
            this.costsProject.data = response.data.data.reverse();
            this.costsProject.sum = _.sumBy(this.costsProject.data, 'worktime');
            this.costsProject.costProject = response.data.costProject;

            this.costsProjectPercent(this.costsProject.data);  
        })
        .catch(e => console.log(e));


        Api.getSalaryPersonalCosts({params: {
                date: this.date
            }})
        .then(response => {
            this.costsProject.costsMonth = response.data.data
        })
        .catch(e => console.log(e));
    }
 }   
</script>  

<style>

</style>
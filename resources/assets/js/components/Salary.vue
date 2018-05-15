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
                            <input type="text" name="hours" :value="staticData.salaryHour" class="form-control mr-1" placeholder="Стоимость часа" disabled>
                            <input type="text" id="hour" class="form-control" @input="onChangeSalaryHour($event)" v-model="changeData.salaryHour" placeholder="Стоимость часа">
                        </div> 
                    </div> 

                    <div class="form-item form-item_bold">
                        <label for="closeHour">Закрыто часов</label>
                        <div class="flex">
                            <input type="text" name="close_hours" :value="staticData.closeHours" class="form-control mr-1" placeholder="Закрыто часов" disabled>
                            <input type="text" id="closeHour" class="form-control" v-model.number="changeData.closeHours" placeholder="Закрыто часов">
                        </div> 
                    </div>
                </div>

                <div class="form-group flex form-group_w20 ">
                    <div class="form-item form-item_bold mr-5">
                        <label for="fineHours">Штрафных часов</label>
                        <div class="flex">
                            <input type="text" :value="staticData.penaltyTime" class="form-control mr-1" placeholder="Штрафных часов" disabled>
                            <input type="text" class="form-control" v-model="changeData.penaltyTime" placeholder="Штрафных часов" id="fineHours">
                        </div> 
                    </div> 

                    <div class="form-item form-item_bold">
                        <label for="zp">ЗП</label>
                        <div class="flex">
                            <input type="text" :value="staticData.salary" class="form-control mr-1" placeholder="Зарплата" disabled>
                            <input type="text" id="zp" @input="onChangeSalary($event)" v-model="changeData.salary" class="form-control" placeholder="Зарплата">
                        </div> 
                    </div>
                </div>

                <button type = "button" @click="saveSalary()" class = "btn btn-primary w-15">Сохранить</button>
            </div>
        </div>
        <!-- <div class="box">
            <div class="box-header with-border">
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
                        <tr v-for="timeRecord in get.timeRecords" v-if="timeRecord.worktime !== null">
                            <td>{{ timeRecord.name }}</td>
                            <td>{{ timeRecord.worktime }}</td>
                            <td>{{ parseFloat(timeRecord.worktime/get.trackedTime).toFixed(3) * 100 }} %</td>
                            
                                <td v-if = "Number(form.editSalary) !== 0">{{ ((form.editSalary * parseFloat(timeRecord.worktime/get.trackedTime)) + (get.costs * parseFloat(timeRecord.worktime/get.trackedTime))).toFixed(2) }}</td>
                         

                                <td v-else> {{ ((salary * parseFloat(timeRecord.worktime/get.trackedTime)) + (get.costs * parseFloat(timeRecord.worktime/get.trackedTime))).toFixed(2) }}</td>
                           
                            <td><input v-model = "form.editCosts[timeRecord.project_id]" type = "text" class = "form-control"></td>
                        </tr>
                    </tbody>
                </table>
                <br>
                <button v-if = "post.costs === false" type = "button" v-on:click = "costs" class = "btn btn-primary">Списать</button>
            </div>
        </div> -->
    </div>

</template>


<script>
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
        }
    },
    data: () => ({
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
        }
    }),
    methods: {
        onChangeSalaryHour(e){
            this.staticData.salary = e.target.value * ((this.changeData.closeHours || this.staticData.closeHours) - (this.changeData.penaltyTime || this.staticData.penaltyTime))      
        },
        onChangeSalary(e){
            this.staticData.salary = e.target.value;
            
            this.staticData.salaryHour = e.target.value / (this.changeData.closeHours || this.staticData.closeHours)
        },
        saveSalary(){
            var url; 
            
            if (this.postData.salaryId) {
                url = `/api/personal/salary/${this.postData.salaryId}/update`;
            } else {
                url = `/api/personal/${this.personalId}/salary/store`;
            }
          
            axios.post(url, {
                salary: this.changeData.salary || this.staticData.salary,
                coefficient: this.changeData.coef,
                salaryHours: this.changeData.salaryHour || this.staticData.salaryHour,
                closeHours: this.changeData.closeHours || this.staticData.closeHours,
                penaltyHours: this.changeData.penaltyTime || this.staticData.penaltyTime,
                fix: this.changeData.fixSalary
            })
            .then(response => {
                console.log(response);
                
            })
            .catch(e=> {
                console.log(e);
            });
        }
    },
    created() {
        this.staticData.penaltyTime = this.penaltyTime ? this.penaltyTime : 0;        
        
         axios.get('/api/personal/'+this.personalId+'?date='+this.date)
            .then(response => {

                var data = response.data
                
                this.changeData.coef = data.salary ? data.salary.coefficient : 0;
                this.staticData.closeHours = data.first ? Math.trunc(_.sumBy(data.first.times, 'totaltime')) : '';
                this.staticData.salary = data.salary ? data.salary.salary.toFixed(2) : '';
                this.staticData.salaryHour = data.salary ? data.salary.edit_hours.toFixed(2) : '';

                this.postData.salaryId = data.salary ? data.salary.id : '';
            })
            .catch(e => {
                console.log(e);
            })

    }
 }   
</script>  

<style>
/*
    // export default {
    //     props: {
    //         personalId: {
    //             type: Number,
    //             required: true
    //         },
    //         date: {
    //             type: String,
    //             required: true
    //         }
    //     },
    //     data() {
    //         return {
    //             post: {
    //                 validSalary: null,
    //                 costs: false
    //             },

    //             form: {
    //                 fix: null,
    //                 closeHours: null,
    //                 addHours: null,
    //                 estimatedTime: null,
    //                 salary: null,
    //                 posts: null,
    //                 coef: 1.1,
    //                 salaryHours: null,
    //                 editSalary: null,
    //                 costs: null,
    //                 editCosts: []
    //             },

    //             get: {
    //                 info: null,
    //                 salary: null,
    //                 trackedTime: null,
    //                 times: null,
    //                 fullEstimatedTime: 0,
    //                 timeRecords: null,
    //                 costs: null,
    //             }
    //         }
    //     },
    //     created() {
    //         axios.get('/api/personal/'+this.personalId+'?date='+this.date)
    //             .then(response => {
                
    //                 this.get.info = response.data.first;
    //                 this.get.salary = response.data.salary;
    //                 this.get.trackedTime = _.sumBy(this.get.info.times, 'totaltime').toFixed(2);
    //                 this.get.times = this.get.info.times;
    //                 this.get.timeRecords = response.data.timeRecords;
    //                 this.get.costs = response.data.costs.cost;
    //                 this.post.costs = response.data.projectCosts; 

    //                 this.$store.commit('personal/personalInformation', response.data)

    //                 if (this.get.salary !== null) {
    //                     this.validSalary = '/'+this.get.salary.id;
    //                 } else {
    //                     this.validSalary = '';
    //                 }

    //                 if (this.get.salary !== null) {
    //                     this.form.salaryHours = this.get.salary.hour;
    //                     this.form.fix = this.get.salary.salary_fix;
    //                     this.form.coef = this.get.salary.coefficient;
    //                     this.form.salary = this.get.salary.salary;
    //                     this.form.addHours = this.get.salary.edit_hours;
    //                     this.form.editSalary = this.get.salary.edit_salary;
    //                 }
                  
                     
    //             })
    //             .catch(e => {
    //                 console.log(e);
    //             })
    //     },
    //     methods: {
    //         costs : function () {               
    //             for (var timeRecord in this.get.timeRecords) {
    //                 if (this.get.timeRecords[timeRecord]['worktime'] !== null) {
    //                     if (this.get.timeRecords[timeRecord]['project_id'] in this.form.editCosts) {
    //                         var projectCost = this.form.editCosts[this.get.timeRecords[timeRecord]['project_id']];
    //                     } else {
    //                         if (_.get(this.get.salary, 'edit_salary') && this.get.salary.edit_salary !== '0.00') {
    //                             var projectCost = ((this.get.salary.edit_salary * parseFloat(this.get.timeRecords[timeRecord]['worktime']/this.get.trackedTime)) + (this.get.costs * parseFloat(this.get.timeRecords[timeRecord]['worktime']/this.get.trackedTime))).toFixed(2);
    //                         } else {
    //                             var projectCost = ((this.salary * parseFloat(this.get.timeRecords[timeRecord]['worktime']/this.get.trackedTime)) + (this.get.costs * parseFloat(this.get.timeRecords[timeRecord]['worktime']/this.get.trackedTime))).toFixed(2);
    //                         }
    //                     }
                        
    //                     axios.post('/api/personal/'+this.personalId+'/costs/store', {
    //                         projectId: this.get.timeRecords[timeRecord]['project_id'],
    //                         projectCost: projectCost,
    //                         date: this.date,
    //                         workTime: this.get.timeRecords[timeRecord]['worktime']
    //                     })
    //                     .then(response => {
    //                         this.post.costs = true;
    //                         //return console.log(response);
    //                     })
    //                     .catch(function (error) {
    //                         return console.log(error);
    //                     });
    //                 }
    //             }
    //         },
    //         postSalary: function () {
    //             var day = new Date();
               

    //             axios.post('/api/personal/'+this.personalId+'/salary/store'+this.validSalary, {
    //                 salaryFix: this.isSalaryFixed,
    //                 salary: this.salary,
    //                 coef: this.form.coef,
    //                 hour: this.valueHours,
    //                 date: this.date+'-'+day.getDay(),
    //                 editHours: this.form.addHours ,
    //                 editSalary: this.form.editSalary
    //             })
    //             .then(response => {
    //                 this.get.salary = response.data;

    //                 if (this.get.salary !== null) {
    //                     this.validSalary = '/'+this.get.salary.id;
    //                 } else {
    //                     this.validSalary = '';
    //                 }

    //                     this.form.salaryHours = this.get.salary.hour;
    //                     this.form.fix = this.get.salary.salary_fix;
    //                     this.form.coef = this.get.salary.coefficient;
    //                     this.form.salary = this.get.salary.salary;
    //                     this.form.addHours = this.get.salary.edit_hours;
    //                     this.form.editSalary = this.get.salary.edit_salary;
    //             })
    //             .catch(function (error) {
    //                 return console.log(error);
    //             });
    //         }
    //     },
    //     computed: {
    //         isSalaryFixed() {
    //             return this.form.fix;
    //         },
    //         fineHours() {               
    //             for (var task in this.get.times) {                                 
    //                 this.get.fullEstimatedTime += parseFloat(this.get.times[task].tasks.estimated_time);
    //             }
    //         },
    //         salary() {
    //             if (Number(this.form.fix) === 0) { 
                        
    //                 if (isNaN(parseFloat(this.form.addHours))) {
                        
    //                     return (this.closeHours - this.fineHours) * this.form.salaryHours;

    //                 } else {

    //                     return ((parseFloat(this.closeHours) + parseFloat(this.form.addHours)) - this.fineHours) * this.form.salaryHours;
    //                 }

    //             } else {
    //                 return this.form.salary;
    //             } 
    //         },
    //         closeHours() {
    //                 console.log(this.get.trackedTime)
    //                 return this.get.trackedTime;
                
    //         },
    //         valueHours() {
    //             if (this.form.fix !== 0) {
    //                 return this.salary / (this.get.trackedTime - this.fineHours);
    //             }

    //             return this.form.salaryHours;

    //         },
    //         valueHoursWithoutFine() {
    //             if (isNaN(parseFloat(this.form.addHours))) {     
    //                 return parseFloat(this.closeHours) * parseFloat(this.form.salaryHours);
    //             } 

    //             return parseFloat(this.closeHours + this.form.addHours) * parseFloat(this.form.salaryHours);
                
    //         }
    //     }
    // }
    
*/
</style>
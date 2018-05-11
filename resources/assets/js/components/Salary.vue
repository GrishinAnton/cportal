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

                <button type = "button" @click="" class = "btn btn-primary w-15">Сохранить</button>
            </div>
        </div>



        <!-- <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">
                    Зарплата
                </h3>
            </div>
            <div class="box-body">
                <div class="form-group">
                    <div class="form-item form-item_bold">
                        <label for="coef">Коэффициент</label>
                        <input type="text" v-model="form.coef" class="form-control" placeholder="Коэффициент" id="coef">
                    </div>
                </div>

                <div class="form-group">
                    <p>
                        <label for="">Фикс ЗП</label>
                    </p>
                    <button type="button"  class = "btn" v-bind:class="{'btn-success': form.fix}" @click="form.fix = true">Да</button>
                    
                    <button type="button" class = "btn" v-bind:class="{'btn-success': form.fix == false}" @click="form.fix = false">Нет</button> 
                    
                </div>
                <div v-if="isSalaryFixed == false" class = "form-group">
                    <div class="form-group">
                        <div class="form-item form-item_bold">
                            <label for="hour">Стоимость часа</label>
                            <input type="text" id="hour" v-model="form.salaryHours" name="hours" class="form-control" placeholder="Стоимость часа">
                        </div>
                    </div>

                    <div class="form-group">

                        <div class="form-item form-item_bold">
                            <label for="close_hours">Закрыто часов</label>
                            <input type="text" id="close_hours" name = "close_hours" v-bind:value = "closeHours" class="form-control" placeholder="Закрыто часов" disabled>
                        </div>

                        <div class="form-item form-item_bold">
                            <label for="fine_hours">Штраф часов</label>
                            <input type="text" id="fine_hours" v-bind:value = "fineHours" class="form-control" placeholder="Штраф часов" disabled>
                        </div>

                        <div class="form-item form-item_bold">
                            <label for="edit_hours">Вручную часов</label>
                            <input type="text" id="edit_hours" v-model="form.addHours" class="form-control" placeholder="Вручную часов">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-item form-item_bold">
                            <label for="salary">ЗП в ручную</label>
                            <input type="text" id="salary" v-model="form.editSalary" class="form-control" placeholder="ЗП в ручную">
                        </div>

                        <div class="form-item form-item_bold">
                            <label for="salary">ЗП</label>
                            <input type="text" id="salary" v-bind:value="salary" class="form-control" placeholder="ЗП" disabled>
                        </div>

                        <div class="form-item form-item_bold">
                            <label for="hours">Стоимость часа</label>
                            <input type="text" id="hours" v-model="form.salaryHours" name="hours" class="form-control" placeholder="Стоимость часа" disabled>
                        </div>

                        <div class="form-item form-item_bold">
                            <label for="hours">Стоимость часа без учета штрафа</label>
                            <input type="text" id="hours" v-bind:value = "valueHoursWithoutFine" name = "hours" class="form-control" placeholder="Стоимость часа без учета шрафа" disabled>
                        </div>
                    </div>

                    <button type = "button" v-on:click = "postSalary" class = "btn btn-primary">Сохранить</button>
                
                </div>

                <div v-if="isSalaryFixed" class="form-group">

                    <div class="form-item form-item_bold">
                        <label for="salary">ЗП</label>
                        <input type="text" v-model="form.salary" class="form-control" placeholder="ЗП">
                    </div>

                    <div class="form-item form-item_bold">
                        <label for="close_hours">Закрыто часов</label>
                        <input type="text"  v-bind:value = "closeHours" class="form-control" placeholder="Закрыто часов" disabled>
                    </div>

                    <div class="form-item form-item_bold">
                        <label for="fine_hours">Штраф часов</label>
                        <input type="text"  v-bind:value = "fineHours" class="form-control" placeholder="Штраф часов" disabled>
                    </div>

                    <div class="form-item form-item_bold">
                        <label for="edit_hours">Вручную часов</label>
                        <input type="text" v-model="form.addHours" class="form-control" placeholder="Вручную часов">
                    </div>
                </div>

                <div class="form-group">

                    <div class="form-item form-item_bold">
                        <label for="salary">ЗП в ручную</label>
                        <input type="text" v-model = "form.editSalary" class="form-control" placeholder="ЗП в ручную">
                    </div>

                    <div class="form-item form-item_bold">
                        <label for="salary">ЗП</label>
                        <input type="text" v-bind:value = "salary" class="form-control" placeholder="ЗП" disabled>
                    </div>

                    <div class="form-item form-item_bold">
                        <label for="hours">Стоимость часа</label>
                        <input type="text" v-bind:value = "valueHours" class="form-control" placeholder="Стоимость часа" disabled>
                    </div>
                </div>

                <button type = "button" v-on:click = "postSalary" class = "btn btn-primary">Сохранить</button>
            </div>
        </div> -->
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
        }
    },
    data: () => ({
        changeData: {
            fixSalary: '',
            coef: '',
            salaryHour: 0,
            closeHours: 0,
            penaltyTime: 0,
            salary: 0
        },
        staticData: {
            salaryHour: 0,
            closeHours: 150,
            penaltyTime: 10,
            salary: 0
        }
    }),
    methods: {
        onChangeSalaryHour(e){           
            this.staticData.salary = e.target.value * ((this.changeData.closeHours || this.staticData.closeHours) - this.staticData.penaltyTime)            
        },
        onChangeSalary(e){
            this.staticData.salary = e.target.value
            
            this.staticData.salaryHour = e.target.value / (this.changeData.closeHours || this.staticData.closeHours)
        }
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
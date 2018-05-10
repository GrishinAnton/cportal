<template>
    <div class="box">
        <div class="box-header flex flex_jc-sb">
            <h3 class="box-title">Отчет</h3>
            <div class="col-sm-1">
                <select class="form-control" v-model="year" @change="renderTableByYaer">
                    <option value="2017">2017</option>
                    <option value="2018">2018</option>
                </select>
            </div>
        </div>
        <div class="box-body">
            <template v-if="! success"><h3>Упс, что - то сломалось :(</h3></template>
            <table class="table table-hover table-bordered">
                <thead>
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>Имя Фамилия</th>
                        <th class="text-center">Январь</th>
                        <th class="text-center">Февраль</th>
                        <th class="text-center">Март</th>
                        <th class="text-center">Апрель</th>
                        <th class="text-center">Май</th>
                        <th class="text-center">Июнь</th>
                        <th class="text-center">Июль</th>
                        <th class="text-center">Август</th>
                        <th class="text-center">Сентябрь</th>
                        <th class="text-center">Октябрь</th>
                        <th class="text-center">Ноябрь</th>
                        <th class="text-center">Декабрь</th>
                    </tr>
                </thead>
                <tbody v-for="personal in personals" :key="personal.id">
                    <tr>
                        <td>{{ personal.id }}</td>
                        <td v-b-toggle="personal.id">{{ personal.first_name }} {{ personal.last_name }}</td>
                        <td @click="openmodal()"></td>
                        <td @click="salaries(personal.id, 2)"></td>
                        <td @click="salaries(personal.id, 3)"></td>
                        <td @click="salaries(personal.id, 4)"></td>
                        <td @click="salaries(personal.id, 5)"></td>
                        <td @click="salaries(personal.id, 6)"></td>
                        <td @click="salaries(personal.id, 7)"></td>
                        <td @click="salaries(personal.id, 8)"></td>
                        <td @click="salaries(personal.id, 9)"></td>
                        <td @click="salaries(personal.id, 10)"></td>
                        <td @click="salaries(personal.id, 11)"></td>
                        <td @click="salaries(personal.id, 12)"></td>
                    </tr>
                    <b-collapse :id="personal.id" tag="tr">
                        <td></td>
                        <td class="text-right">проект</td>
                        <td>data 1</td>  
                        <td>data 1</td>
                    </b-collapse>
                    <!-- <tr :id="personal.id" class="collapse">
                        <td></td>
                        <td class="text-right">проект</td>
                        <td>data 1</td>  
                        <td>data 1</td>
                    </tr> -->
                </tbody>
            </table>    
            <b-modal ref="modal" title="Фиксированная зарплата">
                <input type="text" class="form-control">
                <div slot="modal-footer" class="w-100 d-flex justify-content-between">
                    <button type="button" class="btn btn-default pull-left" @click="closeModal()">Закрыть</button>
                    <button type="button" class="btn btn-primary">Сохранить</button>
                </div>
            </b-modal>  
        </div>             
    </div>
</template>
<script>
    export default {
        data() {
            return {
                personals: {},
                success: true,
                year: 2018,
                salary: null,
            }
        },
        methods: {
            openmodal(){
                this.$refs.modal.show()
            },
            closeModal(){
                this.$refs.modal.hide()
            },
            salaries(persId, month) {
                axios.get('/api/report/personal/'+persId+'/salaries/'+this.year+'/'+month)
                    .then(response => {
                        this.salary = response.data.data;
                    })
                    .catch();

                if (! this.salary) {
                    // this.modal(true);
                }
            },
            renderTableByYaer() {
                axios.get('/api/report/worktime/'+this.year)
                    .then(response => {
                        console.log(response);
                    })
                    .catch();
            }
        },
        mounted() {
            axios.get('/api/report/personal/all')
                .then(response => {
                    if (response.data.success) {
                        this.personals = response.data.data;
                        console.log(this.personals);
                        

                        return;
                    }

                    this.success = true;
                })
                .catch(errors => {
                    this.success = true;
                });
        }
    }
</script>

<style>
    .collapsing {
        transition: none;
        display: table-row;
    }
</style>



<template>
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Отчет</h3>
            <div class="pull-right">
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
                        <td class="clickable" data-toggle="collapse" :data-target="'#' + personal.id" aria-expanded="false" aria-controls="group-of-rows-1">{{ personal.first_name }} {{ personal.last_name }}</td>
                        <td @click="salaries(personal.id, 1)"></td>
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
                    <tr :id="personal.id" class="collapse">
                        <td></td>
                        <td class="text-right">проект</td>
                        <td>data 1</td>  
                        <td>data 1</td>
                    </tr>
                </tbody>
            </table>
            <div class="modal fade in" id="modal-default" v-if="modalOpen" style="display: block; padding-right: 15px;">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" @click="modal(false)" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                        <h4 class="modal-title">Фиксированная зарплата</h4>
                    </div>
                    <div class="modal-body">
                        <input type="text" class="form-control">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" @click="modal(false)" data-dismiss="modal">Закрыть</button>
                        <button type="button" class="btn btn-primary">Сохранить</button>
                    </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                personals: {},
                success: true,
                modalOpen: false,
                year: 2018,
                salary: null
            }
        },
        methods: {
            salaries(persId, month) {
                axios.get('/api/report/personal/'+persId+'/salaries/'+this.year+'/'+month)
                    .then(response => {
                        this.salary = response.data.data;
                    })
                    .catch();

                if (! this.salary) {
                    this.modal(true);
                }
            },
            modal(close){
                this.modalOpen = close
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
    tbody.collapse.in {
    display: table-row-group;
    }
</style>



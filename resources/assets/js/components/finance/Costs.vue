<template>
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Издержки</h3>
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
                        <th style="width: 10px">2018</th>
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
                <tbody>
                     <tr>
                        <td>Издержки</td>
                        <td class="text-center" @click="modal()">
                            <span>0</span>
                            <i class="fa fa-pencil"></i>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="modal fade in" id="modal-default" v-if="modalOpen" style="display: block; padding-right: 15px;">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" @click="modal()" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                        <h4 class="modal-title">Издержки</h4>
                    </div>
                    <div class="modal-body">
                        <input type="text" class="form-control"
                            v-model="input.cost"
                        >
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" @click="modal()" data-dismiss="modal">Закрыть</button>
                        <button type="button" class="btn btn-primary" @click="submit()">Сохранить</button>
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
        data: () => ({
            costs: [],
            input: {
                cost: 0
            },
            modalOpen: false,
            year: 2018,
            success: true
        }),
        methods: {
            modal(){
                this.modalOpen = !this.modalOpen
            },
            // salaries(persId, month) {
            //     axios.get('/api/report/personal/'+persId+'/salaries/'+this.year+'/'+month)
            //         .then(response => {
            //             this.salary = response.data.data;
            //         })
            //         .catch();

            //     if (! this.salary) {
            //         this.modal(true);
            //     }
            // },            
            renderTableByYaer() {
                axios.get('/api/report/worktime/'+this.year)
                    .then(response => {
                        console.log(response);
                    })
                    .catch();
            },
            submit() {

                var data = this.input.cost;
                var url = '';
                axios.post(url, data)
                    .then(response => {
                        console.log(response.data)
                    })
                    .catch(errors => {
                    console.log(errors)
                });
            }
        },
        mounted() {
            var url = '';
            axios.get(url)
            .then(response => {
                console.log(response.data)
            })
            .catch(errors => {
                console.log(errors)
            })
            // axios.get('/api/report/personal/all')
            //     .then(response => {
            //         if (response.data.success) {
            //             this.personals = response.data.data;
            //             console.log(this.personals);
                        

            //             return;
            //         }

            //         this.success = true;
            //     })
            //     .catch(errors => {
            //         this.success = true;
            //     });
        }
    }
</script>

<style>

</style>



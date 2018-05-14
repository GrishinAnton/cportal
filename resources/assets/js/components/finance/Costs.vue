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
                        <td class="text-center" @click="openmodal()">
                            <span>0</span>
                            <i class="fa fa-pencil"></i>
                        </td>
                    </tr>
                </tbody>
            </table>
            <b-modal ref="modal" title="Издержки">
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
        data: () => ({
            costs: [],
            input: {
                cost: 0
            },
            modalOpen: false,
            year: 2018,
            success: true, 
        }),
        methods: {
            openmodal(){
                this.$refs.modal.show()
            },
            closeModal(){
                this.$refs.modal.hide()
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
            // var url = '';
            // axios.get(url)
            // .then(response => {
            //     console.log(response.data)
            // })
            // .catch(errors => {
            //     console.log(errors)
            // })
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



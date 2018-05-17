<template>
    <div class="box">
        <div class="box-header flex flex_jc-sb">
            <h3 class="box-title">Издержки</h3>
            <div class="col-1 flex flex_jc-fe">
                <select class="form-control" v-model="date" @change="renderTableByYaer">
                    <option value="2017">2017</option>
                    <option value="2018">2018</option>
                </select>
            </div>
        </div>
        <div class="box-body">
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
                        <td class="text-center" @click="openModal()">
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
        props: {
            date: {
                type: String
            }
        },
        data: () => ({
            costs: [],
            input: {
                cost: 0
            },
            modalOpen: false,
        }),
        methods: {
            openModal(){
                this.$refs.modal.show()
            },
            closeModal(){
                this.$refs.modal.hide()
            },          
            renderTableByYaer() {
                axios.get('/api/report/worktime/'+this.year)
                    .then(response => {
                        console.log(response);
                    })
                    .catch();
            },
            // submit() {

            //     var data = this.input.cost;
            //     var url = '';
            //     axios.post(url, data)
            //         .then(response => {
            //             console.log(response.data)
            //         })
            //         .catch(errors => {
            //         console.log(errors)
            //     });
            // }
        },
        mounted() {

            axios.get(`/api/report/costs`, {
                params: {
                    date: this.date
                }
            })
            .then(response => {
                console.log(response)
            })
            .catch(errors => {
                console.log(errors)
            });

        }
    }
</script>

<style>

</style>



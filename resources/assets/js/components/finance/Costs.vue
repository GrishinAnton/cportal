<template>
    <div class="box">
        <div class="box-header flex flex_jc-sb">
            <h3 class="box-title">Издержки</h3>
            <div class="col-1 flex flex_jc-fe">
                <select class="form-control" v-model="currentYear" @change="renderTableByYaer">
                    <option value="2017">2017</option>
                    <option value="2018">2018</option>
                </select>
            </div>
        </div>
        <div class="box-body">
            <table class="table table-hover table-bordered">
                <thead>
                    <tr>
                        <th style="width: 10px">{{ currentYear }}</th>
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
                        <td v-for="n in costsOverride.data.length" :key="n.month" class="text-center" @click="openModal(n)">
                            <template>
                                <span>{{ n.cost || 0 }}</span> 
                                <i class="fa fa-pencil"></i>
                            </template>
                            <template>
                                <span>-</span> 
                            </template>
                        </td>
                    </tr>
                </tbody>
            </table>
            <b-modal ref="modal" title="Издержки">
                <input ref="modalInput" type="text" class="form-control">
                <div slot="modal-footer" class="w-100 d-flex justify-content-between">
                    <button type="button" class="btn btn-default pull-left" @click="closeModal()">Закрыть</button>
                    <button type="button" class="btn btn-primary" @click="saveModal($event)">Сохранить</button>
                </div>
            </b-modal>  
        </div>
    </div>
</template>
<script>
    export default {
        data: () => ({
            currentYear: new Date().getFullYear(),
            currentMonth: new Date().getMonth()+1,
            costsOverride: {
                data: [],
            },        
            currentObj: '',    
        }),
        methods: {
            openModal(obj){     
                this.currentObj = obj         
                this.$refs.modalInput.value = obj.cost
                this.$refs.modal.show()
            },
            closeModal(){
                this.$refs.modal.hide()
            },    
            saveModal(evt){
                evt.preventDefault()

                if (!this.$refs.modalInput.value) {
                    alert('А сумму?')
                } else {
                    this.currentObj.cost = this.$refs.modalInput.value
                    this.saveCost()
                    this.closeModal()
                }
                             
            },   
            renderTableByYaer(e) {
                var monthFormat = (`0${this.currentMonth}`).slice(-2);

                axios.get(`/api/report/costs`, {
                    params: {
                        date: `${e.target.value}-${monthFormat}`
                    }
                })
                .then(response => {
                    console.log(response)
                    this.currentYear = e.target.value
                })
                .catch(errors => {
                    console.log(errors)
                });
            },
            saveCost(){
                console.log(this.costsOverride);
                
            },
            createCostData(response){
                console.log(response);

                // var arr = [];

                // for(let i = 1; i <= 12; i++  ){
                    
                //     if(){

                //     }
                    
                // }
                
            }
        },
        mounted() {

            var monthFormat = (`0${this.currentMonth}`).slice(-2);

            axios.get(`/api/report/costs`, {
                params: {
                    date: `${this.currentYear}-${monthFormat}`
                }
            })
            .then(response => {
                this.createCostData(response.data.data)
            })
            .catch(errors => {
                console.log(errors)
            });

        }
    }
</script>

<style>

</style>



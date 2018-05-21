<template>
    <div class="box">
        <div class="box-header flex flex_jc-sb">
            <h3 class="box-title">Издержки</h3>
            <div class="col-1 flex flex_jc-fe">
                <select class="form-control" v-model="renderYear" @change="renderTableByYaer">
                    <option value="2017">2017</option>
                    <option value="2018">2018</option>
                </select>
            </div>
        </div>
        <div class="box-body">
            <table class="table table-hover table-bordered">
                <thead>
                    <tr>
                        <th style="width: 10px">{{ renderYear }}</th>
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
                        <td v-for="n in costsOverride.data" :key="n.month" class="text-center" @click="openModal(n)">
                            <template>
                                <span>{{ n.cost || 0 }}</span> 
                                <i v-if="n.cost != '-'" class="fa fa-pencil"></i>
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
            renderYear: new Date().getFullYear(),
            costsOverride: {
                data: [],
            },        
            currentObj: '',    
        }),
        methods: {
            openModal(obj){                
                if(obj.cost == '-'){
                    return false
                }
                
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
                    this.costsOverride.data =  this.createCostData(response.data.data); 
                })
                .catch(errors => {
                    console.log(errors)
                });
            },
            saveCost(){

                var url;
                this.currentObj.id !== undefined ? url = `/api/report/costs/${this.currentObj.id}` : url = `/api/report/costs`;               
                this.currentObj.date = `${this.renderYear}-${this.currentObj.month}-07`

                axios.post(url, this.currentObj)
                .then(response => {
                    console.log(response);
                    
                })
                .catch(e => {
                    console.log(e);
                    
                })
                
            },
            createCostData(response){

                var arr = [];

                for (var i = 1; i <= 12; i++) {
                    var month = (`0${i}`).slice(-2);
                    var obj = {month: month, cost: 0}
                   

                    if (this.renderYear < this.currentYear) {
                        arr.push(obj)                        
                    } else if (i <= this.currentMonth) {
                        arr.push(obj)
                    } else {
                        obj.cost = '-'
                        arr.push(obj)
                    } 
                }

                for (var k = 0; k <= response.length; k++) {  
                    for (var t in response[k]) {
                        arr[response[k]['month'].replace('0', '') -1] = response[k]   
                    }                        
                }

                return arr;
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
                this.costsOverride.data =  this.createCostData(response.data.data);   
            })
            .catch(errors => {
                console.log(errors)
            });

        }
    }
</script>

<style>

</style>



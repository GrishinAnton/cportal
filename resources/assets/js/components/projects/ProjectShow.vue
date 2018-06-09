<template>
    <div>
        <div class="box">
            <div class="box-header flex flex_jc-sb">
                <h3 class="box-title">
                    Сайт собак
                </h3>
            </div>
            <div class="box-body box-body_personal-select-group flex flex_jc-fs">
                <div class="form-item form-item_bold mr-3">
                    <label for="start">Старт</label>
                    <input type="text" placeholder="Старт" id="start" class="form-control">
                </div>  
                <div class="form-item form-item_bold mr-3">
                    <label for="finish">Финиш</label>
                    <input type="text" placeholder="Финиш" id="finish" class="form-control">
                </div>
                <div class="form-item form-item_bold mr-3">
                    <label for="status">Статус</label>
                    <select id="status" class="form-control">
                        <option selected>пиар</option>
                        <option>кейс</option>
                        <option>готов</option>
                        <option>в работе</option>
                        <option>старт</option>
                    </select>
                </div>
                <div class="form-item form-item_bold">
                    <label for="company">Компания</label>
                    <select id="company" class="form-control">
                        <option selected>2UP</option>
                        <option>PRO</option>
                    </select>
                </div>
            </div>
            <div class="box-body box-body_personal-select-group flex flex_jc-fs">
                <table class="table table-striped table-hover w-25">
                    <tbody>
                        <tr>
                            <th>Часов потрачено</th>
                            <td @click="openmodal('modalHour')">{{ allHoursSumm }}</td>
                        </tr>
                        <tr>
                            <th>Часов заложено</th>
                            <td>200</td>
                        </tr>
                        <tr>
                            <th>Стоимость часа</th>
                            <td>1350</td>
                        </tr>

                    </tbody>
                </table>
            </div>
            <div class="box-body box-body_personal-select-group flex flex_jc-fs">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Бюджет</th>
                            <th>Затраты</th>
                            <th>Остаток</th>
                            <th>Средний расход в неделю</th>
                            <th>Осталось недель</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>100 000,00 ₽</td>
                            <td>40 000,00 ₽</td>
                            <td>60 000,00 ₽</td>
                            <td>60 000,00 ₽</td>
                            <td>4</td>
                        </tr>

                    </tbody>
                </table>
            </div>       
            
            <div class="box-body box-body_personal-select-group">
                <div class="box-header flex flex_jc-sb">
                    <h3 class="box-title">
                        Списания
                    </h3>
                </div>
                <table class="table table-striped table-hover w-25">
                    <tbody>
                        <tr>
                            <th>ФОТ:</th>
                            <td @click="openmodal('modalFot')">{{ allForSumm }}</td>
                        </tr>
                        <tr>
                            <th>Издержки:</th>
                            <td>0</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <b-modal ref="modalHour" title="Потрачено" size="lg">
            <table class="table table-striped table-hover">
                <th v-for="item in tableHeader" :key="item">{{ item }}</th>
                <tr v-for="items in tableHoursData" :key="`${items.info.first_name}${items.info.last_name}`">
                    <td>{{ items.info.id }}</td>
                    <td>{{ items.info.first_name }} {{ items.info.last_name }}</td>
                    <td v-for="(mounth, index) in items.times" :class="tableColor(mounth)" :key="index">{{ mounth ? mounth : '' }}</td>
                </tr>
            </table>
            <div slot="modal-footer" class="w-100 d-flex justify-content-start">
                <button type="button" class="btn btn-default pull-left" @click="closeModal('modalHour')">Закрыть</button>
            </div>
        </b-modal>

        <b-modal ref="modalFot" title="Потрачено" size="lg">
            <table class="table table-striped table-hover">
                <th v-for="item in tableHeader" :key="item">{{ item }}</th>
                <tr v-for="items in tableFotData" :key="`${items.first_name}${items.last_name}`">
                    <td>{{ items.pers_id }}</td>
                    <td>{{ items.first_name }} {{ items.last_name }}</td>
                    <td v-for="(mounth, index) in items.salaries" :key="index">{{ mounth ? mounth.toFixed(0) : '' }}</td>
                </tr>
            </table>
            <div slot="modal-footer" class="w-100 d-flex justify-content-start">
                <button type="button" class="btn btn-default pull-left" @click="closeModal('modalFot')">Закрыть</button>
            </div>
        </b-modal>
    </div> 
    
</template>

<script>
    export default {
        props: {
            projectId: String
        },
        data: () => ({
            tableHoursData: '',
            tableFotData: '',
            tableHeader: '',
            allHoursSumm: '',
            allForSumm: ''

        }),
          methods: {
            openmodal(e){ 
                this.$refs[e].show();
            },
            closeModal(e){
                this.$refs[e].hide();
            }, 
            allHours(){
                
                this.allHoursSumm = _.sumBy(this.tableHoursData, function(o) {
                    var summ = 0;

                    for(let item of o.times){
                        summ+= Number(item.split(' ')[0]);
                    } 
                    return summ;
                }).toFixed(2);        
            },
            allFot(){

                this.allForSumm = _.sumBy(this.tableFotData, function(o) {           
                    var summ = 0;

                    for(let item in o.salaries){
                        summ+= o.salaries[item];
                    } 
                    return summ;
                }).toFixed(0);
                  
            },
            tableColor(str){
                var number = Number(str.split(' ')[1].slice(1, -2));
                
                if(number >= 70){
                    return 'table-success';
                }

                if(number >= 30 && number < 70){
                    return 'table-warning';
                }        
            }
        },
        mounted() {          
            axios.get(`/api/report/projects/${this.projectId}/hours-spent`)
                .then(response => {
                    this.tableHoursData = response.data.data;
                    this.tableHeader = response.data.header;

                    this.allHours();
                    
                })
                .catch(e=>console.log(e))

            axios.get(`/api/report/projects/${this.projectId}/fot`)
                .then(response => {
                    this.tableFotData = response.data.data;
                    this.tableHeader = response.data.header;    

                    this.allFot()           
                })
                .catch(e=>console.log(e))

            
        }
    }
</script>

<style>
    .modal-open .modal {
        overflow-x: auto;
    }
</style>

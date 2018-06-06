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
                            <td @click="openmodal()">{{ allHoursSumm }}</td>
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
                            <td>50000</td>
                        </tr>
                        <tr>
                            <th>Издержки:</th>
                            <td>0</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <b-modal ref="modal" title="Потрачено" size="lg">
            <table class="table table-striped table-hover">
                <th v-for="item in tableHeader" :key="item">{{ item }}</th>
                <tr v-for="items in tableData" :key="`${items.info.first_name}${items.info.last_name}`">
                    <td>{{ items.info.id }}</td>
                    <td>{{ items.info.first_name }} {{ items.info.last_name }}</td>
                    <td v-for="(mounth, index) in items.times" :key="index">{{ mounth ? mounth : '' }}</td>
                </tr>
            </table>
            <div slot="modal-footer" class="w-100 d-flex justify-content-start">
                <button type="button" class="btn btn-default pull-left" @click="closeModal()">Закрыть</button>
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
            tableData: '',
            tableHeader: '',
            allHoursSumm: ''

        }),
        methods: {
            openmodal(){
                this.$refs.modal.show()
            },
            closeModal(){
                this.$refs.modal.hide()
            }, 
            allHours(){
                this.allHoursSumm = _.sumBy(this.tableData, function(o) {
                    var summ = 0
                    for(let item of o.times){
                        summ+= +item.split(' ')[0]
                    } 
                    return summ
                });        
            }
        },
        mounted() {          
            axios.get(`/api/report/projects/${this.projectId}/hours-spent`)
                .then(response => {
                    this.tableData = response.data.data;
                    this.tableHeader = response.data.header 

                    this.allHours()                 
                    
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

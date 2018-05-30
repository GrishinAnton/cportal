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
                            <td @click="openmodal()">100</td>
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
            <b-table striped hover :items="items" :fields="fields"></b-table>
            <div slot="modal-footer" class="w-100 d-flex justify-content-end">
                <button type="button" class="btn btn-default pull-left" @click="closeModal()">Закрыть</button>
                <!-- <button type="button" class="btn btn-primary">Сохранить</button> -->
            </div>
        </b-modal>
    </div> 
    
</template>

<script>
    export default {
        data: () => ({
            fields: {
                index: {label: '#'},
                jan: {label: 'Январь'},
                feb: {label: 'Февраль'},
                mar: {label: 'Март'},
                apr: {label: 'Апрель'},
                jun: {label: 'Июнь'},
                jul: {label: 'Июль'},
                aug: {label: 'Август'},
                sep: {label: 'Сентябрь'},
                nov: {label: 'Ноябрь'},
                oct: {label: 'Октябрь'},
                dec: {label: 'Декабрь'},
            },
            items: [
                { index: 'Петров', jan: '10 (50%)', feb: '10 (50%)' },
                { index: 'Иванов', jan: '10 (50%)', feb: '10 (50%)' },
            ]
        }),
        methods: {
            openmodal(){
                this.$refs.modal.show()
            },
            closeModal(){
                this.$refs.modal.hide()
            }, 
        }
    }
</script>

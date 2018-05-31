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
        <div class="box-header">

            <personal-filter-buttons @filterButtonChange="onChange" :activeGroups="activeGroups" :activeCompanies="activeCompanies"></personal-filter-buttons>

        </div>
        <div class="box-body">
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
                <tbody v-for="(personal, index) in personalInformation" :key="index">
                    <tr>
                        <td>{{ ++index }}</td>
                        <td>
                            <a :href="personal.url" target="_blank">{{ personal.first_name }} {{ personal.last_name }}</a>
                        </td>
                        <td @click="openmodal()"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr :id="personal.email" >
                        <td></td>
                        <td class="text-right">проект</td>
                        <td>data 1</td>  
                        <td>data 1</td>
                    </tr>
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

        <div class="box-footer">
            <b-pagination align="right" 
                v-show="showPagination" 
                :total-rows="paginationData.total"
                v-model="paginationData.currentPage" 
                @change="onPaginationChange($event)" 
                :per-page="paginationData.perPage"
                >
            </b-pagination>
        </div>

    </div>
</template>
<script>
    import { personalMixin } from '../../../mixins/personalMixin';
    import { paginationMixin } from '../../../mixins/paginationMixin';
    import { personalFilter } from '../../../mixins/personalFilter';

    import PersonalFilterButtons from './../../parts/PersonalFilterButtons'

    export default {
        mixins: [paginationMixin, personalFilter],
        components: {
            PersonalFilterButtons
        },
        data: () =>({
            personalInformation: [],
            year: 2018,
        }),
        methods: {
            openmodal(){
                this.$refs.modal.show()
            },
            closeModal(){
                this.$refs.modal.hide()
            }
        },
        mounted() {
            axios.get('/api/report/summary')
                .then(response => {
                    if (response.data.success) {
                        this.personals = response.data.data;
                        console.log(this.personals);
                    }
                })
                .catch(e => {
                    console.log(e);

                });
        }
    }
</script>

<style>

    .collapsing {
        transition: none;
        display: table-row!important;
    }

</style>



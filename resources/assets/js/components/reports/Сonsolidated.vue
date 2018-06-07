<template>
    <div class="box">
        <div class="box-header flex flex_jc-sb">
            <h3 class="box-title">Отчет</h3>
            <div class="col-sm-1">
                <!-- <select class="form-control" v-model="year" @change="renderTableByYaer">
                    <option value="2017">2017</option>
                    <option value="2018">2018</option>
                </select> -->
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
                <tr class="text-center">
                    <td>{{ ++index }}</td>
                    <td class="text-left">
                        <a :href="personal.url" target="_blank">{{ personal.first_name }} {{ personal.last_name }}</a>
                    </td>
                    <td @click="profileUser(personal.url, '01')">{{ personal.salary.january }}</td>
                    <td @click="profileUser(personal.url, '02')">{{  personal.salary.february }}</td>
                    <td @click="profileUser(personal.url, '03')">{{  personal.salary.march }}</td>
                    <td @click="profileUser(personal.url, '04')">{{  personal.salary.april }}</td>
                    <td @click="profileUser(personal.url, '05')">{{  personal.salary.may }}</td>
                    <td @click="profileUser(personal.url, '06')">{{  personal.salary.june }}</td>
                    <td @click="profileUser(personal.url, '07')">{{  personal.salary.july }}</td>
                    <td @click="profileUser(personal.url, '08')">{{  personal.salary.august }}</td>
                    <td @click="profileUser(personal.url, '09')">{{  personal.salary.september }}</td>
                    <td @click="profileUser(personal.url, '10')">{{  personal.salary.october }}</td>
                    <td @click="profileUser(personal.url, '11')">{{  personal.salary.november }}</td>
                    <td @click="profileUser(personal.url, '12')">{{  personal.salary.december }}</td>
                </tr>
                <!-- <tr :id="personal.email" >
                    <td></td>
                    <td class="text-right">проект</td>
                    <td>data 1</td>
                    <td>data 1</td>
                </tr> -->
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

    import { paginationMixin } from '../../mixins/paginationMixin';
    import { personalFilter } from '../../mixins/personalFilter';

    import PersonalFilterButtons from './../parts/PersonalFilterButtons'

    export default {
        mixins: [paginationMixin, personalFilter],
        components: {
            PersonalFilterButtons
        },
        data: () =>({
            personalInformation: [],
            year: 2018,
            requestUrl: '/api/report/summary'
        }),
        methods: {
            openmodal(){
                this.$refs.modal.show()
            },
            closeModal(){
                this.$refs.modal.hide()
            },
            profileUser(url, month) {
                let date = new Date();

                return window.location.href = url + '?date=' + date.getFullYear() + '-' + month;
            }
        }
    }
</script>

<style>

    /* .collapsing {
        transition: none;
        display: table-row!important;
    } */

</style>



<template>
    <div class="box">

        <div class="box-header">
            <h3 class="box-title">Список проектов</h3>
        </div>

        <div class="box-header">
            <personal-filter-buttons @filterButtonChange="onChange" :activeCompanies="activeCompanies" :activeStatus="activeStatus"></personal-filter-buttons>
        </div>

        <div class="box-body">
            <table class="table table-striped table-hover">
                <tbody>
                    <tr>
                        <th>#</th>
                        <th>Название</th>
                        <th>Бюджет</th>
                        <th>Компания</th>
                        <th>Статус</th>
                    </tr>
                    <tr v-for="item in personalInformation" :key="item.id">
                        <td>{{ item.id }}</td>
                        <td><a :href="item.url">{{ item.name }}</a></td>
                        <td>{{ item.budget }}</td>
                        <td>{{ item.company }}</td>
                        <td>{{ item.status }}</td>
                    </tr>
                </tbody>
            </table>
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
    import { paginationMixin } from './../../mixins/paginationMixin';
    import { personalFilter } from './../../mixins/personalFilter';
    import PersonalFilterButtons from './../parts/PersonalFilterButtons';

    export default {
        mixins: [paginationMixin, personalFilter],
        components: {
            PersonalFilterButtons
        },
        data: () => ({
            personalInformation: [],
            requestUrl: `/api/report/projects`
        }),
        methods: {

        },
        mounted() {

        }
    }
</script>

<template>
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Список сотрудников</h3>
        </div>
        <div class="box-header">
            <div class="flex flex_jc-fs mr-2">
                <template v-for="variant in ['outline-success']">
                    <div class="pb-2 pr-2" v-for="item in load.companies" :key="item.id">
                        <b-button :size="'sm'" :variant="variant">
                            {{ item.name }}
                        </b-button>
                    </div>
                </template>
            </div>

            <div class="flex flex_jc-fs mr-2">
                <template v-for="variant in ['outline-success']">
                    <div class="pb-2 pr-2" v-for="item in load.groups" :key="item.id">
                        <b-button :size="'sm'" :variant="variant">
                            {{ item.name }}
                        </b-button>
                    </div>
                </template>
            </div>
        </div>
        

        <div class="box-body">
            <table class="table table-hover table-bordered">
                <tbody>
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>Имя Фамилия</th>
                        <th>E-mail</th>
                        <th>Коэффициент</th>
                        <th>Закрыто часов</th>
                        <th>Штрафы</th>
                        <th>ЗП</th>
                    </tr>
                    <tr>
                        <td></td>
                        <td><a href = "/"></a></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>0</td>
                       </tr>
                </tbody>
            </table>
        </div>

        <div class="box-footer">
           <!-- pagination -->
        </div>
    </div>
</template>

<script>
    import { personalMixin } from './../../mixins/personalMixin'

    export default {
        mixins: [personalMixin],
        data: ()=> ({

        })
    }
</script>


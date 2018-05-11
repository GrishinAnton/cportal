<template>
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Список сотрудников</h3>
        </div>
        <div class="box-header">
            <div class="flex flex_jc-fs mr-2">
                <div class="pb-2 pr-2" v-for="item in load.companies" :key="item.id">
                    <b-button :size="'sm'" :variant="'outline-success'">
                        {{ item.name }}
                    </b-button>
                </div>
            </div>

            <div class="flex flex_jc-fs mr-2">
                <div class="pb-2 pr-2" v-for="item in load.groups" :key="item.id">
                    <b-button :size="'sm'" :variant="'outline-success'">
                        {{ item.name }}
                    </b-button>
                </div>
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
                    <tr v-for="item in personalInformation" :key="item.id">
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
            personalInformation: []
        }),
        mounted(){
            axios.get('/api/personal')
            .then(response => {
                this.personalInformation = response.data.data
                console.log(this.personalInformation);
                
            })
            .catch(e => {
                console.log(e)
            })
        }
    }
</script>


<template>
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Список сотрудников</h3>
        </div>

        <div class="flex flex_jc-fs mr-2">
            <template v-for="variant in ['outline-success']">
                <div class="col-md-2 pb-2" v-for="size in ['sm']" :key="`${variant}_${size}`">
                    <b-button :size="size" :variant="variant">
                        {{variant}} {{size}}
                    </b-button>
                </div>
            </template>
        </div>
        <div class="flex flex_jc-fs mr-2">
            <template v-for="variant in ['outline-success']">
                <div class="col-md-2 pb-2" v-for="size in ['sm']" :key="`${variant}_${size}`">
                    <b-button :size="size" :variant="variant">
                        {{variant}} {{size}}
                    </b-button>
                </div>
            </template>
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
                        <th></th>
                    </tr>
                    <tr>
                        <td></td>
                        <td><a href = "/"></a></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>0</td>
                        <td>
                            <div class = "text-center">
                                <a href = "/"><i class="fa fa-user-o"></i></a>
                            </div>
                        </td>
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
    export default {
        data: ()=> ({

        })
    }
</script>


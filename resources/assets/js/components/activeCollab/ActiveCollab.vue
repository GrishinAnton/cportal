<template>
    <div>
        <div class="box-body">
            <a @click.prevent="loadActiveCollab(item.url)" class="btn btn-primary mr-2" v-for="(item, index) in buttons" :key="index">{{ item.title }}</a>
        </div>  

        <div class="box-body">
            <p>{{ responseMessage }}</p>
        </div>
    </div>
      
</template>


<script>
    import Api from '../../utils/api'
    export default {
        data: ()=>({
            responseMessage: '',
            buttons: [
                {
                    title: 'Персонал',
                    url: 'activecollab/personal'
                },
                {
                    title: 'Проекты',
                    url: 'activecollab/projects'
                },
                {
                    title: 'Задачи',
                    url: 'activecollab/tasks'
                },
                {
                    title: 'Затреканное время',
                    url: 'activecollab/time-records'
                },
                {
                    title: 'Затреканное время (с отчисткой)',
                    url: 'activecollab/time-records/all'
                },
                {
                    title: 'Разослать выроботки за неделю',
                    url: '/api/send-email/personal-times'
                }
            ]
        }),
        methods: {
            loadActiveCollab(url){

                this.responseMessage = 'Выгружаю данные...';
                Api.getActiveCollab(url)
                    .then(response => {
                        this.responseMessage = response.data;
                    })
                    .catch(e=>this.responseMessage = e);
            }
        }
    }
</script>

<style scoped>
    .btn.btn-primary,
    .btn.btn-primary:hover {
        color: #fff;
    }
</style>


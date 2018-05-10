<template>
    <div class="flex">

        <div class="input-group mb-3 mr-4" v-if="load.group.length">
            <form method = "get">
                <label for="group">Группы</label>
                <select  class="custom-select" id="group"
                    v-for="item in load.group" :key="item.id"
                    v-model="input.group"
                    @change="onChangeGroup()"
                    >
                    <option :value="item.id">{{ item.name }}</option>
                </select>
            </form>
        </div>
        <div class="input-group mb-3 mr-4" v-if="load.group.length">
            <form method = "get">
                <label for="company">Компании</label>
                <select class="custom-select" id="company" 
                    v-for="item in load.company" :key="item.id"
                    v-model="input.company"
                    @change="onChangeCompany()"
                    >
                    <option :value="item.id">{{ item.name }}</option>
                </select>
            </form>
        </div> 
    </div>           

</template>
<script>
    export default {
        data: () => ({
            load: {
                groups: [],
                companies: []
            },
            input: {
                group: '',
                company: ''
            }
            

        }),
        methods: {
            onChangeGroup(){

                axios.post('/api/personal/groups')
                    .then(response => {

                    })
                    .catch(e => {
                        console.log(e)
                    })
            },
            onChangeCompany(){                

                axios.post('/api/personal/com')
                    .then(response => {

                    })
                    .catch(e => {
                        console.log(e)
                    })

            }
        },
        mounted(){

            axios.get('/api/personal/groups')
                .then(response => {
                    console.log(response.data)
                })
                .catch(e => {
                    console.log(e)
                })

            axios.get('/api/personal/companies')
                .then(response => {
                    console.log(response.data)
                })
                .catch(e => {
                    console.log(e)
                })

             
        }
    }

    // api/personal/companies
    // api/personal/groups
</script>



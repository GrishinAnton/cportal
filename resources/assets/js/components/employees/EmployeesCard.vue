<template>
    <div class="flex flex_w flex_jc-sb"
        
    >
        <b-card 
                v-for="item in personalInformation"
                :key="item.id"
                >
            <h4 slot="header"><a :href="item.url">{{ item.firstName }} {{ item.lastName }}</a></h4>
            <b-list-group flush>
                <b-list-group-item>{{ item.email }}</b-list-group-item>
            </b-list-group>
        </b-card>
    </div>
</template>
<script>
    import Api from '../../utils/api'
    export default {
        data: () => ({
            personalInformation: []
        }),
        mounted(){
            Api.getPersonal()
                .then(response => {
                    this.personalInformation = response.data.data; 
                })
                .catch(e => {
                    console.log(e);
                })
        }
    }
</script>

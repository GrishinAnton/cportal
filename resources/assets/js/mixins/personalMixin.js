export const personalMixin = {
    data: () => ({
        load: {
            groups: [],
            companies: []
        },
    }),
    mounted() {

        axios.get('/api/personal/groups')
            .then(response => {
                this.load.groups = response.data.data;              
            })
            .catch(e => {
                console.log(e)
            })

        axios.get('/api/personal/companies')
            .then(response => {
                this.load.companies = response.data.data;
            })
            .catch(e => {
                console.log(e)
            })

        // this.$watch(() => this.$store.getters['personal/personalInformation'], () => {
        //     this.input.group = this.$store.getters['personal/personalInformation'].first.group_id
        //     this.input.company = this.$store.getters['personal/personalInformation'].first.company_id
        //     this.input.persId = this.$store.getters['personal/personalInformation'].first.pers_id
        // });
    }
}
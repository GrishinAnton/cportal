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
            });

        axios.get('/api/personal/companies')
            .then(response => {
                this.load.companies = response.data.data;
            })
            .catch(e => {
                console.log(e)
            });        
    }
}
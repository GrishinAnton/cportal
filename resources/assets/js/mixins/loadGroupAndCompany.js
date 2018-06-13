import Api from '../utils/api'
export const loadGroupAndCompany = {
    data: () => ({
        load: {
            groups: [],
            companies: []
        },
    }),
    mounted() {

        Api.getGroup()
            .then(response => {
                this.load.groups = response.data.data;                                   
            })
            .catch(e => console.log(e));

        Api.getCompanies()
            .then(response => {
                this.load.companies = response.data.data;
            })
            .catch(e => console.log(e));        
    }
}
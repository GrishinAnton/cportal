export const personalFilter = {
    data: () => ({
        activeGroups: [],
        activeCompanies: [],
    }),
    methods: {
        onChange(obj) {
             
            var arrName;

            if (obj.item === 'group') {
                arrName = this.activeGroups;
            }
            if (obj.item === 'company') {
                arrName = this.activeCompanies;
            }

            var arrPosition = arrName.indexOf(obj.id);

            if (arrPosition === -1) {
                arrName.push(obj.id);
            } else {
                arrName.splice(arrPosition, 1);
            }

            this.requestFilter();

        },
        requestFilter() {

            axios.get(this.requestUrl, {
                params: {
                    group: this.activeGroups,
                    company: this.activeCompanies
                }
            })
                .then(response => {

                    this.activeGroups.length ? localStorage.setItem('activeGroup', this.activeGroups) : localStorage.removeItem('activeGroup');

                    this.activeCompanies.length ? localStorage.setItem('activeCompanies', this.activeCompanies) : localStorage.removeItem('activeCompanies');

                    if (this.sortTableData){
                        this.sortTableData(response.data.data);
                    } else {
                        this.personalInformation = response.data.data;
                        console.log(this.personalInformation);
                        
                    }
                    //pagination
                    this.paginationDataChange(response.data);

                })
                .catch(e => console.log(e));

        },
    },
    mounted() {
        if (!localStorage.length) {

            axios.get(this.requestUrl)
                .then(response => {
                    if (this.sortTableData) {
                        this.sortTableData(response.data.data);
                    } else {
                        this.personalInformation = response.data.data;
                    }

                    //pagination
                    this.paginationDataChange(response.data);
                })
                .catch(e => console.log(e));
        } else {

            var localGroup = localStorage.getItem('activeGroup');
            var localCompany = localStorage.getItem('activeCompanies');

            var arrGroup = localGroup ? localGroup.split(',') : localStorage.removeItem('activeGroup');
            this.activeGroups = _.map(arrGroup, _.parseInt);

            var arrCompany = localCompany ? localCompany.split(',') : localStorage.removeItem('activeCompanies');
            this.activeCompanies = _.map(arrCompany, _.parseInt);

            this.requestFilter();

        }
    }
}
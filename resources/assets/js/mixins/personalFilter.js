import Api from '../utils/api'
export const personalFilter = {
    data: () => ({
        activeGroups: [],
        activeCompanies: [],
        activeStatus: []
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
            if (obj.item === 'status') {
                arrName = this.activeStatus;
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
            
            Api.getSomeAxiosRequest(this.requestUrl, {
                params: {
                    group: this.activeGroups,
                    company: this.activeCompanies,
                    status: this.activeStatus,
                }
            })
            .then(response => {
                 
                this.activeGroups.length ? localStorage.setItem('activeGroup', this.activeGroups) : localStorage.removeItem('activeGroup');

                this.activeCompanies.length ? localStorage.setItem('activeCompanies', this.activeCompanies) : localStorage.removeItem('activeCompanies');

                this.activeStatus.length ? localStorage.setItem('activeStatus', this.activeStatus) : localStorage.removeItem('activeStatus');
                
                this.refreshTableData(response);
            })
            .catch(e => console.log(e));

        },
        refreshTableData(response) {

            if (this.sortTableData) {
                this.sortTableData(response.data.data);
            } else {
                this.personalInformation = response.data.data;
            }

            //pagination
            if (this.paginationDataChange){
                this.paginationDataChange(response.data);
            }
        }
    },
    mounted() {
        if (!localStorage.length) {

            Api.getSomeAxiosRequest(this.requestUrl)
                .then(response => {                                        
                    this.refreshTableData(response);
                })
                .catch(e => console.log(e));
        } else {

            var localGroup = localStorage.getItem('activeGroup');
            var localCompany = localStorage.getItem('activeCompanies');
            var localStatus = localStorage.getItem('activeStatus');

            

            var arrGroup = localGroup ? localGroup.split(',') : localStorage.removeItem('activeGroup');
            this.activeGroups = _.map(arrGroup, _.parseInt);

            var arrCompany = localCompany ? localCompany.split(',') : localStorage.removeItem('activeCompanies');            
            this.activeCompanies = _.map(arrCompany, _.parseInt);           

            var arrStatus = localStatus ? localStatus.split(',') : localStorage.removeItem('activeStatus');
            this.activeStatus = _.map(arrStatus, _.parseInt);

            this.requestFilter();

        }
    }
}
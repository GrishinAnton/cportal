export const paginationMixin = {
    data: () => ({
        paginationData: {
            links: {
                first: '',
                last: '',
                next: '',
                prev: ''
            },
            currentPage: 0,
            perPage: 0,
            total: 0
        }
    }),
    computed: {
        showPagination() {
            return this.paginationData.total > this.paginationData.perPage;
        }
    },
    methods: {
        onPaginationChange(data){

            axios.get(`/api/personal`, {
                params: {
                    page: data
                }
            })
                .then(response => {
                    this.personalInformation = response.data.data;   

                    //pagination
                    this.paginationDataChange(response.data);
                })
                .catch(e => {
                    console.log(e);
                });
        },
        paginationDataChange(response){
            this.paginationData.links = response.links;
            this.paginationData.currentPage = response.meta.current_page;
            this.paginationData.perPage = response.meta.per_page;
            this.paginationData.total = response.meta.total;
        }
    }
};
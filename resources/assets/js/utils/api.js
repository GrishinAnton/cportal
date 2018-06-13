const Api = {
    //ProjectApi
    getProjectStatuses: () => axios.get(`/api/report/projects/statuses`),
    getProjectCosts: (id) => axios.get(`/api/report/projects/${id}/costs`)
}

export default Api
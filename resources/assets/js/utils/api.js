const Api = {
    //ProjectApi
    getProjectStatuses: () => axios.get(`/api/report/projects/statuses`),
    getProjectCosts: (id) => axios.get(`/api/report/projects/${id}/costs`),
    getProjectFot: (id) => axios.get(`/api/report/projects/${id}/fot`),
    getProjectHoursSpent: (id) => axios.get(`/api/report/projects/${id}/hours-spent`),
    postProjectHoursSpent: (id, data) => axios.post(`/api/report/projects/${id}`, data)
}

export default Api;
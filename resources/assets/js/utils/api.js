const Api = {
    //LoadGroupAndCompany
    getGroup: () => axios.get('/api/personal/groups'),
    getCompanies: () => axios.get('/api/personal/companies'),
    //ProjectApi
    getProjectStatuses: () => axios.get(`/api/report/projects/statuses`),
    getProjectCosts: (id) => axios.get(`/api/report/projects/${id}/costs`),
    getProjectFot: (id) => axios.get(`/api/report/projects/${id}/fot`),
    getProjectHoursSpent: (id) => axios.get(`/api/report/projects/${id}/hours-spent`),
    postProjectHoursSpent: (id, data) => axios.post(`/api/report/projects/${id}`, data),
    //ActiveCollab
    getActiveCollab: (url) => axios.get(url),
    //Personal
    getPersonal: () => axios.get('/api/personal')
}

export default Api;
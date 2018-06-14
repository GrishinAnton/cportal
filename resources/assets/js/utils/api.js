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
    getProject: (id) => axios.get(`/api/report/projects/${id}`),
    //ActiveCollab
    getActiveCollab: (url) => axios.get(url),
    //Personal
    getPersonal: (params={}) => axios.get('/api/personal', params),
    postPersonalGroup: (id, group) => axios.post(`/api/personal/${id}/add/group`, group),
    postPersonalCompany: (id, company) => axios.post(`/api/personal/${id}/add/company`, company),
    getPersonalGroupAndCompany: (id) => axios.get(`/api/personal/${id}/group-company`),
    //Costs
    getReportCosts: (params) => axios.get(`/api/report/costs`, params),
    postReportCosts: (url, obj) => axios.post(url, obj),
    //Salary
    getSalaryPersonalCosts: (params) => axios.get(`/api/personal/costs`, params),
    getSalaryProjectCosts: (id, params) => axios.get(`/api/personal/${id}/project-costs`, params),
    getSalaryPersonalSalary: (id, params) => axios.get(`/api/personal/${id}/salary`, params),
    getSalaryPersonalProjectCostStore: (id, data) => axios.post(`/api/personal/${id}/project-costs/store`, data),
    getSalaryPersonalStoreUpdate: (url, data) => axios.post(url, data),
    //SomeMixin
    getSomeAxiosRequest: (url, params={}) => axios.get(url, params)
}

export default Api;



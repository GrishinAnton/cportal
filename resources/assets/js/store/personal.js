import Api from '../utils/api'
export default {
    namespaced: true,
    state: {
        personal: '',
        users: ''

    },
    getters: {
        personalInformation(state){
            
            return state.personal;
        },
        teamLeadUsers(state){     
             return state.users
        }
    },
    mutations: {
        personalInformation(state, obj){            
            state.personal = obj;            
        },
        onLoadUsers(state, payLoad){            
            state.users = payLoad;
        }
    },
    actions: {
        loadUsers(state, persId){
            Api.getTeamleadUsers(persId)
                .then(response => {
                    state.commit('onLoadUsers', response.data.data)                                    
                })
                .catch(e => {
                    console.log(e)
                })
        }
    }
}
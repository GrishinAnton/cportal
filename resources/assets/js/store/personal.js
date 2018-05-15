export default {
    namespaced: true,
    state: {
        personal: ''

    },
    getters: {
        personalInformation(state){
            
            return state.personal;
        }
    },
    mutations: {
        personalInformation(state, obj){            
            state.personal = obj;            
        }
    },
    actions: {

    }
}
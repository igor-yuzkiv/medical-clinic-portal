import {createStore} from "vuex";
import * as types from "@/store/mutation-types";
import {SET_AUTH_TOKEN, SET_CURRENT_USER, SET_IS_LOADING} from "@/store/mutation-types";
import {logoutRequest} from "@/api/authApi.js";


const store = createStore({
    modules  : {},
    state    : {
        isLoading: false,
        user     : {
            id   : null,
            name : null,
            email: null,
            role : null,
        },
        token    : localStorage.getItem('token')
    },
    getters  : {},
    actions  : {
        async logout({commit}) {
            await logoutRequest()
                .catch(console.error)
                .finally(() => {
                    commit(SET_AUTH_TOKEN, null);
                    commit(SET_CURRENT_USER, null);
                    localStorage.removeItem("token");
                })
        }
    },
    mutations: {
        [types.SET_IS_LOADING]  : (state, value) => state.isLoading = value,
        [types.SET_CURRENT_USER]: (state, value) => state.user = value,
        [types.SET_AUTH_TOKEN]  : (state, value) => state.token = value,
    }
})

export default store;

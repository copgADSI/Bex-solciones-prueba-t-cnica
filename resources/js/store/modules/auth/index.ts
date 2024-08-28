import { ActionContext } from "vuex";
import { AuthState, RootState } from "../../../interfaces/auth";

const state: AuthState = {
    authUser: null,
    token: null,
};

const mutations = {
    SET_AUTH_USER(state: AuthState, user: any) {
        state.authUser = user;
        localStorage.setItem('authUser', JSON.stringify(user));
    },
    SET_TOKEN(state: AuthState, token: string) {
        state.token = token;
        localStorage.setItem('token', token);
    },
    CLEAR_AUTH(state: AuthState) {
        state.authUser = null;
        state.token = null;
        localStorage.removeItem('authUser');
        localStorage.removeItem('token');
    }
};

const actions = {
    async logout({ commit }: ActionContext<AuthState, RootState>) {
        commit('CLEAR_AUTH');
    },
    initializeAuth({ commit }: ActionContext<AuthState, RootState>) {
        const authUser = localStorage.getItem('authUser');
        const token = localStorage.getItem('token');
        if (authUser && token) {
            commit('SET_AUTH_USER', JSON.parse(authUser));
            commit('SET_TOKEN', token);
        }
    }
};

const getters = {
    isAuthenticated(state: AuthState): boolean {
        return !!state.token;
    },
    getAuthUser(state: AuthState): any {
        return state.authUser;
    }
};

export default {
    namespaced: true,
    state,
    mutations,
    actions,
    getters
};

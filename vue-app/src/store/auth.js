import axios from 'axios'

export default ({
    namespaced: true,

    state: {
        token: null,
        user: null,
        menu: null
    },

    getters: {
        authenticated(state) {
            return state.token && state.user
        },

        user(state) {
            return state.user
        },

        menu(state) {
            return state.menu
        }
    },

    mutations: {
        SET_TOKEN(state, token) {
            state.token = token
        },

        SET_USER(state, data) {
            state.user = data
        },

        SET_MENU(state, menu) {
            state.menu = menu
        }
    },

    actions: {
        async login({ dispatch }, credentials) {
            let response = await axios.post("login", credentials);

            if (response.data.status) {
                dispatch('attempt', response.data.token)
                dispatch('loadMenu', response.data.token)
                return { 'status': true, 'message': 'success' }
            } else {
                return { 'status': false, 'message': response.data.message }
            }
        },

        async attempt({ commit, state }, token) {
            if (token) {
                commit('SET_TOKEN', token)
                localStorage.setItem('token', token)
                localStorage.setItem('auth', true)
            }

            if (!state.token) {
                return
            }

            try {
                let response = await axios.get('user', {
                    headers: {
                        'Authorization': 'Bearer ' + token
                    }
                })

                commit('SET_USER', response.data)
            } catch (error) {
                console.log('error')
                localStorage.removeItem('token')
                localStorage.removeItem('auth')
                commit('SET_TOKEN', null)
                commit('SET_USER', null)
            }
        },

        async loadMenu({ commit }, token) {
            try {
                let response = await axios.get('menu', {
                    headers: {
                        'Authorization': 'Bearer ' + token
                    }
                })
                commit('SET_MENU', response.data.data)
                localStorage.setItem('menu', JSON.stringify(response.data.data))
            } catch (error) {
                commit('SET_MENU', null)
                localStorage.removeItem('menu')
            }
        },

        async register(_, credentials) {
            let response = await axios.post('register', credentials)

            return response.data
        },

        async update({ commit }, user) {
            try {
                let response = await axios.put('user', user, {
                    headers: {
                        'Authorization': 'Bearer ' + localStorage.getItem('token')
                    }
                })

                commit('SET_USER', response.data.user)

                return response.data
            } catch (error) {
                console.log(error)
            }
        },

        async delete({ dispatch }) {
            try {
                let response = await axios.delete('user', {
                    headers: {
                        'Authorization': 'Bearer ' + localStorage.getItem('token')
                    }
                })

                dispatch('logout')

                return response.data
            } catch (error) {
                console.log(error)
            }
        },

        logout({ commit }) {
            localStorage.removeItem('token')
            localStorage.removeItem('auth')
            localStorage.removeItem('menu')
            commit('SET_TOKEN', null)
            commit('SET_USER', null)
            commit('SET_MENU', null)
        }
    }
})

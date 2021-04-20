import { createApp } from 'vue'
import App from './App.vue'
import router from './router'

import 'bootstrap'
import 'bootstrap/dist/css/bootstrap.min.css'

import axios from 'axios'
import store from './store'

axios.defaults.baseURL = 'http://localhost:8000/api/'

store.dispatch('auth/attempt', localStorage.getItem('token')).then(() => {
    createApp(App).use(store).use(router).mount('#app')
})

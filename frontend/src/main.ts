import './assets/main.css'

import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import axios from 'axios';

axios.defaults.baseURL = 'http://127.0.0.1:8000/api';

const app = createApp(App)

app.config.globalProperties.$handleError = function (error: any) {
    let errorMessage = 'An error occurred';
    if (error.response && error.response.data.errors) {
        const errors = error.response.data.errors;
        const firstErrorKey = Object.keys(errors)[0];
        errorMessage = errors[firstErrorKey][0];
    } else if (error.request) {
        errorMessage = 'No response from server';
    } else {
        errorMessage = error.message;
    }
    return errorMessage;
  };

app.use(router)

app.mount('#app')

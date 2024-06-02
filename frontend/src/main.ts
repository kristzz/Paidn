import './assets/main.css';
import { createApp } from 'vue';
import App from './App.vue';
import router from './router';
import axios from 'axios';

// Set the base URL for Axios
axios.defaults.baseURL = 'https://api-12dkgabrielis.kvalifikacija.rvt.lv/api';

// Define a global error handler for Axios
axios.interceptors.response.use(
  (response) => response,
  (error) => {
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
    return Promise.reject(errorMessage);
  }
);

const app = createApp(App);

app.use(router);

app.mount('#app');

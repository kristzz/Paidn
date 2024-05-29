<template>
    <main>
      <form class="input-auth-container">
        <input class="small-auth-input" type="email" placeholder="email@example.com" v-model="email">
        <input class="small-auth-input" type="password" placeholder="password" v-model="password">
        <p v-if="errorMessage" style="color: red;">{{ errorMessage }}</p> <!-- Display error message -->
        <div class="row">
          <button class="authButton weight-regular height-text" type="button" @click="login">Login</button>
          <router-link to="/register" id="left" style="color: inherit;">Register instead</router-link>
        </div>
      </form>
    </main>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    data() {
      return {
        email: '',
        password: '',
        errorMessage: '',
      };
    },
    methods: {
      login() {
        this.errorMessage = '';
        if (!this.email || !this.password) {
          this.errorMessage = 'Email and password are required';
          return;
        }
  
        axios.post('/login', {
          email: this.email,
          password: this.password,
        }).then((response) => {
          if (response.status === 200) {
            localStorage.setItem('authToken', response.data.token);
            axios.defaults.headers.common['Authorization'] = `Bearer ${response.data.token}`;
            this.$router.push('/home');
          } else {
            this.errorMessage = 'Login failed';
          }
        }).catch((error) => {
          if (error.response && error.response.data && error.response.data.message) {
            this.errorMessage = error.response.data.message;
          } else {
            this.errorMessage = 'An error occurred during login';
          }
        });
      },
    },
  };
  </script>
  
  <style scoped>
  main {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
  }
  .row {
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    width: 20rem;
    padding: 1rem 2rem;
  }
  #left {
    margin-top: 0.75rem;
  }
  </style>
  
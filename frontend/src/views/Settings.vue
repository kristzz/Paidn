<template>
    <div>
      <button @click="logout">Logout</button>
  
      <button @click="deleteAccount">Delete Account</button>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    data() {
        return {
            authToken: localStorage.getItem('authToken')
        }
    },
    methods: {
      logout() {
        axios.get('/logout', {
            headers: {
            Authorization: `Bearer ${this.authToken}`
            }
        }).then(response => {
            if (response.data.status) {
              localStorage.removeItem('authToken');
              localStorage.removeItem('userType');
              window.location.href = '/login';
            } else {
              alert(response.data.message);
            }
          })
          .catch(error => {
            console.error('Error logging out:', error);
          });
      },
  
      deleteAccount() {
        axios.get('/deleteUser',{
            headers: {
            Authorization: `Bearer ${this.authToken}`
            }
        }).then(response => {
            if (response.data.message) {
              localStorage.removeItem('authToken');
              localStorage.removeItem('userType');
              window.location.href = '/login';
            } else {
              alert('Failed to delete account');
            }
          })
          .catch(error => {
            console.error('Error deleting account:', error);
          });
      }
    }
  };
  </script>
  
  <!-- Styles if needed -->
  <style>
  /* Add your styles here */
  </style>
  
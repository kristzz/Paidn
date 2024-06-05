<template>
    <div class="container">
      <button class="logoutButton button height-regular" @click="logout">Logout</button>
  
      <button class="deleteButton button height-regular" @click="deleteAccount">Delete Account</button>
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
  
  <style scoped>
    .container{
      display: flex;
      align-items: center;
      justify-content: center;
      height: 95vh;
      flex-direction: column;
      gap: 5%;
    }

    .button{
      border-radius: 2rem;
      width: 20rem;
      height: 4rem;
      padding: 0.5rem;
      color: var(--text-color);
      cursor: pointer;
    }

    .logoutButton{
      background: var(--accent-color);
    }

    .deleteButton{
      background: var(--color-red)
    }
  </style>
  
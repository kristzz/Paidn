<template>
    <div>
      <h2>Users</h2>
      <table>
        <thead>
          <tr>
            <th>Email</th>
            <th>Type</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="user in users" :key="user.id">
            <td>{{ user.email }}</td>
            <td>{{ user.type }}</td>
            <td>
              <button class="textButton deleteButton height-text" @click="deleteUser(user.id)">Delete</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    data() {
      return {
        users: []
      };
    },
    created() {
      this.fetchUsers();
    },
    methods: {
      async fetchUsers() {
        try {
          const response = await axios.get('/admin/users', {
            headers: {
              'Authorization': `Bearer ${localStorage.getItem('authToken')}`
            }
          });
          this.users = response.data.users;
        } catch (error) {
          console.error(error);
        }
      },
      async deleteUser(userId) {
        try {
          await axios.delete(`/admin/users/${userId}`, {
            headers: {
              'Authorization': `Bearer ${localStorage.getItem('authToken')}`
            }
          });
          this.users = this.users.filter(user => user.id !== userId);
        } catch (error) {
          console.error(error);
        }
      }
    }
  };
  </script>
  
  <style scoped>
  table {
    width: 100%;
    border-collapse: collapse;
  }
  
  th, td {
    border: 1px solid #ddd;
    padding: 8px;
  }
  
  .textButton {
    color: var(--text-color);
    cursor: pointer;
    padding: 0.5rem;
    border-radius: 1.5rem;
  }
  
  .deleteButton {
    width: 5rem;
    background: var(--color-red);
  }
  
  .height-text {
    font-size: 1rem;
  }
  </style>
  
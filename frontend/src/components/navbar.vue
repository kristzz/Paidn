<template>
    <nav v-if="isLoggedIn">
      <ul>
        <li v-if="userType === 'business' || userType === 'user'"><router-link to="/home">Home</router-link></li>
        <li v-if="userType === 'business' || userType === 'user'"><router-link to="/profile">Profile</router-link></li>
        <li><router-link to="/settings">Settings</router-link></li>
        <li v-if="userType === 'admin'"><router-link to="/admin">Admin</router-link></li>
      </ul>
    </nav>
  </template>
  
  <script>
  export default {
    name: 'Navbar',
    data() {
      return {
        isLoggedIn: false,
        userType: ''
      };
    },
    mounted() {
      this.isLoggedIn = localStorage.getItem('authToken') !== null;
      this.userType = localStorage.getItem('userType');
    }
  };
  </script>


<style scoped>
nav {
  background-color: var(--accent-color);
  padding: 10px 0;
  display: flex;
  justify-content: end;
}

ul {
  list-style-type: none;
  margin: 0;
  padding: 0;
  display: flex;
}

li {
  margin-right: 20px;
}

a {
  color: white;
  text-decoration: none;
}

a:hover {
  text-decoration: underline;
}
</style>
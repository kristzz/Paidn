<template>
  <h1>Profile</h1>
    <div v-if="profileData">
        <p>Name: {{ profileData.name }}</p>
        <p>Surname: {{ profileData.surname }}</p>
        <p>Gender: {{ profileData.gender }}</p>
    </div>
    <div v-else>
        <p>Loading...</p>
    </div>
</template>

<script>
import axios from 'axios';

export default {
  data(){
    return{
        profileData: []
    };
  },
  mounted(){
    const authToken = localStorage.getItem('authToken');
    if(authToken) {
        this.fetchProfile(authToken);
    }else {
        alert('You are not logged in');
        this.$router.push('/login');
    }
  },
    methods: {
        fetchProfile(authToken){
            axios.get('/getUserProfile', {
                headers: {
                    Authorization: `Bearer ${authToken}`
                }
            }).then((response) => {
                console.log('Response Data:', response.data);
                this.profileData = response.data.userData;
                console.log('Profile Data:', this.profileData);
            }).catch((error) => {
                console.log(error.message);
            });
        }
    }
}
</script>

<style>

</style>
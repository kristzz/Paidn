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
    <h1>Education</h1>
    <div v-if="educationData && educationData.length > 0">
        <div v-for="educationEntry in educationData" :key="educationEntry.id">
            <p>Provider: {{ educationEntry.educationProvider }}</p>
            <p>Level: {{ educationEntry.levelOfEducation }}</p>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
  data(){
    return{
        profileData: {},
        educationData: []
    };
  },
  mounted(){
    const authToken = localStorage.getItem('authToken');
    if(authToken) {
        this.fetchProfile(authToken);
        this.fetchEducation(authToken);
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
                this.profileData = response.data.userData;
            }).catch((error) => {
                console.log(error.message);
            });
        },
        fetchEducation(authToken) {
            axios.get('/getEducation', {
                headers: {
                    Authorization: `Bearer ${authToken}`
                }
            }).then((response) => {
                this.educationData = response.data.education;
                console.log('Education Data Fetched:', this.educationData);
            }).catch((error) => {
                console.log(error.message);
            });
        },
    }
}
</script>

<style>

</style>
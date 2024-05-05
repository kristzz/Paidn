<template>
    <div v-if="profileData">
        <h1>Profile</h1>
        <p>Name: {{ profileData.name }}</p>
        <p v-if="profileData.secondName">Second name: {{ profileData.secondName }}</p>
        <p>Surname: {{ profileData.surname }}</p>
        <p>Gender: {{ profileData.gender }}</p>
    </div>
    <div v-else>
        <p>Loading...</p>
    </div>
    <div v-if="educationData && educationData.length > 0">
        <h1>Education</h1>
        <div v-for="educationEntry in educationData" :key="educationEntry.id">
            <p>Provider: {{ educationEntry.educationProvider }}</p>
            <p>Education level: {{ educationEntry.levelOfEducation }}</p>
            <p>Field of study: {{ educationEntry.fieldOfStudy }}</p>
            <p v-if="educationEntry.description">Description: {{ educationEntry.description }}</p>
            <p>From: {{ educationEntry.startDate }}</p>
            <p v-if="educationEntry.endDate">To: {{ educationEntry.endDate }}</p>
        </div>
    </div>
    <div v-else>
        <p>Loading...</p>
    </div>
    <div v-if="workData && workData.length > 0">
        <h1>Work Experience</h1>
        <div v-for="workEntry in workData" :key="workEntry.id">
            <p>Company: {{ workEntry.companyName }}</p>
            <p>Position: {{ workEntry.workPositionName }}</p>
            <p v-if="workEntry.description">Description: {{ workEntry.description }}</p>
            <p>From: {{ workEntry.startDate }}</p>
            <p v-if="workEntry.endDate">To: {{ workEntry.endDate }}</p>
        </div>
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
        profileData: {},
        educationData: [],
        workData: []
    };
  },
  mounted(){
    const authToken = localStorage.getItem('authToken');
    if(authToken) {
        this.fetchProfile(authToken);
        this.fetchEducation(authToken);
        this.fetchWork(authToken);
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
            }).catch((error) => {
                console.log(error.message);
            });
        },
        fetchWork(authToken) {
            axios.get('/getWorkExperience', {
                headers: {
                    Authorization: `Bearer ${authToken}`
                }
            }).then((response) => {
                this.workData = response.data.work;
            }).catch((error) => {
                console.log(error.message);
            });
        }
    }
}
</script>

<style>

</style>
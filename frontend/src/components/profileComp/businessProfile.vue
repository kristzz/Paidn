<template>
    <div v-if="userType === 'business'">
      <div v-if="businessProfileData">
        <h1>Business Profile</h1>
        <p>Company name: {{ businessProfileData.companyName }}</p>
        <p>VAT: {{ businessProfileData.vat }}</p>
        <p>Legal form: {{ businessProfileData.legalForm }}</p>
        <button @click="editBusinessProfile = true">Edit Business Profile</button>
      </div>
      <div v-else-if="businessProfileData === null">
        <p>No business profile data found. Please add your business profile information.</p>
        <button @click="editBusinessProfile = true">Add Business Profile Information</button>
      </div>
      <div v-else>
        <p>Loading...</p>
      </div>
  
      <div v-if="editBusinessProfile">
        <h2>Edit Business Profile</h2>
        <form @submit.prevent="updateBusinessProfile">
          <input type="text" v-model="businessProfileForm.companyName" placeholder="Company Name" required />
          <input type="text" v-model="businessProfileForm.vat" placeholder="VAT" required />
          <input type="text" v-model="businessProfileForm.legalForm" placeholder="Legal Form" required />
          <button type="submit">Save</button>
          <button @click="editBusinessProfile = false">Cancel</button>
        </form>
      </div>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    props: ['authToken'],
    data() {
      return {
        userType: '',
        businessProfileData: null,
        editBusinessProfile: false,
        businessProfileForm: {
          companyName: '',
          vat: '',
          legalForm: ''
        }
      };
    },
    mounted() {
      this.fetchBusinessProfile(this.authToken);
      this.userType = localStorage.getItem('userType');
    },
    methods: {
      fetchBusinessProfile(authToken) {
        axios.get('/getBusinessProfile', {
          headers: {
            Authorization: `Bearer ${authToken}`
          }
        }).then((response) => {
          this.businessProfileData = response.data.businessUserData || null;
          if (this.businessProfileData) {
            this.businessProfileForm = { ...this.businessProfileData };
          }
        }).catch((error) => {
          console.log(error.message);
        });
      },
      updateBusinessProfile() {
        axios.post('/editBusinessUser', this.businessProfileForm, {
          headers: {
            Authorization: `Bearer ${this.authToken}`
          }
        }).then(response => {
          if (response.data.status) {
            this.businessProfileData = { ...this.businessProfileForm };
            this.editBusinessProfile = false;
          } else {
            alert(response.data.message);
          }
        }).catch(error => {
          console.log(error.message);
        });
      }
    }
  };
  </script>
  
  <style scoped>
  /* Add your styles here */
  </style>
  
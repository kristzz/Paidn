<template>
  <div v-if="userType === 'user'">
    <div v-if="profileData">
      <h1>Profile</h1>
      <p>Name: {{ profileData.name }}</p>
      <p v-if="profileData.secondName">Second name: {{ profileData.secondName }}</p>
      <p>Surname: {{ profileData.surname }}</p>
      <p>Age: {{ profileData.age }}</p>
      <p>Gender: {{ profileData.gender }}</p>
      <button @click="openEditProfile()">Edit Profile</button>
    </div>
    <div v-else-if="profileData === null">
      <p>No profile data found. Please add your profile information.</p>
      <button @click="openEditProfile()">Add Profile Information</button>
    </div>
    <div v-else>
      <p>Loading...</p>
    </div>

    <!-- Edit Profile Modal -->
    <div v-if="showEditProfileModal" class="modal">
      <div class="modal-content">
        <span class="close" @click="closeEditProfileModal">&times;</span>
        <h2>Edit Profile</h2>
        <form @submit.prevent="updateProfile">
          <input type="text" v-model="profileForm.name" placeholder="Name" required />
          <input type="text" v-model="profileForm.secondName" placeholder="Second Name" />
          <input type="text" v-model="profileForm.surname" placeholder="Surname" required />
          <input type="number" v-model="profileForm.age" placeholder="Age" required />
          <input type="text" v-model="profileForm.nationality" placeholder="Nationality" required />
          <select v-model="profileForm.gender" required>
            <option value="" disabled>Select Gender</option>
            <option value="male">Male</option>
            <option value="female">Female</option>
            <option value="other">Other</option>
          </select>
          <button type="submit">Save</button>
          <button @click="closeEditProfileModal">Cancel</button>
        </form>
      </div>
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
      profileData: null,
      showEditProfileModal: false,
      profileForm: {
        name: '',
        secondName: '',
        surname: '',
        age: '',
        nationality: '',
        gender: ''
      }
    };
  },
  mounted() {
    this.fetchProfile(this.authToken);
    this.userType = localStorage.getItem('userType');
  },
  methods: {
    fetchProfile(authToken) {
      axios.get('/getUserProfile', {
        headers: {
          Authorization: `Bearer ${authToken}`
        }
      }).then((response) => {
        this.profileData = response.data.userData || null;
        if (this.profileData) {
          this.profileForm = { ...this.profileData };
        }
      }).catch((error) => {
        console.log(error.message);
      });
    },
    updateProfile() {
      axios.post('/editRegularUser', this.profileForm, {
        headers: {
          Authorization: `Bearer ${this.authToken}`
        }
      }).then(response => {
        if (response.data.status) {
          this.profileData = { ...this.profileForm };
          this.showEditProfileModal = false;
        } else {
          alert(response.data.message);
        }
      }).catch(error => {
        console.log(error.message);
      });
    },
    openEditProfile() {
      this.showEditProfileModal = true;
    },
    closeEditProfileModal() {
      this.showEditProfileModal = false;
    }
  }
};
</script>

<style>
.modal {
  display: flex;
  justify-content: center;
  align-items: center;
  position: fixed;
  z-index: 1;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: auto;
  background-color: rgba(0, 0, 0, 0.4);
}

.modal-content {
  background-color: #fefefe;
  padding: 20px;
  border: 1px solid #888;
  width: 80%;
  max-width: 600px;
  margin: auto;
}

.close {
  color: #aaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: black;
  text-decoration: none;
  cursor: pointer;
}
</style>

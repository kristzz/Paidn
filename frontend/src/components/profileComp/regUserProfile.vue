<template>
  <div v-if="userType === 'user'" class="paper">
    <h1 class="marginTop">Personal Info</h1>
    <div v-if="profileData" class="container">
      <p><div class="weight-light">Name:</div> {{ profileData.name }}</p>
      <p v-if="profileData.secondName"><div class="weight-light">Second name:</div> {{ profileData.secondName }}</p>
      <p><div class="weight-light">Surname:</div> {{ profileData.surname }}</p>
      <p><div class="weight-light">Age:</div> {{ profileData.age }}</p>
      <p><div class="weight-light">Gender:</div> {{ profileData.gender }}</p>
      <button class="textButton editButton height-text" @click="openEditProfile()">Edit</button>
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
        <form class="editForm background" @submit.prevent="updateProfile">
          <input class="editInput height-text" type="text" v-model="profileForm.name" placeholder="Name" required />
          <input class="editInput height-text" type="text" v-model="profileForm.secondName" placeholder="Second Name" />
          <input class="editInput height-text" type="text" v-model="profileForm.surname" placeholder="Surname" required />
          <input class="editInput height-text" type="number" v-model="profileForm.age" placeholder="Age" required />
          <input class="editInput height-text" type="text" v-model="profileForm.nationality" placeholder="Nationality" required />
          <select class="editInput height-text" v-model="profileForm.gender" required>
            <option value="" disabled>Select Gender</option>
            <option value="male">Male</option>
            <option value="female">Female</option>
            <option value="other">Other</option>
          </select>
          <div class="row editButtons edButtons">
            <button class="textButton editButton height-text" type="submit">Save</button>
            <button class="textButton deleteButton height-text" @click="closeEditProfileModal">Cancel</button>
          </div>
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

<style scoped>
button{
  text-align: center;
}

.paper{
  width: 90%;
  left: 5%;
  position: relative;
}

.marginTop{
  margin-top: 2rem;
}

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
  background-color: var(--box-color);
  padding: 20px;
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

.row{
  display: flex;
  align-items: center;
  flex-direction: row;
}

.editInput{
  background: var(--color-white);
  border-radius: 1rem;
  padding: 0.5rem;
  max-width: 9rem;
}

.editForm{
  display: flex;
  flex-wrap: wrap;
  gap: 1rem;
  margin-top: 1rem;
}

.editButtons{
  border-radius: 1rem;
}

.edButtons{
  gap: 1.5rem;
  width: 100%;
  justify-content: space-between; 
}

.container {
  background: var(--box-color);
  width: 100%;
  margin: 1rem auto;
  padding: 1rem;
  box-shadow: 0 4px 8px rgba(0, 127, 255, 0.1);
  display: flex;
  flex-direction: column;
  align-items: flex-start;
}

.addButton{
  border-radius: 50%;
  height: 2rem;
  width: 2rem;
  background: var(--accent-color);
  color: var(--color-white);
  cursor: pointer;
  position: relative;
}

.textButton{
  color: var(--text-color);
  cursor: pointer; 
  padding: 0.5rem;
  border-radius: 1.5rem;
}

.editButton{
  width: 5rem;
  background: var(--accent-color);
}

.deleteButton{
  width: 5rem;
  background: var(--color-red)
}

.container p {
  margin: 0.5rem 0;
  display: flex;
  gap: 0.35rem;
}

.container button {
  display: block;
  margin-top: 10px;
}

.container p{
  text-align: left;
}

.wrapper{
  display: flex;
  align-items: start;
  justify-content: start; 
  flex-direction: column;
}

@media (min-width: 768px) {
  .addButton{
    width: 2rem;
    height: 2rem;
    font-size: 1.325rem;
  }

  .paper{
    width: 90%;
  }

  .wrapper{
    display: flex;
    align-items: start;
    justify-content: start; 
    flex-direction: row;
    gap: 2%;
  }

  .container{
    min-width: 50%;
  }

  .heading{
    gap: 1rem;
  }
}
</style>

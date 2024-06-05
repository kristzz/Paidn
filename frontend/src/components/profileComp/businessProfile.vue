<template>
  <div v-if="userType === 'business'" class="paper">
    <h1 class="marginTop">Business Profile</h1>
    <div v-if="businessProfileData" class="container">
      <p><div class="weight-light">Business Name:</div> {{ businessProfileData.businessName }}</p>
      <p><div class="weight-light">Business Type:</div> {{ businessProfileData.businessType }}</p>
      <p><div class="weight-light">Description:</div> {{ businessProfileData.businessDescription }}</p>
      <p><div class="weight-light">Address:</div> {{ businessProfileData.businessAddress }}</p>
      <button class="textButton editButton height-text" @click="editBusinessProfile = true">Edit</button>
    </div>
    <div v-else-if="businessProfileData  !== null">
      <p>Loading...</p>
    </div>
    <div v-else>
      <h2>Create Business Profile</h2>
      <form class="editForm background" @submit.prevent="saveBusinessProfile">
        <input class="editInput height-text" type="text" v-model="businessProfileForm.businessName" placeholder="Business Name" required />
        <input class="editInput height-text" type="text" v-model="businessProfileForm.businessType" placeholder="Business Type" required />
        <input class="editInput height-text" type="text" v-model="businessProfileForm.businessDescription" placeholder="Business Description" />
        <input class="editInput height-text" type="text" v-model="businessProfileForm.businessAddress" placeholder="Business Address" required />
        <div class="row editButtons edButtons">
          <button class="textButton editButton height-text" type="submit">Save</button>
          <button class="textButton deleteButton height-text" @click="resetForm">Cancel</button>
        </div>
      </form>
    </div>

    <div v-if="editBusinessProfile" class="modal">
      <div class="modal-content">
        <span class="close" @click="editBusinessProfile = false">&times;</span>
        <h2>Edit Business Profile</h2>
        <form class="editForm background" @submit.prevent="saveBusinessProfile">
          <input class="editInput height-text" type="text" v-model="businessProfileForm.businessName" placeholder="Business Name" required />
          <input class="editInput height-text" type="text" v-model="businessProfileForm.businessType" placeholder="Business Type" required />
          <input class="editInput height-text" type="text" v-model="businessProfileForm.businessDescription" placeholder="Business Description" />
          <input class="editInput height-text" type="text" v-model="businessProfileForm.businessAddress" placeholder="Business Address" required />
          <div class="row editButtons edButtons">
            <button class="textButton editButton height-text" type="submit">Save</button>
            <button class="textButton deleteButton height-text" @click="editBusinessProfile = false">Cancel</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'BusinessProfile',
  data() {
    return {
      userType: '',
      businessProfileData: null,
      editBusinessProfile: false,
      businessProfileForm: {
        businessName: '',
        businessType: '',
        businessDescription: '',
        businessAddress: ''
      }
    };
  },
  mounted() {
    const authToken = localStorage.getItem('authToken');
    this.userType = localStorage.getItem('userType');
    if (authToken) {
      this.fetchBusinessProfileData(authToken);
    } else {
      alert('You are not logged in');
      this.$router.push('/login');
    }
  },
  methods: {
    fetchBusinessProfileData(authToken) {
      axios.get('/getBusinessProfile', {
        headers: {
          Authorization: `Bearer ${authToken}`,
          'Content-Type': 'application/json'
        }
      })
      .then(response => {
        const contentType = response.headers['content-type'];

        if (contentType && contentType.includes('application/json')) {
          const data = response.data;

          if (data.status && data.businessData) {
            console.log('Fetched business profile data:', data.businessData);
            this.businessProfileData = data.businessData;
          } else {
            console.error('Error: Invalid data structure received:', data);
          }
        } else {
          response.text().then(textResponse => {
            console.error('Expected JSON response but received:', textResponse);
          });
        }
      })
      .catch(error => {
        console.error('Error fetching business profile data:', error);
      });
    },
    saveBusinessProfile() {
      const authToken = localStorage.getItem('authToken');
      axios.post('/saveBusiness', this.businessProfileForm, {
        headers: {
          Authorization: `Bearer ${authToken}`
        }
      }).then(response => {
        if (response.data.status) {
          this.businessProfileData = { ...this.businessProfileForm };
          this.editBusinessProfile = false;
        } else {
          alert(response.data.message);
        }
      }).catch(error => {
        console.error('Error saving business profile:', error.message);
      });
    }
  }
};
</script>

<style scoped>
button {
  text-align: center;
}

.paper {
  width: 90%;
  left: 5%;
  position: relative;
}

.marginTop {
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

.row {
  display: flex;
  align-items: center;
  flex-direction: row;
}

.editInput {
  background: var(--color-white);
  border-radius: 1rem;
  padding: 0.5rem;
  max-width: 9rem;
}

.editForm {
  display: flex;
  flex-wrap: wrap;
  gap: 1rem;
  margin-top: 1rem;
}

.editButtons {
  border-radius: 1rem;
}

.edButtons {
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

.textButton {
  color: var(--text-color);
  cursor: pointer; 
  padding: 0.5rem;
  border-radius: 1.5rem;
}

.editButton {
  width: 5rem;
  background: var(--accent-color);
}

.deleteButton {
  width: 5rem;
  background: var(--color-red);
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

.wrapper {
  display: flex;
  align-items: start;
  justify-content: start; 
  flex-direction: column;
}

@media (min-width: 768px) {
  .paper {
    width: 90%;
  }

  .wrapper {
    display: flex;
    align-items: start;
    justify-content: start; 
    flex-direction: row;
    gap: 2%;
  }

  .container {
    min-width: 50%;
  }
}
</style>

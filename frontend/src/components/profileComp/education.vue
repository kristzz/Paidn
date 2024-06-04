<template>
  <div v-if="userType === 'user'">
    <div v-if="educationData && educationData.length > 0">
      <h1>Education Experience</h1>
      <button @click="openAddEducation()">Add Education Experience Information</button>
      <div v-for="educationEntry in educationData" :key="educationEntry.id">
        <p>School: {{ educationForm.educationProvider }}</p>
        <p>Degree: {{ educationForm.levelOfEducation }}</p>
        <p>Field: {{ educationForm.fieldOfStudy }}</p>
        <p v-if="educationEntry.description">Description: {{ educationEntry.description }}</p>
        <p>From: {{ educationEntry.startDate }}</p>
        <p v-if="educationEntry.endDate">To: {{ educationEntry.endDate }}</p>
        <button @click="openEditEducation(educationEntry)">Edit</button>
      </div>
    </div>
    <div v-else-if="educationData && educationData.length === 0">
      <p>No education experience data found. Please add your education experience information.</p>
      <button @click="openAddEducation()">Add Education Experience Information</button>
    </div>
    <div v-else>
      <p>Loading...</p>
    </div>

    <!-- Add Education Experience Modal -->
    <div v-if="showAddEducationModal" class="modal">
      <div class="modal-content">
        <span class="close" @click="closeAddEducationModal">&times;</span>
        <h2>Add Education Experience</h2>
        <form @submit.prevent="addEducationEntry">
          <input type="text" v-model="newEducation.educationProvider" placeholder="School" required />
          <input type="text" v-model="newEducation.levelOfEducation" placeholder="Education level" required />
          <input type="text" v-model="newEducation.fieldOfStudy" placeholder="Field" required />
          <input type="text" v-model="newEducation.description" placeholder="Description" />
          <input type="date" v-model="newEducation.startDate" placeholder="Start Date" required />
          <input type="date" v-model="newEducation.endDate" placeholder="End Date" />
          <button type="submit">Save</button>
          <button @click="closeAddEducationModal">Cancel</button>
        </form>
      </div>
    </div>

    <!-- Edit Education Experience Modal -->
    <div v-if="showEditEducationModal" class="modal">
      <div class="modal-content">
        <span class="close" @click="closeEditEducationModal">&times;</span>
        <h2>Edit Education Experience</h2>
        <form @submit.prevent="updateEducation">
          <input type="text" v-model="educationForm.educationProvider" placeholder="School" required />
          <input type="text" v-model="educationForm.levelOfEducation" placeholder="Education level" required />
          <input type="text" v-model="educationForm.fieldOfStudy" placeholder="Field" required />
          <input type="text" v-model="educationForm.description" placeholder="Description" />
          <input type="date" v-model="educationForm.startDate" placeholder="Start Date" required />
          <input type="date" v-model="educationForm.endDate" placeholder="End Date" />
          <button type="submit">Save</button>
          <button @click="closeEditEducationModal">Cancel</button>
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
      educationData: null,
      showAddEducationModal: false,
      showEditEducationModal: false,
      newEducation: {
        educationProvider: '',
        levelOfEducation: '',
        fieldOfStudy: '',
        description: '',
        startDate: '',
        endDate: ''
      },
      educationForm: {
        educationProvider: '',
        levelOfEducation: '',
        fieldOfStudy: '',
        description: '',
        startDate: '',
        endDate: ''
      }
    };
  },
  mounted() {
    this.fetchEducation(this.authToken);
    this.userType = localStorage.getItem('userType');
  },
  methods: {
    fetchEducation(authToken) {
      axios.get('/getEducation', {
        headers: {
          Authorization: `Bearer ${authToken}`
        }
      }).then((response) => {
        this.educationData = response.data.education || [];
        if (this.educationData.length > 0) {
          this.educationForm = { ...this.educationData[0] };
        }
      }).catch((error) => {
        console.log(error.message);
      });
    },
    addEducationEntry() {
      axios.post('/addEducation', this.newEducation, {
        headers: {
          Authorization: `Bearer ${this.authToken}`
        }
      }).then(response => {
        if (response.data.status) {
          this.educationData.push({ ...this.newEducation });
          this.showAddEducationModal = false;
        } else {
          alert(response.data.message);
        }
      }).catch(error => {
        console.log(error.message);
      });
    },
    updateEducation() {
      axios.post('/editEducation', this.educationForm, {
        headers: {
          Authorization: `Bearer ${this.authToken}`
        }
      }).then(response => {
        if (response.data.status) {
          const index = this.educationData.findIndex(education => education.id === this.educationForm.id);
          if (index !== -1) {
            this.educationData.splice(index, 1, { ...this.educationForm });
          }
          this.showEditEducationModal = false;
        } else {
          alert(response.data.message);
        }
      }).catch(error => {
        console.log(error.message);
      });
    },
    openAddEducation() {
      this.showAddEducationModal = true;
    },
    closeAddEducationModal() {
      this.showAddEducationModal = false;
    },
    openEditEducation(educationEntry) {
      this.educationForm = { ...educationEntry };
      this.showEditEducationModal = true;
    },
    closeEditEducationModal() {
      this.showEditEducationModal = false;
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

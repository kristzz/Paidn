<template>
  <div v-if="userType === 'user'" class="paper">
    <div v-if="educationData && educationData.length > 0">
      <div class="row heading marginTop">
        <h1>Education Experience</h1>
        <button @click="openAddEducation()" class="addButton">+</button>
      </div>
      <div class="wrapper">
        <div v-for="educationEntry in educationData" :key="educationEntry.id" class="container">
          <p><div class="weight-light">School:</div> {{ educationEntry.educationProvider }}</p>
          <p><div class="weight-light">Degree:</div> {{ educationEntry.levelOfEducation }}</p>
          <p><div class="weight-light">Field:</div> {{ educationEntry.fieldOfStudy }}</p>
          <p v-if="educationEntry.description"><div class="weight-light">Description:</div> {{ educationEntry.description }}</p>
          <p><div class="weight-light">From:</div> {{ educationEntry.startDate }}</p>
          <p v-if="educationEntry.endDate"><div class="weight-light">To:</div> {{ educationEntry.endDate }}</p>
          <div class="row edButtons">
            <button class="textButton editButton height-text" @click="openEditEducation(educationEntry)">Edit</button>
            <button class="textButton deleteButton height-text" @click="deleteEducationExperience(educationEntry)">Delete</button>
          </div>
        </div>
      </div>
    </div>
    <div v-else-if="profileData === null">
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
        <form class="editForm" @submit.prevent="addEducationEntry">
          <input class="editInput height-text" type="text" v-model="newEducation.educationProvider" placeholder="School" required />
          <input class="editInput height-text" type="text" v-model="newEducation.levelOfEducation" placeholder="Education level" required />
          <input class="editInput height-text" type="text" v-model="newEducation.fieldOfStudy" placeholder="Field" required />
          <input class="editInput height-text" type="text" v-model="newEducation.description" placeholder="Description" />
          <input class="editInput height-text" type="date" v-model="newEducation.startDate" placeholder="Start Date" required />
          <input class="editInput height-text" type="date" v-model="newEducation.endDate" placeholder="End Date" />
          <div class="row editButtons edButtons">
            <button class="textButton editButton height-text" type="submit">Save</button>
            <button class="textButton deleteButton height-text" @click="closeAddEducationModal">Cancel</button>
          </div>
        </form>
      </div>
    </div>

    <!-- Edit Education Experience Modal -->
    <div v-if="showEditEducationModal" class="modal">
      <div class="modal-content">
        <span class="close" @click="closeEditEducationModal">&times;</span>
        <h2>Edit Education Experience</h2>
        <form class="editForm" @submit.prevent="updateEducation">
          <input class="editInput height-text" type="text" v-model="educationForm.educationProvider" placeholder="School" required />
          <input class="editInput height-text" type="text" v-model="educationForm.levelOfEducation" placeholder="Education level" required />
          <input class="editInput height-text" type="text" v-model="educationForm.fieldOfStudy" placeholder="Field" required />
          <input class="editInput height-text" type="text" v-model="educationForm.description" placeholder="Description" />
          <input class="editInput height-text" type="date" v-model="educationForm.startDate" placeholder="Start Date" required />
          <input class="editInput height-text" type="date" v-model="educationForm.endDate" placeholder="End Date" />
          <div class="row editButtons edButtons">
            <button class="textButton editButton height-text" type="submit">Save</button>
            <button class="textButton deleteButton height-text" @click="closeEditEducationModal">Cancel</button>
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
    deleteEducationExperience(educationEntry) {
      axios.get('/deleteEducation', {
        params: {
          id: educationEntry.id
        },
        headers: {
          Authorization: `Bearer ${this.authToken}`
        }
      }).then(response => {
        if (response.data.status) {
          const index = this.educationData.findIndex(entry => entry.id === educationEntry.id);
          if (index !== -1) {
            this.educationData.splice(index, 1);
          }
        } else {
          alert(response.data.message);
        }
      }).catch(error => {
        console.error('Error deleting education entry:', error);
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
  max-width: 510px;
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

  .wrapper{
    display: flex; 
    flex-direction: row;
    align-items: start;
    flex-wrap: wrap;
    gap: 2%;
  }

  .container{
    width: 49%;
  }

  .heading{
    gap: 1rem;
  }
}
</style>

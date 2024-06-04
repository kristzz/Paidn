<template>
  <div v-if="userType === 'user'">
    <div v-if="workData && workData.length > 0">
      <h1>Work Experience</h1>
      <button @click="openAddWork()">Add Work Experience Information</button>
      <div v-for="workEntry in workData" :key="workEntry.id">
        <p>Company: {{ workEntry.companyName }}</p>
        <p>Position: {{ workEntry.workPositionName }}</p>
        <p v-if="workEntry.description">Description: {{ workEntry.description }}</p>
        <p>From: {{ workEntry.startDate }}</p>
        <p v-if="workEntry.endDate">To: {{ workEntry.endDate }}</p>
        <button @click="openEditWork(workEntry)">Edit</button>
      </div>
    </div>
    <div v-else-if="workData && workData.length === 0">
      <p>No work experience data found. Please add your work experience information.</p>
      <button @click="openAddWork()">Add Work Experience Information</button>
    </div>
    <div v-else>
      <p>Loading...</p>
    </div>

    <!-- Add Work Experience Modal -->
    <div v-if="showAddWorkModal" class="modal">
      <div class="modal-content">
        <span class="close" @click="closeAddWorkModal">&times;</span>
        <h2>Add Work Experience</h2>
        <form @submit.prevent="addWorkEntry">
          <input type="text" v-model="newWork.companyName" placeholder="Company" required />
          <input type="text" v-model="newWork.workPositionName" placeholder="Position" required />
          <input type="text" v-model="newWork.description" placeholder="Description" />
          <input type="date" v-model="newWork.startDate" placeholder="Start Date" required />
          <input type="date" v-model="newWork.endDate" placeholder="End Date" />
          <button type="submit">Save</button>
          <button @click="closeAddWorkModal">Cancel</button>
        </form>
      </div>
    </div>

    <!-- Edit Work Experience Modal -->
    <div v-if="showEditWorkModal" class="modal">
      <div class="modal-content">
        <span class="close" @click="closeEditWorkModal">&times;</span>
        <h2>Edit Work Experience</h2>
        <form @submit.prevent="updateWork">
          <input type="text" v-model="workForm.companyName" placeholder="Company" required />
          <input type="text" v-model="workForm.workPositionName" placeholder="Position" required />
          <input type="text" v-model="workForm.description" placeholder="Description" />
          <input type="date" v-model="workForm.startDate" placeholder="Start Date" required />
          <input type="date" v-model="workForm.endDate" placeholder="End Date" />
          <button type="submit">Save</button>
          <button @click="closeEditWorkModal">Cancel</button>
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
      workData: null,
      showAddWorkModal: false,
      showEditWorkModal: false,
      newWork: {
        companyName: '',
        workPositionName: '',
        description: '',
        startDate: '',
        endDate: ''
      },
      workForm: {
        companyName: '',
        workPositionName: '',
        description: '',
        startDate: '',
        endDate: ''
      }
    };
  },
  mounted() {
    this.fetchWork(this.authToken);
    this.userType = localStorage.getItem('userType');
  },
  methods: {
    fetchWork(authToken) {
      axios.get('/getWork', {
        headers: {
          Authorization: `Bearer ${authToken}`
        }
      }).then((response) => {
        this.workData = response.data.work || [];
      }).catch((error) => {
        console.log(error.message);
      });
    },
    addWorkEntry() {
      axios.post('/addWork', this.newWork, {
        headers: {
          Authorization: `Bearer ${this.authToken}`
        }
      }).then(response => {
        if (response.data.status) {
          this.workData.push({ ...this.newWork });
          this.showAddWorkModal = false;
        } else {
          alert(response.data.message);
        }
      }).catch(error => {
        console.log(error.message);
      });
    },
    updateWork() {
      axios.post('/editWork', this.workForm, {
        headers: {
          Authorization: `Bearer ${this.authToken}`
        }
      }).then(response => {
        if (response.data.status) {
          const index = this.workData.findIndex(work => work.id === this.workForm.id);
          if (index !== -1) {
            this.workData.splice(index, 1, { ...this.workForm });
          }
          this.showEditWorkModal = false;
        } else {
          alert(response.data.message);
        }
      }).catch(error => {
        console.log(error.message);
      });
    },
    openAddWork() {
      this.showAddWorkModal = true;
    },
    closeAddWorkModal() {
      this.showAddWorkModal = false;
    },
    openEditWork(workEntry) {
      this.workForm = { ...workEntry };
      this.showEditWorkModal = true;
    },
    closeEditWorkModal() {
      this.showEditWorkModal = false;
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

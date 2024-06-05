<template >
  <div v-if="userType === 'user'" class="paper">
    <div v-if="workData && workData.length > 0">
      <div>
        <div class="row heading marginTop">
          <h1>Work Experience</h1>
          <button @click="openAddWork()" class="addButton">+</button>
        </div>
        <div class="wrapper">  
          <div v-for="workEntry in workData" :key="workEntry.id" class="container">
            <p><div class="weight-light">Company:</div> {{ workEntry.companyName }}</p>
            <p><div class="weight-light">Position:</div> {{ workEntry.workPositionName }}</p>
            <p v-if="workEntry.description"><div class="weight-light">Description:</div> {{ workEntry.description }}</p>
            <p><div class="weight-light">From: </div>{{ workEntry.startDate }}</p>
            <p v-if="workEntry.endDate"><div class="weight-light">To:</div> {{ workEntry.endDate }}</p>
            <div class="row edButtons">
              <button class="textButton editButton height-text" @click="openEditWork(workEntry)">Edit</button>
              <button class="textButton deleteButton height-text" @click="deleteWorkExperience(workEntry)">Delete</button>
            </div>
          </div>
        </div>
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
        <form class="editForm" @submit.prevent="addWorkEntry">
          <input class="editInput height-text" type="text" v-model="newWork.companyName" placeholder="Company" required />
          <input class="editInput height-text" type="text" v-model="newWork.workPositionName" placeholder="Position" required />
          <input class="editInput height-text" type="text" v-model="newWork.fieldOfWork" placeholder="Field" required />
          <input class="editInput height-text" type="text" v-model="newWork.description" placeholder="Description" />
          <input class="editInput height-text" type="date" v-model="newWork.startDate" placeholder="Start Date" required />
          <input class="editInput height-text" type="date" v-model="newWork.endDate" placeholder="End Date" />
          <div class="row editButtons edButtons">
            <button class="textButton editButton height-text" type="submit">Save</button>
            <button class="textButton deleteButton height-text" @click="closeAddWorkModal">Cancel</button>
          </div>
        </form>
      </div>
    </div>

    <!-- Edit Work Experience Modal -->
    <div v-if="showEditWorkModal" class="modal">
      <div class="modal-content">
        <span class="close" @click="closeEditWorkModal">&times;</span>
        <h2>Edit Work Experience</h2>
        <form class="editForm" @submit.prevent="updateWork">
          <input class="editInput height-text" type="text" v-model="workForm.companyName" placeholder="Company" required />
          <input class="editInput height-text" type="text" v-model="workForm.workPositionName" placeholder="Position" required />
          <input class="editInput height-text" type="text" v-model="workForm.fieldOfWork" placeholder="Field" required />
          <input class="editInput height-text" type="text" v-model="workForm.description" placeholder="Description" />
          <input class="editInput height-text" type="date" v-model="workForm.startDate" placeholder="Start Date" required />
          <input class="editInput height-text" type="date" v-model="workForm.endDate" placeholder="End Date" />
          <div class="row editButtons edButtons">
            <button class="textButton editButton height-text" type="submit">Save</button>
            <button class="textButton deleteButton height-text" @click="closeEditWorkModal">Cancel</button>
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
      workData: null,
      showAddWorkModal: false,
      showEditWorkModal: false,
      newWork: {
        companyName: '',
        workPositionName: '',
        fieldOfWork: '',
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
    deleteWorkExperience(workEntry) {
      axios.get('/deleteWork', {
        params: {
          id: workEntry.id
        },
        headers: {
          Authorization: `Bearer ${this.authToken}`
        }
       })
        .then(response => {
          if (response.data.status) {
            const index = this.workData.findIndex(entry => entry.id === workEntry.id);
            if (index !== -1) {
              this.workData.splice(index, 1);
            }
          } else {
            alert(response.data.message);
          }
        })
        .catch(error => {
          console.error('Error deleting work entry:', error);
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

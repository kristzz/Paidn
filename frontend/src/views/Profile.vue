<template>
    <main>
      <div v-if="userType === 'user'">
        <!-- User profile and details -->
        <div class="fetchFields">
          <!-- Profile Section -->
          <div v-if="profileData">
            <h1>Profile</h1>
            <p>Name: {{ profileData.name }}</p>
            <p v-if="profileData.secondName">Second name: {{ profileData.secondName }}</p>
            <p>Surname: {{ profileData.surname }}</p>
            <p>Age: {{ profileData.age }}</p>
            <p>Gender: {{ profileData.gender }}</p>
            <button @click="editProfile = true">Edit Profile</button>
          </div>
          <div v-else-if="profileData === null">
            <p>No profile data found. Please add your profile information.</p>
            <button @click="editProfile = true">Add Profile Information</button>
          </div>
          <div v-else>
            <p>Loading...</p>
          </div>
  
          <div v-if="editProfile">
            <h2>Edit Profile</h2>
            <form @submit.prevent="updateProfile">
              <input type="text" v-model="profileForm.name" placeholder="Name" required />
              <input type="text" v-model="profileForm.secondName" placeholder="Second Name" />
              <input type="text" v-model="profileForm.surname" placeholder="Surname" />
              <input type="number" v-model="profileForm.age" placeholder="Age" required />
              <input type="text" v-model="profileForm.nationality" placeholder="Nationality" required />
              <select v-model="profileForm.gender" required>
                <option value="" disabled>Select Gender</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="other">Other</option>
              </select>
              <button type="submit">Save</button>
              <button @click="editProfile = false">Cancel</button>
            </form>
          </div>
        </div>
  
        <!-- Education Section -->
        <div class="fetchFields">
          <div v-if="educationData && educationData.length > 0">
            <h1>Education</h1>
            <button @click="addEducation = true">Add education</button>
            <div v-for="educationEntry in educationData" :key="educationEntry.id">
              <p>Provider: {{ educationEntry.educationProvider }}</p>
              <p>Education level: {{ educationEntry.levelOfEducation }}</p>
              <p>Field of study: {{ educationEntry.fieldOfStudy }}</p>
              <p v-if="educationEntry.description">Description: {{ educationEntry.description }}</p>
              <p>From: {{ educationEntry.startDate }}</p>
              <p v-if="educationEntry.endDate">To: {{ educationEntry.endDate }}</p>
              <br>
            </div>
            <button @click="editEducation = true">Edit Education</button>
          </div>
          <div v-else-if="educationData && educationData.length === 0">
            <p>No education data found. Please add your education information.</p>
            <button @click="addEducation = true">Add Education Information</button>
          </div>
          <div v-else>
            <p>Loading...</p>
          </div>
  
          <div v-if="addEducation">
            <h1>Add Education</h1>
            <form @submit.prevent="addEducationEntry">
              <label>Provider: <input v-model="newEducation.educationProvider" required></label>
              <label>Education level: <input v-model="newEducation.levelOfEducation" required></label>
              <label>Field of study: <input v-model="newEducation.fieldOfStudy" required></label>
              <label>Description: <input v-model="newEducation.description"></label>
              <label>From: <input v-model="newEducation.startDate" required></label>
              <label>To: <input v-model="newEducation.endDate" required></label>
              <button type="submit">Submit</button>
            </form>
          </div>
  
          <div v-if="editEducation">
            <h2>Edit Education</h2>
            <form @submit.prevent="updateEducation">
              <input type="text" v-model="educationForm.educationProvider" placeholder="Education Provider" required />
              <input type="text" v-model="educationForm.levelOfEducation" placeholder="Level of Education" required />
              <input type="text" v-model="educationForm.fieldOfStudy" placeholder="Field of Study" required />
              <input type="text" v-model="educationForm.description" placeholder="Description" />
              <input type="date" v-model="educationForm.startDate" placeholder="Start Date" required />
              <input type="date" v-model="educationForm.endDate" placeholder="End Date" />
              <button type="submit">Save</button>
              <button @click="editEducation = false">Cancel</button>
            </form>
          </div>
        </div>
  
        <!-- Work Experience Section -->
        <div class="fetchFields">
          <div v-if="workData && workData.length > 0">
            <h1>Work Experience</h1>
            <button @click="addWork = true">Add Work Experience Information</button>
            <div v-for="workEntry in workData" :key="workEntry.id">
              <p>Company: {{ workEntry.companyName }}</p>
              <p>Position: {{ workEntry.workPositionName }}</p>
              <p v-if="workEntry.description">Description: {{ workEntry.description }}</p>
              <p>From: {{ workEntry.startDate }}</p>
              <p v-if="workEntry.endDate">To: {{ workEntry.endDate }}</p>
            </div>
            <button @click="editWork = true">Edit Work Experience</button>
          </div>
          <div v-else-if="workData && workData.length === 0">
            <p>No work experience data found. Please add your work experience information.</p>
            <button @click="addWork = true">Add Work Experience Information</button>
          </div>
          <div v-else>
            <p>Loading...</p>
          </div>
  
          <div v-if="addWork">
            <h1>Add Work</h1>
            <form @submit.prevent="addWorkEntry">
              <label>Company Name: <input v-model="newWork.companyName" required></label>
              <label>Work Position Name: <input v-model="newWork.workPositionName" required></label>
              <label>Field of Work: <input v-model="newWork.fieldOfWork" required></label>
              <label>Description: <input v-model="newWork.description"></label>
              <label>Start Date: <input type="date" v-model="newWork.startDate" required></label>
              <label>End Date: <input type="date" v-model="newWork.endDate" required></label>
              <button type="submit">Submit</button>
            </form>
          </div>
  
          <div v-if="editWork">
            <h2>Edit Work Experience</h2>
            <form @submit.prevent="updateWork">
              <input type="text" v-model="workForm.companyName" placeholder="Company Name" required />
              <input type="text" v-model="workForm.workPositionName" placeholder="Work Position Name" required />
              <input type="text" v-model="workForm.fieldOfWork" placeholder="Field of work" required />
              <input type="text" v-model="workForm.description" placeholder="Description" />
              <input type="date" v-model="workForm.startDate" placeholder="Start Date" required />
              <input type="date" v-model="workForm.endDate" placeholder="End Date" />
              <button type="submit">Save</button>
              <button @click="editWork = false">Cancel</button>
            </form>
          </div>
        </div>
      </div>
  
      <div v-if="userType === 'business'">
      <div class="fetchFields">
        <div v-if="businessData">
          <h1>Business Profile</h1>
          <p>Business Name: {{ businessData.businessName }}</p>
          <p>Business Type: {{ businessData.businessType }}</p>
          <p>Business Description: {{ businessData.businessDescription }}</p>
          <p>Business Address: {{ businessData.businessAddress }}</p>
          <button @click="editBusinessProfile = true">Edit Business Profile</button>
        </div>
        <div v-else>
          <p>Loading...</p>
        </div>

        <div v-if="editBusinessProfile">
          <h2>Edit Business Profile</h2>
          <form @submit.prevent="saveBusinessProfile">
            <input type="text" v-model="businessProfileForm.businessName" placeholder="Business Name" required />
            <input type="text" v-model="businessProfileForm.businessType" placeholder="Business Type" required />
            <input type="text" v-model="businessProfileForm.businessDescription" placeholder="Business Description" required />
            <input type="text" v-model="businessProfileForm.businessAddress" placeholder="Business Address" required />
            <button type="submit">Save</button>
            <button @click="editBusinessProfile = false">Cancel</button>
          </form>
        </div>
      </div>
    </div>
  </main>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      userType: '',
      profileData: null,
      educationData: null,
      workData: null,
      businessData: null,
      editProfile: false,
      editEducation: false,
      editWork: false,
      addEducation: false,
      addWork: false,
      editBusinessProfile: false,
      profileForm: {
        name: '',
        secondName: '',
        surname: '',
        age: '',
        nationality: '',
        gender: ''
      },
      educationForm: {
        educationProvider: '',
        levelOfEducation: '',
        fieldOfStudy: '',
        description: '',
        startDate: '',
        endDate: ''
      },
      newEducation: {
        educationProvider: '',
        levelOfEducation: '',
        fieldOfStudy: '',
        description: '',
        startDate: '',
        endDate: '',
      },
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
      },
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
      this.fetchProfile(authToken);
      this.fetchEducation(authToken);
      this.fetchWork(authToken);
      this.fetchBusinessProfile(authToken);
    } else {
      alert('You are not logged in');
      this.$router.push('/login');
    }
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
    fetchWork(authToken) {
      axios.get('/getWork', {
        headers: {
          Authorization: `Bearer ${authToken}`
        }
      }).then((response) => {
        this.workData = response.data.work || [];
        if (this.workData.length > 0) {
          this.workForm = { ...this.workData[0] };
        }
      }).catch((error) => {
        console.log(error.message);
      });
    },
    updateProfile() {
      const authToken = localStorage.getItem('authToken');
      axios.post('/editRegularUser', this.profileForm, {
        headers: {
          Authorization: `Bearer ${authToken}`
        }
      }).then(response => {
        if (response.data.status) {
          this.profileData = { ...this.profileForm };
          this.editProfile = false;
        } else {
          alert(response.data.message);
        }
      }).catch(error => {
        console.log(error.message);
      });
    },
    updateEducation() {
      const authToken = localStorage.getItem('authToken');
      axios.post('/editEducation', this.educationForm, {
        headers: {
          Authorization: `Bearer ${authToken}`
        }
      }).then(response => {
        if (response.data.status) {
          this.educationData.push({ ...this.educationForm });
          this.editEducation = false;
        } else {
          alert(response.data.message);
        }
      }).catch(error => {
        console.log(error.message);
      });
    },
    updateWork() {
      const authToken = localStorage.getItem('authToken');
      axios.post('/editWork', this.workForm, {
        headers: {
          Authorization: `Bearer ${authToken}`
        }
      }).then(response => {
        if (response.data.status) {
          this.workData.push({ ...this.workForm });
          this.editWork = false;
        } else {
          alert(response.data.message);
        }
      }).catch(error => {
        console.log(error.message);
      });
    },
    addEducationEntry() {
      const authToken = localStorage.getItem('authToken');
      axios.post('/addEducation/', this.newEducation, {
        headers: {
          Authorization: `Bearer ${authToken}`
        }
      }).then(response => {
        if (response.data.status) {
          this.educationData.push({ ...this.newEducation });
          this.addEducation = false;
        } else {
          alert(response.data.message);
        }
      }).catch(error => {
        console.log(error.message);
      });
    },
    addWorkEntry() {
      const authToken = localStorage.getItem('authToken');
      axios.post('/addWork/', this.newWork, {
        headers: {
          Authorization: `Bearer ${authToken}`
        }
      }).then(response => {
        if (response.data.status) {
          this.workData.push({ ...this.newWork });
          this.addWork = false;
        } else {
          alert(response.data.message);
        }
      }).catch(error => {
        console.log(error.message);
      });
    },
    fetchBusinessProfile(authToken) {
      axios.get('/getBusinessProfile', {
        headers: {
          Authorization: `Bearer ${authToken}`
        }
      })
      .then(response => {
        if (response.data.status) {
          this.businessData = response.data.businessData;
        } else {
          this.error = 'Failed to load business profile';
        }
      })
      .catch(error => {
        this.error = 'An error occurred: ' + error.message;
      });
    },
    saveBusinessProfile() {
      const authToken = localStorage.getItem('authToken');
      axios.post('/saveBusiness', this.businessProfileForm, {
        headers: {
          Authorization: `Bearer ${authToken}`
        }
      })
      .then(response => {
        if (response.data.status) {
          this.editBusinessProfile = false;
          this.fetchBusinessProfile(authToken);
        } else {
          this.error = 'Failed to update business profile';
        }
      })
      .catch(error => {
        this.error = 'An error occurred: ' + error.message;
      });
    }
  }
};
</script>

<style scoped>
main {
  display: flex;
  justify-content: center;
  align-items: center;
  flex-direction: column;
  height: 100vh;
}

p {
  border-bottom: solid 1px rgba(0, 0, 0, 0.7);
}

.fetchFields {
  width: 60vw;
  background-color: cadetblue;
}

.row {
  display: flex;
  flex-direction: row;
}
</style>
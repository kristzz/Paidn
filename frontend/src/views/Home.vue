<template>
  <div>
    <div v-if="userType === 'user' && allPosts.length > 0" class="paper">
      <h2 class="marginTop">All Posts</h2>
      <form class="filter-form" @submit.prevent="applyFilters">
        <input type="text" v-model="filters.search" placeholder="Search..." class="filter-input">
        <select v-model="filters.sortKey" class="filter-input">
          <option value="title">Title</option>
          <option value="salaryRangeLowest">Salary</option>
        </select>
        <select v-model="filters.sortOrder" class="filter-input">
          <option value="asc">Ascending</option>
          <option value="desc">Descending</option>
        </select>
        <input type="number" v-model="filters.minSalary" placeholder="Min Salary" class="filter-input">
        <input type="number" v-model="filters.maxSalary" placeholder="Max Salary" class="filter-input">
        <button type="submit" class="filter-button">Apply</button>
      </form>
      <div class="wrapper">
        <div v-for="post in filteredPosts" :key="post.id" class="container">
          <p>{{ post.title }}</p>
          <p><span class="weight-light">Profession:</span> {{ post.profession }}</p>
          <p><span class="weight-light">Country:</span> {{ post.country }}</p>
          <p><span class="weight-light">Location:</span> {{ post.location }}</p>
          <p><span class="weight-light">Description:</span> {{ post.jobDesc }}</p>
          <p><span class="weight-light">Salary range:</span> {{ post.salaryRangeLowest }}$ - {{ post.salaryRangeHighest }}$</p>
          <button class="textButton applyButton height-text" @click="applyForJob(post.id)">Apply to the job</button>
        </div>
      </div>
    </div>
    <div v-if="userType === 'business'" class="paper">
      <div class="row heading marginTop">
          <h1>Your posts</h1>
          <button @click="openPostForm()" class="addButton">+</button>
        </div>
      <div class="wrapper">
        <div v-for="post in myPosts" :key="post.id" class="container">
          <p>{{ post.title }}</p>
          <p><span class="weight-light">Profession:</span> {{ post.profession }}</p>
          <p><span class="weight-light">Country:</span> {{ post.country }}</p>
          <p><span class="weight-light">Location:</span> {{ post.location }}</p>
          <p><span class="weight-light">Description:</span> {{ post.jobDesc }}</p>
          <p><span class="weight-light">Salary range:</span> {{ post.salaryRangeLowest }}$ - {{ post.salaryRangeHighest }}$</p>
          <div class="row">
            <div class="edButtons row">
              <button class="textButton editButton height-text" @click="openPostForm(post)">Edit</button>
              <button class="textButton deleteButton height-text" @click="deletePost(post.id)">Delete</button>
              <button class="textButton viewButton height-text" @click="showApplications(post.id)">Show Applicants</button>
            </div>
          </div>
          
        </div>
      </div>
      <div v-if="showPostForm" class="modal">
        <div class="modal-content">
          <span class="close" @click="cancelEdit">&times;</span>
          <h2>{{ editingPost ? 'Edit Post' : 'Add Post' }}</h2>
          <form @submit.prevent="savePost" class="editForm">
            <input class="editInput height-text" v-model="newPost.title" placeholder="Title" required>
            <input class="editInput height-text" v-model="newPost.profession" placeholder="Profession" required>
            <input class="editInput height-text" v-model="newPost.jobDesc" placeholder="Description" required></input>
            <input class="editInput height-text" v-model="newPost.country" placeholder="Country" required>
            <select class="editInput height-text" v-model="newPost.location" required>
              <option value="" disabled>Select Location</option>
              <option value="On-site">On-site</option>
              <option value="Hybrid">Hybrid</option>
              <option value="Remote">Remote</option>
            </select>
            <input class="editInput height-text" type="number" v-model="newPost.salaryRangeLowest" placeholder="Salary Lowest" required>
            <input class="editInput height-text" type="number" v-model="newPost.salaryRangeHighest" placeholder="Salary Highest" required>
            <div class="row editButtons edButtons">
              <button class="textButton editButton height-text" type="submit">{{ editingPost ? 'Save' : 'Add' }}</button>
              <button class="textButton deleteButton height-text" @click="cancelEdit">Cancel</button>
            </div>
          </form>
        </div>
      </div>
      <div v-if="showApplicationsModal" class="modal">
        <div class="modal-content">
          <span class="close" @click="closeApplicationsModal">&times;</span>
          <h2>Applications for Post {{ currentPostId }}: total = {{ applicationCount }}</h2>
          <div v-for="application in applications" :key="application.id">
            <p><span class="weight-light">Email:</span> {{ application.user.email }}</p>
            <p><span class="weight-light">Resume:</span> <a :href="application.resumeLink" target="_blank">View Resume</a></p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>



<script>
import axios from 'axios';

export default {
  data() {
    return {
      allPosts: [],
      myPosts: [],
      userType: '',
      showPostForm: false,
      newPost: {
        id: null,
        title: '',
        jobDesc: '',
        profession: '',
        country: '',
        location: '',
        salaryRangeLowest: '',
        salaryRangeHighest: ''
      },
      editingPost: null,
      applications: [],
      showApplicationsModal: false,
      currentPostId: null,
      applicationCount: 0,
      filters: {
        search: '',
        sortKey: 'title',
        sortOrder: 'asc',
        minSalary: 0,
        maxSalary: 100000000
      }
    };
  },
  computed: {
    filteredPosts() {
      let posts = this.allPosts;
      if (this.filters.search) {
        const search = this.filters.search.toLowerCase();
        posts = posts.filter(post =>
          post.title.toLowerCase().includes(search) ||
          post.profession.toLowerCase().includes(search) ||
          post.country.toLowerCase().includes(search) ||
          post.location.toLowerCase().includes(search) ||
          post.jobDesc.toLowerCase().includes(search)
        );
      }
      if (this.filters.minSalary) {
        posts = posts.filter(post => post.salaryRangeLowest >= this.filters.minSalary);
      }
      if (this.filters.maxSalary) {
        posts = posts.filter(post => post.salaryRangeHighest <= this.filters.maxSalary);
      }
      posts = posts.sort((a, b) => {
        let modifier = 1;
        if (this.filters.sortOrder === 'desc') modifier = -1;
        if (a[this.filters.sortKey] < b[this.filters.sortKey]) return -1 * modifier;
        if (a[this.filters.sortKey] > b[this.filters.sortKey]) return 1 * modifier;
        return 0;
      });
      return posts;
    }
  },
  methods: {
    fetchPosts() {
      const authToken = localStorage.getItem('authToken');
      axios.get('/getPosts', {
        headers: {
          Authorization: `Bearer ${authToken}`
        }
      }).then(response => {
        if (response.data.status) {
          this.allPosts = response.data.posts;
          this.userType = response.data.userType;
          console.log("Fetched all posts: ", this.allPosts);
        }
      }).catch(error => {
        console.error("Error fetching all posts: ", error);
      });
    },
    fetchMyPosts() {
      const authToken = localStorage.getItem('authToken');
      axios.get('/getMyPosts', {
        headers: {
          Authorization: `Bearer ${authToken}`
        }
      }).then(response => {
        if (response.data.status) {
          this.myPosts = response.data.posts;
          this.userType = response.data.userType;
          console.log("Fetched my posts: ", this.myPosts);
        }
      }).catch(error => {
        console.error("Error fetching my posts: ", error);
      });
    },
    applyFilters() {
      this.fetchPosts();
    },
    createPost() {
      const authToken = localStorage.getItem('authToken');
      axios.post('/post', this.newPost, {
        headers: {
          Authorization: `Bearer ${authToken}`
        }
      }).then(response => {
        if (response.data.status) {
          this.fetchPosts();
          this.resetPostForm();
        } else {
          alert(response.data.message);
        }
      }).catch(error => {
        console.error('Error creating post:', error);
      });
    },
    openPostForm(post) {
      if (post) {
        this.editingPost = post;
        this.newPost = { ...post };
      } else {
        this.editingPost = null;
        this.resetPostForm();
      }
      this.showPostForm = true;
    },
    savePost() {
      if (this.editingPost) {
        this.updatePost();
      } else {
        this.createPost();
      }
    },
    updatePost() {
      const authToken = localStorage.getItem('authToken');
      axios.put(`/updatePost?id=${this.newPost.id}`, this.newPost, {
        headers: {
          Authorization: `Bearer ${authToken}`
        }
      }).then(response => {
        if (response.data.status) {
          this.fetchPosts();
          this.resetPostForm();
        } else {
          alert(response.data.message);
        }
      }).catch(error => {
        console.error('Error updating post:', error);
      });
    },
    deletePost(postId) {
      const authToken = localStorage.getItem('authToken');
      axios.delete(`/deletePost?id=${postId}`, {
        headers: {
          Authorization: `Bearer ${authToken}`
        }
      }).then(response => {
        if (response.data.status) {
          this.fetchPosts();
          location.reload();
        } else {
          alert(response.data.message);
        }
      });
    },
    showApplications(postId) {
      const authToken = localStorage.getItem('authToken');
      axios.get('/getApplications', {
        headers: {
          Authorization: `Bearer ${authToken}`
        },
        params: {
          post_id: postId
        }
      }).then(response => {
        if (response.data.status) {
          this.applications = response.data.applications;
          this.currentPostId = postId;
          this.showApplicationsModal = true;
          this.applicationCount = response.data.applications.length; 
        } else {
          alert(response.data.message);
        }
      }).catch(error => {
        console.error('Error fetching applications:', error);
      });
    },
    closeApplicationsModal() {
      this.showApplicationsModal = false;
      this.applications = [];
    },
    cancelEdit() {
      this.resetPostForm();
    },
    resetPostForm() {
      this.showPostForm = false;
      this.editingPost = null;
      this.newPost = {
        id: null,
        title: '',
        jobDesc: '',
        profession: '',
        country: '',
        location: '',
        salaryRangeLowest: '',
        salaryRangeHighest: ''
      };
    },
    applyForJob(postId) {
      const authToken = localStorage.getItem('authToken');
      axios.post('/applyForJob', { post_id: postId }, {
        headers: {
          Authorization: `Bearer ${authToken}`
        }
      }).then(response => {
        if (response.data.status) {
          alert(response.data.message);
        } else {
          alert(response.data.message);
        }
      });
    }
  },
  mounted() {
    this.fetchPosts();
    this.fetchMyPosts();
  }
};
</script>



<style scoped>
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
  max-width: 510px;
  margin: auto;
  border-radius: 10px;
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
  width: 15%;
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
  border-radius: 10px;
}

.addButton {
  border-radius: 50%;
  height: 2rem;
  width: 2rem;
  background: var(--accent-color);
  color: var(--color-white);
  cursor: pointer;
  font-size: 1.325rem;
}

.addButton:hover {
  background: var(--accent-color);
}

.addWorkButton {
  background: var(--accent-color);
  color: var(--color-white);
  padding: 0.5rem 1rem;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  font-size: 1rem;
}

.addWorkButton:hover {
  background: var(--accent-hover);
}

.textButton {
  color: var(--text-color);
  background: var(--accent-color);
  cursor: pointer;
  padding: 0.5rem;
  border-radius: 1.5rem;
  border: none;
  min-width: 4rem;
}

.editButton {
  background: var(--accent-color);
  color: var(--color-white);
}

.cancelButton {
  background: var(--color-gray);
  color: var(--color-white);
}

.deleteButton {
  background: var(--color-red);
  color: var(--color-white);
}

.viewButton {
  display: flex;
  flex-direction: row;
  align-items: center;
  min-width: 8rem; 
  white-space: nowrap; 
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

.container p {
  text-align: left;
}

.wrapper {
  display: flex;
  align-items: start;
  justify-content: start;
  flex-direction: column;
}

.filter-form {
  display: flex;
  flex-wrap: wrap;
  gap: 1rem;
  margin-bottom: 1rem;
}

.filter-input {
  background: var(--color-white);
  border-radius: 1rem;
  padding: 0.5rem;
}

.filter-button {
  background: var(--accent-color);
  color: var(--color-white);
  padding: 0.5rem 1rem;
  border: none;
  border-radius: 1rem;
  cursor: pointer;
}

@media (min-width: 768px) {
  .addButton {
    width: 2rem;
    height: 2rem;
    font-size: 1.325rem;
  }

  .paper {
    width: 60%;
    left: 20%;
    position: relative;
  }

  .wrapper {
    display: flex;
    flex-direction: row;
    align-items: start;
    flex-wrap: wrap;
    gap: 2%;
  }

  .container {
    min-width: 50%;
  }

  .heading {
    gap: 1rem;
  }
}
</style>

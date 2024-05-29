<template>
  <div>
    <div v-if="userType === 'user' && allPosts.length > 0">
      <h2>All Posts</h2>
      <div v-for="post in allPosts" :key="post.id">
        <p>Title: {{ post.title }}</p>
        <p>Profession: {{ post.profession }}</p>
        <p>Country: {{ post.country }}</p>
        <p>Location: {{ post.location }}</p>
        <p>Description: {{ post.jobDesc }}</p>
        <p>Salary range: {{ post.salaryRangeLowest }}$ - {{ post.salaryRangeHighest }}$</p>
        <br>
      </div>
    </div>
    <div v-if="userType === 'business'">
      <h2>My Posts</h2>
      <button @click="openPostForm()">Add Post</button>
      <div v-for="post in myPosts" :key="post.id">
        <p>Title: {{ post.title }}</p>
        <p>Profession: {{ post.profession }}</p>
        <p>Country: {{ post.country }}</p>
        <p>Location: {{ post.location }}</p>
        <p>Description: {{ post.jobDesc }}</p>
        <p>Salary range: {{ post.salaryRangeLowest }}$ - {{ post.salaryRangeHighest }}$</p>
        <button @click="openPostForm(post)">Edit</button>
        <button @click="deletePost(post.id)">Delete</button>
        <br>
      </div>
      <div v-if="showPostForm">
        <h2>{{ editingPost ? 'Edit Post' : 'Add Post' }}</h2>
        <form @submit.prevent="savePost">
          <label>Title: <input v-model="newPost.title" required></label>
          <label>Profession: <input v-model="newPost.profession" required></label>
          <label>Description: <textarea v-model="newPost.jobDesc" required></textarea></label>
          <label>Country: <input v-model="newPost.country" required></label>
          <select v-model="newPost.location" required>
            <option value="" disabled>Select Location</option>
            <option value="On-site">On-site</option>
            <option value="Hybrid">Hybrid</option>
            <option value="Remote">Remote</option>
          </select>
          <label>Salary Range Lowest: <input type="number" v-model="newPost.salaryRangeLowest" required></label>
          <label>Salary Range Highest: <input type="number" v-model="newPost.salaryRangeHighest" required></label>
          <button type="submit">{{ editingPost ? 'Save' : 'Add' }}</button>
          <button @click="cancelEdit">Cancel</button>
        </form>
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
      editingPost: null
    };
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
      });
    },
    openPostForm(post = null) {
      if (post) {
        this.editingPost = post;
        this.newPost = { ...post };
      } else {
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
      axios.post('/editPosts', this.newPost, {
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
        } else {
          alert(response.data.message);
        }
      });
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
    }
  },
  mounted() {
    this.fetchPosts();
    this.fetchMyPosts();
  }
};
</script>
<template>
  <div>
    <div v-if="userType === 'user' && allPosts.length > 0">
      <h2>All Posts</h2>
      <div v-for="post in allPosts" :key="post.id">
        <p>Title: {{ post.title }}</p>
        <p>Profession: {{ post.profession }}</p>
        <p>Description: {{ post.jobDesc }}</p>
        <p>Salary range: {{ post.salaryRangeLowest }}$ - {{ post.salaryRangeHighest }}$</p>
        <br>
      </div>
    </div>
    <div v-if="userType === 'business' && myPosts.length > 0">
      <h2>My Posts</h2>
      <div v-for="post in myPosts" :key="post.id">
        <p>Title: {{ post.title }}</p>
        <p>Profession: {{ post.profession }}</p>
        <p>Description: {{ post.jobDesc }}</p>
        <p>Salary range: {{ post.salaryRangeLowest }}$ - {{ post.salaryRangeHighest }}$</p>
        <button @click="editPost(post)">Edit</button>
        <button @click="deletePost(post.id)">Delete</button>
        <br>
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
      userType: ''
    };
  },
  mounted() {
    const authToken = localStorage.getItem('authToken');
    if (authToken) {
      this.fetchPosts(authToken);
      this.fetchMyPosts(authToken);
    } else {
      alert('You are not logged in');
      this.$router.push('/login');
    }
  },
  methods: {
    fetchPosts(authToken) {
      axios.get('/getPosts', {
        headers: {
          Authorization: `Bearer ${authToken}`
        }
      }).then((response) => {
        this.allPosts = response.data.posts;
        this.userType = response.data.userType;
        if (this.userType === 'business') {
          this.fetchMyPosts(authToken);
        }
      }).catch((error) => {
        console.log(error.message);
      });
    },
    fetchMyPosts(authToken) {
      axios.get('/getMyPosts', {
        headers: {
          Authorization: `Bearer ${authToken}`
        }
      }).then((response) => {
        this.myPosts = response.data.posts;
      }).catch((error) => {
        console.log(error.message);
      });
    },
    editPost(post) {
      console.log('Editing post:', post);
    },
    deletePost(postId) {
      axios.delete(`/deletePost/${postId}`, {
        headers: {
          Authorization: `Bearer ${authToken}`
        }
      }).then((response) => {
        this.myPosts = this.myPosts.filter(post => post.id !== postId);
        console.log('Post deleted:', response.data.message);
      }).catch((error) => {
        console.log(error.message);
      });
    }
  }
}
</script>

<style>

</style>
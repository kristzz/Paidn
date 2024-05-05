<template>
   <div v-if="allPosts && allPosts.length > 0">
    <div v-for="post in allPosts" :key="post.id">
      <p>Title: {{ post.title }}</p>
      <p>Profession: {{ post.profession }}</p>
      <p>Description: {{ post.jobDesc }}</p>
      <p>Salary range : {{ post.salaryRangeLowest }}$ - {{ post.salaryRangeHighest }}$</p>
      <br>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data(){
    return{
      allPosts : []
    };
  },
  mounted(){
    const authToken = localStorage.getItem('authToken');
    if(authToken) {
      this.fetchPosts(authToken);
    }else {
      alert('You are not logged in');
      this.$router.push('/login');
    }
  },
  methods: {
    fetchPosts(authToken){
      axios.get('/getPosts', {
        headers: {
          Authorization: `Bearer ${authToken}`
        }
      }).then((response) => {
        this.allPosts = response.data.posts;
      }).catch((error) => {
        console.log(error.message);
      });
    }
  }
}
</script>

<style>

</style>
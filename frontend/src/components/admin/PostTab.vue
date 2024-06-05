<template>
    <div>
      <h2>Posts</h2>
      <table>
        <thead>
          <tr>
            <th>Title</th>
            <th>Job Description</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="post in posts" :key="post.id">
            <td>{{ post.title }}</td>
            <td>{{ post.jobDesc }}</td>
            <td>
              <button class="textButton deleteButton height-text" @click="deletePost(post.id)">Delete</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    data() {
      return {
        posts: []
      };
    },
    created() {
      this.fetchPosts();
    },
    methods: {
      async fetchPosts() {
        try {
          const response = await axios.get('/admin/posts', {
            headers: {
              'Authorization': `Bearer ${localStorage.getItem('authToken')}`
            }
          });
          this.posts = response.data.posts;
        } catch (error) {
          console.error(error);
        }
      },
      async deletePost(postId) {
        try {
          await axios.delete(`/admin/posts/${postId}`, {
            headers: {
              'Authorization': `Bearer ${localStorage.getItem('authToken')}`
            }
          });
          this.posts = this.posts.filter(post => post.id !== postId);
        } catch (error) {
          console.error(error);
        }
      }
    }
  };
  </script>
  
  <style scoped>
  table {
    width: 100%;
    border-collapse: collapse;
  }
  
  th, td {
    border: 1px solid #ddd;
    padding: 8px;
  }
  
  .textButton {
    color: var(--text-color);
    cursor: pointer;
    padding: 0.5rem;
    border-radius: 1.5rem;
  }
  
  .deleteButton {
    width: 5rem;
    background: var(--color-red);
  }
  
  .height-text {
    font-size: 1rem;
  }
  </style>
  
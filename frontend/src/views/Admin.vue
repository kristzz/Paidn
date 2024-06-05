<template>
    <div class="admin-panel">
      <h1>Admin Panel</h1>
      <div>
        <button class="textButton editButton height-text" @click="currentTab = 'users'">Users</button>
        <button class="textButton editButton height-text" @click="currentTab = 'posts'">Posts</button>
      </div>
      <div v-if="currentTab === 'users'">
        <UsersTab />
      </div>
      <div v-if="currentTab === 'posts'">
        <PostsTab />
      </div>
    </div>
  </template>
  
  <script>
  import UsersTab from '../components/admin/UsersTab.vue';
  import PostsTab from '../components/admin/PostTab.vue';
  
  export default {
    components: {
      UsersTab,
      PostsTab
    },
    data() {
      return {
        currentTab: 'users'
      };
    }
  };
  </script>
  
  <style scoped>
  .admin-panel {
    padding: 20px;
  }
  
  .textButton {
    color: var(--text-color);
    cursor: pointer;
    padding: 0.5rem;
    border-radius: 1.5rem;
  }
  
  .editButton {
    width: 5rem;
    background: var(--accent-color);
  }
  
  .height-text {
    font-size: 1rem;
  }
  </style>
  
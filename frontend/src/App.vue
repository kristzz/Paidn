<script>
import Header from './components/NavBar.vue'

export default {
  name: 'app',
  components: {
    myheader: Header
  }
}
</script>

<template>
  <myheader
    v-if="$route.path !== '/register' && $route.path !== '/welcome' && $route.path !== '/login'"
  />
  <RouterView />
</template>

<style>
@import '@/assets/styles.css';
</style>

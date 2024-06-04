<template>
  <div>
    <Profile :authToken="authToken" />
    <WorkExperience :authToken="authToken" />
    <Education :authToken="authToken" />
    <BusinessProfile :authToken="authToken" />
  </div>
</template>

<script>
import Profile from '../components/profileComp/regUserProfile.vue';
import Education from '../components/profileComp/education.vue';
import WorkExperience from '../components/profileComp/workExperience.vue';
import BusinessProfile from '../components/profileComp/businessProfile.vue';

export default {
  components: {
    Profile,
    Education,
    WorkExperience,
    BusinessProfile
  },
  data() {
    return {
      authToken: localStorage.getItem('authToken')
    };
  }
};
</script>

<style scoped>

</style>

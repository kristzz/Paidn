<template>
  <main>
    <form class="input-auth-container">
      <legend>Register</legend>

      <input id="email" class="small-auth-input" type="email" placeholder="email@example.com" v-model="email">
      <input id="password" class="small-auth-input" type="password" placeholder="password" v-model="password">
      <input id="password_confirmation" class="small-auth-input" type="password" placeholder="confirm password" v-model="password_confirmation">
        
      <p v-if="errorMessage" style="color: red;">{{ errorMessage }}</p>
      <div class="row">
        <button type="button" class="stateButton weight-regular height-text" :class="buttonClass" @click="changeType">{{ buttonText }}</button>
        <button type="button" @click="register" id="authButton" class="authButton weight-regular height-text">Sign Up</button>
      </div>
      <div class="link-container">
        <router-link to="/login" id="refer-to-login" style="color: inherit;">Login instead</router-link>
      </div>
    </form>
  </main>
</template>


<script>
import axios from 'axios';

export default {
  data() {
    return {
      email: '',
      password: '',
      password_confirmation: '',
      type: 'unselected',
      errorMessage: '',
    };
  },
  methods: {
    register() {
      this.errorMessage = '';
      if (!this.email || !this.password || !this.password_confirmation) {
        this.errorMessage = 'All fields are required';
        return;
      }
      if (this.password !== this.password_confirmation) {
        this.errorMessage = 'Passwords do not match';
        return;
      }
      if (this.type === 'unselected') {
        this.errorMessage = 'You must select a user type';
        return;
      }

      axios.post('/register', {
        email: this.email,
        password: this.password,
        password_confirmation: this.password_confirmation,
        type: this.type,
      }).then(() => {
        this.$router.push('/login');
      }).catch((error) => {
        if (error.response && error.response.data && error.response.data.message) {
          this.errorMessage = error.response.data.message;
        } else {
          this.errorMessage = 'An error occurred during registration';
        }
      });
    },
    changeType() {
      const types = ['user', 'business'];
      const currentIndex = types.indexOf(this.type);
      const nextIndex = (currentIndex + 1) % types.length;
      this.type = types[nextIndex];
    },
  },
  computed: {
    buttonClass() {
      return `state-${this.type.toLowerCase()}`;
    },
    buttonText() {
      return this.type.charAt(0).toUpperCase() + this.type.slice(1);
    },
  },
};
</script>

<style scoped>
main {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
}

.state-user {
  background-color: var(--color-white);
  color: var(--color-black);
}
.state-business {
  background-color: var(--accent-color);
  color: var(--color-white);
}

.stateButton {
  padding: 0.25rem 0.75rem 0.25rem 0.75rem;
  margin: 0.5rem 0 0.75rem 2rem;
  min-width: 6.5rem;
  border: 1px solid var(--color-black);
  border-radius: 1rem;
  display: flex;
  justify-content: center;
  user-select: none;
  cursor: pointer;
}

#authButton {
  margin: 0.5rem 2rem 0.75rem 0rem;
  background: var(--color-white);
}

.row {
  display: flex;
  flex-direction: row;
  justify-content: space-between;
  width: 20rem;
}

.link-container{
  display: flex;
  justify-content: end;
  width: 100%;
}

#refer-to-login{
  margin: 1rem 2rem 0 0;
}
</style>

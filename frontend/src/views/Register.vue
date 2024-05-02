


<template>
    <main>
      <div>
        <form class="input-container">
            <input class="small-input" type="email" placeholder="email@example.com" v-model="email">
            <input class="small-input" type="password" placeholder="password" v-model="password">
            <input class="small-input" type="password" placeholder="confirm password" v-model="password_confirmation">
            <div class="row">
              <div class="stateButton weight-regular height-text" :class="buttonClass" @click="changeType">{{ buttonText }}</div>
              <button type="button" @click="register" id="authButton" class="authButton weight-regular height-text">Sign Up</button>
            </div>
            <div class="left">
              <router-link to="/login" id="left" style="color: inherit;">Login instead</router-link>
            </div>
        </form>
      </div>
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
    };
 },

 methods: {
  register() {
    axios.post('/register', {
      email: this.email,
      password: this.password,
      password_confirmation: this.password_confirmation,
      type: this.type
    }).then((response) => {
      console.log(response.data);
      this.$router.push('/login');
    }).catch((error) => {
      console.log(error.message);
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
main{
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;

}

.state-user {
 background-color: var(--color-black);
 color: var(--color-white);
}
.state-business {
 background-color: var(--color-gray);
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

.left{
  width: 20rem;
  display: flex;
  justify-content: end;
}

#left{
  margin: 0.5rem 2rem 0.75rem 0rem;
  user-select: none;
}
</style>
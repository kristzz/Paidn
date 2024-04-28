


<template>
    <main>
        <container>
            <form>
                <input type="email" placeholder="email@example.com" v-model="email">
                <input type="password" placeholder="password" v-model="password">
                <input type="password" placeholder="confirm password" v-model="password_confirmation">
                <div :class="buttonClass" @click="changeState">{{ buttonText }}</div>
                <button>Sign Up</button>
            </form>
        </container>
    </main>
</template>


<script>
export default {
 data() {
    return {
        email: '',
        password: '',
        password_confirmation: '',
        state: 'unselected', 
    };
 },
 computed: {
    buttonClass() {
      return `state-${this.state}`;
    },
    buttonText() {
      return this.state.charAt(0).toUpperCase() + this.state.slice(1);
    },
 },
 methods: {
    changeState() {
      const states = ['user', 'business'];
      const currentIndex = states.indexOf(this.state);
      const nextIndex = (currentIndex + 1) % states.length;
      this.state = states[nextIndex];
    },
 },
};
</script>

<style>
.state-user {
 background-color: #00f;
}
.state-business {
 background-color: #f00;
}
</style>
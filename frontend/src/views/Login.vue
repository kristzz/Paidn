
<script>
import axios from 'axios';

export default {
    data() {
        return {
            email: '',
            password: '',
        };
    },
    methods: {
        login() {
            axios.post('/login', {
                email: this.email,
                password: this.password,
            }).then((response) => {
                if (response.status === 200) {
                    localStorage.setItem('authToken', response.data.token);
                    axios.defaults.headers.common['Authorization'] = `Bearer ${response.data.token}`;
                    this.$router.push('/home');
                } else {
                    console.error('Login failed');
                }
            }).catch((error) => {
                console.log(error.message);
            });
        },
    },
};
</script>


<template>
    <main>
        <form class="input-container">
            <input class="small-input" type="email" placeholder="email@example.com" v-model="email">
            <input class="small-input" type="password" placeholder="password" v-model="password">
            <div class="row">
                <button class="authButton weight-regular height-text" type="button" @click="login" >Login</button>
                <router-link to="/register" id="left" style="color: inherit;">Register instead</router-link>
            </div>
        </form>
    </main>
</template>

<style scoped>
main{
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}
.row {
   display: flex;
   flex-direction: row;
   justify-content: space-between;
   width: 20rem;
   padding: 1rem 2rem;
}
#left{
    margin-top: 0.75rem;
}
</style>
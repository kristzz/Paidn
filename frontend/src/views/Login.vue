
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
        <container>
            <form>
                <input type="email" placeholder="email@example.com" v-model="email">
                <input type="password" placeholder="password" v-model="password">
                <button type="button" @click="login" >Login</button>
            </form>
        </container>
    </main>
</template>

<style>

</style>
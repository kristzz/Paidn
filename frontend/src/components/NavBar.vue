<script lang="ts">

</script>

<template>
    <header>
       <p><router-link :to="{ name: 'home' }">Home</router-link></p>
       <p><router-link :to="{ name: 'connections'}">Connections</router-link></p>
       <p><router-link :to="{ name: 'jobs'}">Jobs</router-link></p>
       <p><router-link :to="{ name: 'messages' }">Messages</router-link></p>
       <p><router-link :to="{ name: 'profile'}">Profile</router-link></p>
       <p><router-link :to="{name:'settings'}">Settings</router-link></p>
    </header>
</template>

<style scoped>

header {
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: row;

    background: var(--secondary-color);
    color: var(--background-color);

    position: sticky;
    top: 0;
    height:3.5rem;
    width:100dvw;
    gap:2rem;
    z-index: 10;

    transition: 0.2s ease-in-out;
}

a{
    color: var(--background-color);
    text-decoration: none;
}

a:hover, p:hover{
    transform: scale(1.02);
}

</style>
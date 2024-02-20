<template>
  <authHeader />
  <main>
    <div id="logo">
      <h1>Paidn</h1>
    </div>
    <div id="text">
      <h2 id="main-text">
        Discover job opportunities and seamlessly conduct interviews, all within a single platform!
      </h2>
      <p id="secondary-text">
        Embark on a journey of career exploration with our refined platform. Discover opportunities
        tailored to your aspirations and talents. To unlock the full potential of our services,
        kindly proceed by gracefully tapping into the realms of registration or seamlessly accessing
        your account through our distinguished login interface. Begin your odyssey towards
        professional fulfillment today
      </p>
    </div>
    <div id="login" class="btn">
      <router-link :to="{ name: 'login' }">Log in here!</router-link>
    </div>
    <div id="register" class="btn">
      <router-link :to="{ name: 'typeOfAcc' }">Try for free!</router-link>
    </div>
  </main>
</template>

<script lang="ts">
export default {}
</script>

<style scoped>
main {
  display: flex;
  position: absolute;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  height: 100%;
  width: 100%;
}
router-link {
  text-decoration: none;
}
#logo {
}
#text {
  max-width: 960px;
  height: auto;
  padding: 3rem;
  width: 75vw;
}
#main-text {
  padding: 0 5rem 0 5rem;
  margin-bottom: 3rem;
}
#secondary-text {
  padding: 0 3rem 0 3rem;
  opacity: 0.7;
}
#login {
  background: black;
}
#login a {
  color: white;
}
#register a {
  color: black;
}
.btn {
  width: 10rem;
  height: 3rem;
  background: var(--background-color);
  border-radius: 1.5rem;

  display: flex;
  justify-content: center;
  align-items: center;
  text-decoration: none;
}
.btn a {
  text-decoration: none;
}
</style>

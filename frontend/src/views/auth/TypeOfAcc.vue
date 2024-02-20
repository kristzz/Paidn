<template>
  <main>
    <router-link :to="{ name: 'userRegistration' }">
      <div id="btnOne" class="btn">Register as a User</div>
    </router-link>
    <router-link :to="{ name: 'businessRegistration' }">
      <div id="btnTwo" class="btn">Register as a Business</div>
    </router-link>
  </main>
</template>

<script>
export default {}
</script>

<style scoped>
main {
  height: 100vh;
  width: 100vw;
  overflow: hidden;
  display: flex;
  position: relative;
}

#btnOne {
  transform-origin: top left;
  position: absolute;
  left: 0;
  top: 0;
  clip-path: polygon(0 0, 100% 0, 75% 100%, 0 100%);
}

#btnTwo {
  transform-origin: bottom right;
  position: absolute;
  right: 0;
  bottom: 0;
  clip-path: polygon(25% 0, 100% 0, 100% 100%, 0 100%);
}

#btnOne:hover {
  background: var(--color-black);
  color: var(--color-white);
}

#btnTwo:hover {
  background: var(--color-black);
  color: var(--color-white);
}

.btn {
  height: 100%;
  width: 60%;
  background: var(--color-white);
  color: var(--color-black);
  display: flex;
  justify-content: center;
  align-items: center;
  transition:
    background 0.3s,
    color 0.3s;
}
</style>

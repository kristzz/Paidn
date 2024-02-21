<template>
  <main>
    <h2>Password change</h2>
    <form @submit.prevent="submitForm">
      <div id="passwordInput" class="input-icon">
        <label for="password">Password:</label><br />
        <svg
          xmlns="http://www.w3.org/2000/svg"
          x="0px"
          y="0px"
          width="100"
          height="100"
          viewBox="0 0 32 32"
        >
          <path
            d="M 16 3 C 12.15625 3 9 6.15625 9 10 L 9 13 L 6 13 L 6 29 L 26 29 L 26 13 L 23 13 L 23 10 C 23 6.15625 19.84375 3 16 3 Z M 16 5 C 18.753906 5 21 7.246094 21 10 L 21 13 L 11 13 L 11 10 C 11 7.246094 13.246094 5 16 5 Z M 8 15 L 24 15 L 24 27 L 8 27 Z"
          ></path>
        </svg>
        <input
          type="password"
          id="password"
          class="input"
          placeholder="password"
          v-model="password"
          required
        />
      </div>
      <div id="passwordConfirm" class="input-icon">
        <label for="passwordConfirm">Confirm password:</label><br />
        <svg
          xmlns="http://www.w3.org/2000/svg"
          x="0px"
          y="0px"
          width="100"
          height="100"
          viewBox="0 0 32 32"
        >
          <path
            d="M 16 3 C 12.15625 3 9 6.15625 9 10 L 9 13 L 6 13 L 6 29 L 26 29 L 26 13 L 23 13 L 23 10 C 23 6.15625 19.84375 3 16 3 Z M 16 5 C 18.753906 5 21 7.246094 21 10 L 21 13 L 11 13 L 11 10 C 11 7.246094 13.246094 5 16 5 Z M 8 15 L 24 15 L 24 27 L 8 27 Z"
          ></path>
        </svg>
        <input
          type="password"
          id="passwordConfirm"
          class="input"
          placeholder="password"
          v-model="passwordConfirm"
          required
        />
      </div>
      <div class="button-container">
        <button type="submit" id="sendBtn">Proceed</button>
      </div>
    </form>
  </main>
</template>

<script lang="ts">
export default {}
</script>

<style scoped>
#passwordInput {
  margin-top: 1.5rem;
  margin-bottom: 1.5rem;
}
</style>

<style src="../../auth/auth.css" scoped></style>

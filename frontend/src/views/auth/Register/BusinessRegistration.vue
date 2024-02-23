<template>
  <main>
    <div class="register">
      <h2>Join us now and discover the perfect candidates to drive your business forward!</h2>
      <form @submit.prevent="submitForm">
        <div id="emailInput" class="input-icon">
          <label for="email">Email:</label><br />
          <svg
            xmlns="http://www.w3.org/2000/svg"
            width="800px"
            height="800px"
            viewBox="0 0 24 24"
            fill="none"
          >
            <path
              d="M3 8L8.44992 11.6333C9.73295 12.4886 10.3745 12.9163 11.0678 13.0825C11.6806 13.2293 12.3194 13.2293 12.9322 13.0825C13.6255 12.9163 14.2671 12.4886 15.5501 11.6333L21 8M6.2 19H17.8C18.9201 19 19.4802 19 19.908 18.782C20.2843 18.5903 20.5903 18.2843 20.782 17.908C21 17.4802 21 16.9201 21 15.8V8.2C21 7.0799 21 6.51984 20.782 6.09202C20.5903 5.71569 20.2843 5.40973 19.908 5.21799C19.4802 5 18.9201 5 17.8 5H6.2C5.0799 5 4.51984 5 4.09202 5.21799C3.71569 5.40973 3.40973 5.71569 3.21799 6.09202C3 6.51984 3 7.07989 3 8.2V15.8C3 16.9201 3 17.4802 3.21799 17.908C3.40973 18.2843 3.71569 18.5903 4.09202 18.782C4.51984 19 5.07989 19 6.2 19Z"
              stroke="#000000"
              stroke-width="2"
              stroke-linecap="round"
              stroke-linejoin="round"
            />
          </svg>
          <input
            type="email"
            id="email"
            class="input"
            placeholder="youremail@email.com"
            v-model="email"
            required
          />
        </div>
        <div id="passwordInput" class="input-icon gap">
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
      <div id="passwordConfirm" class="input-icon gap">
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
          <button type="submit" id="sendBtn">Join!</button>
          <div id="loginInsteadBtn">
            <router-link :to="{ name: 'login' }">Log In instead!</router-link>
          </div>
        </div>
      </form>
    </div>
  </main>
</template>

<script>
export default {}
</script>

<style scoped>
#businessnameInput {
  margin-top: 1rem;
}

.gap{
    margin-top: 1rem;
}

#btn a {
  color: var(--color-black);
}

.button-container {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

#loginInsteadBtn {
  margin-top: 2rem;
}

</style>

<style src="../../auth/auth.css" scoped></style>

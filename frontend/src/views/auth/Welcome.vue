<template>
    <authHeader />
    <main>
        <div id="logo">
            <h1>Paidn</h1>
        </div>
        <div id="text">
            <h2 id="main-text">Discover job opportunities and seamlessly conduct interviews, all within a single platform!</h2>
            <p id="secondary-text">Embark on a journey of career exploration with our refined platform. Discover opportunities tailored to your aspirations and talents. To unlock the full potential of our services, kindly proceed by gracefully tapping into the realms of registration or seamlessly accessing your account through our distinguished login interface. Begin your odyssey towards professional fulfillment today</p>
        </div>
        <div id="login" class="btn">
            <router-link :to="{name:'login'}">Log in here!</router-link>
        </div>
        <div id="register" class="btn">
            <router-link :to="{name:'register'}">Try for free!</router-link>
        </div>
        <div v-for="circle in circles" :key="circle.id" :id="circle.id" class="circle" :style="{ left: circle.left, top: circle.top, background: circle.color, zIndex: -1 }"></div>
    </main>
</template>

<script lang="ts">
export default {
  data() {
    return {
      circles: [],
    };
  },
  mounted() {
    this.generateCircles();
  },
  methods: {
    generateCircles() {
      const colors = ['var(--color-orange)', 'var(--color-red)', 'var(--color-orange)', 'var(--color-lightorange)', 'var(--color-yellow)'];
      const count = 14;
      const circleSize = 2.5; // The size of the circle in vw/vh units

      for (let i = 0; i < count; i++) {
        const color = colors[i % colors.length];
        const left = Math.floor(Math.random() * (90 - circleSize)) + 5 + 'vw'; // 5vw offset and 90vw range
        const top = Math.floor(Math.random() * (90 - circleSize)) + 5 + 'vh'; // 5vh offset and 90vh range

        this.circles.push({ id: 'circle' + (i + 1), color, left, top });
      }
    },
  },
};
</script>

<style scoped>
    main{
        display: flex;
        flex-direction: column;
        align-items: center;
        padding-top: 4rem;
    }
    router-link{
        text-decoration: none;
    }
    #logo{

    }
    #text{
        max-width: 960px;
        height: auto;
        padding: 3rem;
        width: 75vw;
    }
    #main-text{
        padding: 1rem 0 0 1rem;
    }
    #secondary-text{
        opacity: 0.7;
    }
    #login{
        background: black;
    }
    #login a{
        color: white;
    }
    #register a{
        color: black;
    }
    .btn{
        width: 10rem;
        height: 3rem;
        background: var(--background-color);
        border-radius: 1.5rem;

        display: flex;
        justify-content: center;
        align-items: center;
        text-decoration: none;
    }
    .btn a{
        text-decoration: none;
    }

    .circle {
        position: absolute;
        width:   50px;
        height:   50px;
        border-radius:   50%;
    }
    #circle1 {
        background: var(--color-orange);
    }
    #circle2 {
        background: var(--color-red);
    }
    #circle3 {
        background: var(--color-orange);
    }
    #circle4 {
        background: var(--color-lightorange);
    }
    #circle5 {
        background: var(--color-yellow);
    }
</style>
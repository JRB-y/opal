<template>
  <div>
    <header>
      <img :src="logoPath" alt="logo" id="logo" />
    </header>
    <ul id="menu">
      <router-link to="/">Home</router-link>
      <router-link to="/studio">Studio</router-link>
      <router-link to="/">Contact</router-link>
    </ul>
  </div>
</template>
<script>
export default {
  name: "HeaderComponent",
  data() {
    return {
      logoPath: "/images/logo-white.png"
    };
  }
};
</script>

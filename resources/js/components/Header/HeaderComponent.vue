<template>
  <div>
    <header>
      <img :src="logoPath" alt="logo" id="logo" />
    </header>
    <div id="social-block">
      <a href="https://www.facebook.com/opalcrea" target="_blank" class="social-link">
        <i class="fab fa-facebook-square"></i>
      </a>
      <a href="https://www.instagram.com/opal_designs_/" target="_blank" class="social-link">
        <i class="fab fa-instagram"></i>
      </a>
    </div>
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
<style scoped>
#social-block {
  float: right;
  font-size: 39px;
  color: #97847a;
}
.social-link {
  color: #97847a;
}
</style>

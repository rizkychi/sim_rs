<template>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <router-link class="navbar-brand" to="/">Navbar</router-link>
    <button
      class="navbar-toggler"
      type="button"
      data-toggle="collapse"
      data-target="#navbarSupportedContent"
      aria-controls="navbarSupportedContent"
      aria-expanded="false"
      aria-label="Toggle navigation"
    >
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul v-if="authenticated" class="navbar-nav mr-auto">
        <li v-for="menu in menus" :key="menu.menu_id" class="nav-item">
          <router-link class="nav-link" v-bind:to="menu.url">{{
            menu.menu
          }}</router-link>
        </li>
        <li v-for="menu in menu_temp" :key="menu.menu_id" class="nav-item">
          <router-link class="nav-link" v-bind:to="menu.url">{{
            menu.menu
          }}</router-link>
        </li>
      </ul>
      <span v-if="authenticated" class="navbar-text">
        <ul class="navbar-nav">
          <li class="nav-item">
            <span class="user-text">
              Hi, {{ user.user }} ({{ user.username }})
            </span>
          </li>
          <li class="nav-item">
            <a href="#" @click="logoutAction">Logout</a>
          </li>
        </ul>
      </span>
      <ul v-else class="navbar-nav ml-auto">
        <li class="nav-item">
          <router-link class="nav-link" to="/login">Login</router-link>
        </li>
        <li class="nav-item">
          <router-link class="nav-link" to="/register">Register</router-link>
        </li>
      </ul>
    </div>
  </nav>
</template>

<script>
import { mapActions, mapGetters } from "vuex";

export default {
  computed: {
    ...mapGetters({
      authenticated: "auth/authenticated",
      user: "auth/user",
      menus: "auth/menu",
    }),
  },

  methods: {
    ...mapActions({
      logout: "auth/logout",
    }),

    logoutAction() {
      this.logout().then(() => {
        this.$router.replace({ name: "Login" });
      });
    },
  },

  data() {
    return {
      menu_temp: [],
    };
  },

  created() {
    this.menu_temp = JSON.parse(localStorage.getItem("menu"));
  },
};
</script>

<style>
.user-text {
  margin: 0 15px;
}
</style>
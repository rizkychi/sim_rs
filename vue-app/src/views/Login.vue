<template>
  <div class="row justify-content-md-center">
    <div class="col-md-6">
      <div class="card">
        <div class="card-header">Login</div>
        <div class="card-body">
          <div v-if="loginError.status" class="alert alert-danger" role="alert">
            Login failed: {{ loginError.message }}
          </div>
          <form @submit.prevent="submit">
            <div class="form-group">
              <label for="username">Email address</label>
              <input
                id="username"
                type="text"
                class="form-control"
                placeholder="Username"
                v-model="form.username"
                required
              />
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <input
                id="password"
                type="password"
                class="form-control"
                placeholder="Password"
                v-model="form.kunci"
                required
              />
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapActions } from "vuex";

export default {
  data() {
    return {
      form: {
        username: "",
        kunci: "",
      },
      loginError: {
        status: false,
        message: null,
      },
    };
  },

  methods: {
    ...mapActions({
      login: "auth/login",
    }),

    submit() {
      this.login(this.form).then((result) => {
        if (result.status) {
          this.$router.replace({
            name: "Home",
          });
        } else {
          this.loginError.status = true;
          this.loginError.message = result.message;
        }
      });
    },
  },
};
</script>
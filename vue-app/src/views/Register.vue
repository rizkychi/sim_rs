<template>
  <div class="row justify-content-md-center">
    <div class="col-md-6">
      <div class="card">
        <div class="card-header">Register</div>
        <div class="card-body">
          <div
            v-if="registerError.status && isSubmitted"
            class="alert alert-success"
            role="alert"
          >
            Register success: you can login <a href="/login">here</a>
          </div>
          <div
            v-if="registerError.status == false && isSubmitted"
            class="alert alert-danger"
            role="alert"
          >
            Register failed: {{ registerError.message }}
          </div>
          <form @submit.prevent="submit">
            <div class="form-group">
              <label for="user">Username</label>
              <input
                id="user"
                type="text"
                class="form-control"
                placeholder="Username"
                maxlength="20"
                v-model="form.username"
                required
              />
            </div>
            <div class="form-group">
              <label for="name">Full name</label>
              <input
                id="name"
                type="text"
                class="form-control"
                placeholder="Full name"
                maxlength="200"
                v-model="form.user"
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
                maxlength="32"
                v-model="form.kunci"
                required
              />
            </div>
            <button type="submit" class="btn btn-primary">Register</button>
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
        user: "",
        kunci: "",
      },
      registerError: {
        status: false,
        message: null,
      },
      isSubmitted: false,
    };
  },

  methods: {
    ...mapActions({
      register: "auth/register",
    }),

    submit() {
      this.register(this.form).then((result) => {
        this.registerError.status = result.status;
        this.registerError.message = result.message;
        this.isSubmitted = true;
      });
    },
  },
};
</script>

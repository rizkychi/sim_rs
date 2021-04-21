<template>
  <div class="row justify-content-md-center">
    <div class="col-md-6">
      <div class="card">
        <div class="card-header">User Account</div>
        <div class="card-body">
          <div v-if="updateError" class="alert alert-success" role="alert">
            Update success
          </div>
          <form @submit.prevent="submit">
            <div class="form-group">
              <label for="username">Username</label>
              <input
                id="username"
                type="text"
                class="form-control"
                v-model="form.username"
                disabled
              />
            </div>
            <div class="form-group">
              <label for="name">Full name</label>
              <input
                id="name"
                type="text"
                class="form-control"
                v-model="form.user"
                :disabled="disabled"
                required
              />
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <input
                id="password"
                type="password"
                class="form-control"
                v-model="form.kunci"
                :disabled="disabled"
                required
              />
            </div>
            <button
              v-show="disabled"
              type="button"
              class="btn btn-danger float-left"
              data-toggle="modal"
              data-target="#exampleModalCenter"
            >
              Delete
            </button>
            <button
              v-show="disabled"
              v-on:click="formEdit"
              type="button"
              class="btn btn-primary float-right"
            >
              Update
            </button>
            <button
              v-show="!disabled"
              v-on:click="cancelEdit"
              type="button"
              class="btn btn-danger float-right ml-3"
            >
              Cancel
            </button>
            <button
              v-show="!disabled"
              type="submit"
              class="btn btn-success float-right"
            >
              Save
            </button>
          </form>

          <!-- Modal -->
          <div
            class="modal fade"
            id="exampleModalCenter"
            tabindex="-1"
            role="dialog"
            aria-labelledby="exampleModalCenterTitle"
            aria-hidden="true"
          >
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLongTitle">
                    Confirm delete
                  </h5>
                  <button
                    type="button"
                    class="close"
                    data-dismiss="modal"
                    aria-label="Close"
                  >
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  Are you sure want to delete this account?
                </div>
                <div class="modal-footer">
                  <button
                    type="button"
                    class="btn btn-secondary"
                    data-dismiss="modal"
                  >
                    Cancel
                  </button>
                  <button
                    type="button"
                    v-on:click="deleteAccount"
                    class="btn btn-danger"
                    data-dismiss="modal"
                  >
                    Delete
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";

export default {
  computed: {
    ...mapGetters({
      authenticated: "auth/authenticated",
      user: "auth/user",
    }),
  },

  methods: {
    ...mapActions({
      update: "auth/update",
      delete: "auth/delete",
    }),

    formEdit() {
      this.disabled = false;
      this.form.kunci = "";
    },

    cancelEdit() {
      this.disabled = true;
      this.form.kunci = this.defaultKunci;
    },

    submit() {
      this.update(this.form).then((result) => {
        if (result.status) {
          this.updateError = true;
          this.disabled = true;
        }
      });
      this.form.kunci = this.defaultKunci;
    },

    deleteAccount() {
      this.delete().then((result) => {
        if (result.status) {
          this.$router.replace({
            name: "Login",
          });
        }
      });
    },
  },

  data() {
    return {
      defaultKunci: "123456789",
      form: {
        username: null,
        user: null,
        kunci: null,
      },
      disabled: true,
      updateError: false,
    };
  },

  created() {
    this.form.username = this.user.username;
    this.form.user = this.user.user;
    this.form.kunci = this.defaultKunci;
  },
};
</script>

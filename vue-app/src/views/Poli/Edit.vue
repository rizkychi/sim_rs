<template>
  <div class="row justify-content-md-center">
    <div class="col-md-6">
      <div class="card">
        <div class="card-header">Ubah Poli</div>
        <div class="card-body">
          <form @submit.prevent="submit">
            <div class="form-group">
              <label for="poli">Nama Poli</label>
              <input
                id="poli"
                type="text"
                class="form-control"
                placeholder="Nama Poli"
                maxlength="100"
                v-model="form.poli"
                required
              />
            </div>
            <div class="form-group">
              <label for="antrian_dibuka">Antrian dibuka H- (jam)</label>
              <input
                id="antrian_dibuka"
                type="number"
                min="0"
                max="24"
                class="form-control"
                placeholder="Optional"
                v-model="form.antrian_dibuka_h_minus"
              />
            </div>
            <div class="form-group">
              <label for="antrian_ditutup">Antrian ditutup H- (jam)</label>
              <input
                id="antrian_ditutup"
                type="number"
                min="0"
                max="24"
                class="form-control"
                placeholder="Optional"
                v-model="form.antrian_ditutup_h_minus"
              />
            </div>
            <button type="submit" class="btn btn-primary">Ubah</button>
            <router-link :to="{ name: 'Poli' }" class="btn btn-md btn-danger float-right">Batal</router-link>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      form: {
        poli: "",
        antrian_dibuka_h_minus: "",
        antrian_ditutup_h_minus: "",
      },
    };
  },

  created() {
    let uri = `http://localhost:8000/api/poli/${this.$route.params.id}`;
    axios
      .get(uri, {
        headers: {
          Authorization: "Bearer " + localStorage.getItem("token"),
        },
      })
      .then((response) => {
        if (response.data.status) {
          this.form = response.data.data;
        }
      });
  },

  methods: {
    submit() {
      let uri = `http://localhost:8000/api/poli/${this.$route.params.id}`;
      axios
        .put(uri, this.form, {
          headers: {
            Authorization: "Bearer " + localStorage.getItem("token"),
          },
        })
        .then((response) => {
          this.$router.push({
            name: "Poli",
          });
        });
    },
  },
};
</script>

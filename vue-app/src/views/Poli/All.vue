<template>
  <div class="container mt-3">
    <div class="row justify-content-center">
      <div class="col-md-12">
        <div class="card card-default">
          <div class="card-header">Management Poli</div>
          <div class="card-body">
            <router-link :to="{ name: 'PoliCreate' }" class="btn btn-md btn-success">Tambah poli</router-link>
            <div class="mt-4">
              <table class="table table-stripped">
                <thead>
                  <tr>
                    <th>ID Poli</th>
                    <th>Nama Poli</th>
                    <th>Antrian dibuka H- (jam)</th>
                    <th>Antrian ditutup H- (jam)</th>
                    <th>Pilihan</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-if="!poli.length">
                    <td colspan="5" class="text-center">Tidak ada data</td>
                  </tr>
                  <tr v-else v-for="(item, index) in poli" :key="item.poli_id">
                    <td>{{ item.poli_id }}</td>
                    <td>{{ item.poli }}</td>
                    <td>{{ item.antrian_dibuka_h_minus != null ?  item.antrian_dibuka_h_minus : '-' }}</td>
                    <td>{{ item.antrian_ditutup_h_minus != null ? item.antrian_ditutup_h_minus : '-' }}</td>
                    <td>
                      <router-link :to="{name: 'PoliEdit', params: { id: item.poli_id }}" class="btn btn-sm btn-primary">Ubah</router-link>
                      <button @click.prevent="deletePoli(item.poli_id, index)" class="btn btn-sm btn-danger ml-2">HAPUS</button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
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
      poli: [],
    };
  },

  created() {
    let uri = "http://localhost:8000/api/poli";
    axios
      .get(uri, {
        headers: {
          Authorization: "Bearer " + localStorage.getItem("token"),
        },
      })
      .then((response) => {
        if (response.data.status) {
          this.poli = response.data.data
        }
      });
  },

  methods: {
    deletePoli(id, index) {
      let uri = `http://localhost:8000/api/poli/${id}`;
      axios
        .delete(uri, {
          headers: {
            Authorization: "Bearer " + localStorage.getItem("token"),
          },
        })
        .then((response) => {
          if (response.data.status) {
            this.poli.splice(index, 1);
          }
        }).catch(error => {
          alert('system error!');
        });
    },
  },
};
</script>
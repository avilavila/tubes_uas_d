<template>
  <v-main>
    <v-card>
      <v-alert outlined color="green">
        <v-list-item>
          <v-list-item-avatar>
            <img src="https://i.pinimg.com/originals/2b/fb/75/2bfb752106320b2ddd94901fc417e9b2.png" />
          </v-list-item-avatar>
          <v-list-item-content>
            <v-list-item-title class="headline">PEMBELIAN</v-list-item-title>
            <v-list-item-subtitle>MAROL</v-list-item-subtitle>
          </v-list-item-content>
        </v-list-item>
        <v-card-title>
          <v-text-field v-model="search" append-icon="mdi-magnify" label="Search" outlined style="margin-top: 30px"></v-text-field>
          <v-spacer></v-spacer>
        </v-card-title>
        <v-card>
          <v-data-table :headers="headers" :items="belis" :search="search">
            <template v-slot:[`item.actions`]="{ item }">
              <v-btn small class="mr-2 red" @click="deleteItem(item.id)"> <v-icon color="white">mdi-delete-circle</v-icon> </v-btn>
            </template>
          </v-data-table>
        </v-card>
      </v-alert>
    </v-card>
    <v-dialog v-model="dialogConfirm" persistent max-width="400px">
      <div class="text-center">
        <v-sheet class="px-7 pt-7 pb-4 mx-auto text-center" >
          <div class="black--text text--lighten-1 text-body-2 mb-4">Ingin menghapus pembelian ini?</div>

          <v-btn plain color="green" @click="setDelete">Yes</v-btn>
          <v-btn plain color="red" @click="dialogConfirm = false">No</v-btn>
          
        </v-sheet>
      </div>
    </v-dialog>
  </v-main>
</template>

<script>
export default {
  name: "PembelianList",
  data() {
      return {
          inputType: "Tambah",
          load: false,
          snackbar: false,
          error_message: "",
          color: "",
          search: null,
          idUser: 0,
          dialog: false,
          dialogConfirm: false,
          headers: [
              {
                  text: "Nama",
                  align: "start",
                  sortable: true,
                  value: "nama",
              },
              { text: "Nama Produk", value: "nama_produk" },
              { text: "Jumlah", value: "jumlah" },
              { text: "Actions", value: "actions"}
          ],
          beli: new FormData(),
          belis: [],
          form: {
              nama: null,
              nama_produk: null,
              jumlah: null,
          },
          idDelete: "",
          idEdit: "",
      };
  },
  methods: {
      readData() {
          var url = this.$api + "/beli";
          this.$http
          .get(url, {
              headers: {
              Authorization: "Bearer " + localStorage.getItem("token"),
              },
          })
          .then((response) => {
              this.belis = response.data.data;
          });
      },

      setDelete() {
          var url = this.$api + "/beli/" + this.idDelete;
          this.load = true;
          this.$http
          .delete(url, {
              headers: {
              Authorization: "Bearer " + localStorage.getItem("token"),
              },
          })
          .then((response) => {
              this.error_message = response.data.message;
              this.color = "green";
              this.snackbar = true;
              this.load = false;
              this.belis.splice(this.index, 1);
              this.close();
              this.readData();
              this.resetForm();
              this.inputType = "Tambah";
          })
          .catch((error) => {
              this.error_message = error.response.data.message;
              this.color = "red";
              this.snackbar = true;
              this.load = false;
          });
      },
  
      deleteItem(id) {
          this.idDelete = id;
          this.dialogConfirm = true;
      },

      close() {
          this.dialog = false;
          this.inputType = "Tambah";
          this.dialogConfirm = false;
          this.dialogAddToCart = false;
          this.readData();
      },
  },

  mounted() {
      this.readData();
      this.idUser = localStorage.getItem("id");
  },
};
</script>
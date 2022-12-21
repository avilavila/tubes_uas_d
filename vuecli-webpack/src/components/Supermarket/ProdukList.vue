<template>
  <v-main>
    <v-card>
      <v-alert outlined color="green">
        <v-list-item>
          <v-list-item-avatar>
          <img src="https://i.pinimg.com/originals/2b/fb/75/2bfb752106320b2ddd94901fc417e9b2.png" />
          </v-list-item-avatar>
          <v-list-item-content>
            <v-list-item-title class="headline">PRODUK</v-list-item-title>
            <v-list-item-subtitle>MAROL</v-list-item-subtitle>
          </v-list-item-content>
        </v-list-item>
        <v-card-title>
          <v-text-field v-model="search" append-icon="mdi-magnify" label="Search" outlined style="margin-top: 30px"></v-text-field>
          <v-spacer></v-spacer>
          <v-btn class="white--text" color="green" @click="dialog = true"> Beli </v-btn>
        </v-card-title>
        <v-card>
          <v-data-table :headers="headers" :items="produks" :search="search">
          </v-data-table>
        </v-card>
      </v-alert>
    </v-card>
    <v-dialog v-model="dialog" persistent max-width="700px">
      <v-card class="white lighten-3">
        <v-card-title>
          <span class="headline">{{ formTitle }} Produk</span>
        </v-card-title>
        <v-card-text>
          <v-container>
              <v-text-field 
                  v-model="form.nama" 
                  label="Nama" 
                  required
              ></v-text-field>
              <v-text-field 
                  v-model="form.nama_produk" 
                  label="Nama Produk" 
                  required
              ></v-text-field>
              <v-text-field 
                  v-model="form.jumlah" 
                  type="number"
                  label="Jumlah" 
                  required
              ></v-text-field>
          </v-container>
        </v-card-text>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="green darken-1" text @click="setForm"> Save </v-btn>
          <v-btn color="blue darken-1" text @click="cancel"> Cancel </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <v-snackbar v-model="snackbar" :color="color" timeout="2000" bottom>
      {{ error_message }}
    </v-snackbar>
  </v-main>
</template>

<script>
export default {
  name: "ProdukList",
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
                  text: "Nama Produk",
                  align: "start",
                  sortable: true,
                  value: "nama_produk",
              },
              { text: "Kategori", value: "kategori_produk" },
              { text: "Jumlah", value: "jumlah_produk" },
              { text: "Harga", value: "harga" },
          ],
          produk: new FormData(),
          produks: [],
          form: {
              nama_produk: null,
              kategori_produk: null,
              jumlah_produk: null,
              harga: null,
          },
          idDelete: "",
          idEdit: "",
      };
  },
  methods: {
      setForm() {
          if (this.inputType !== "Tambah") {
          this.updateData();
          } else {
          this.saveData();
          }
      },

      readData() {
          var url = this.$api + "/produk";
          this.$http
          .get(url, {
              headers: {
              Authorization: "Bearer " + localStorage.getItem("token"),
              },
          })
          .then((response) => {
              this.produks = response.data.data;
          });
      },
  
      saveData() {
          this.produk.append("nama", this.form.nama);
          this.produk.append("nama_produk", this.form.nama_produk);
          this.produk.append("jumlah", this.form.jumlah);

          var url = this.$api + "/beli";
          this.load = true;
          this.$http
          .post(url, this.produk, {
              headers: {
              Authorization: "Bearer " + localStorage.getItem("token"),
              },
          })
          .then((response) => {
              this.error_message = response.data.message;
              this.color = "green";
              this.snackbar = true;
              this.load = true;
              this.close();
              this.readData();
              this.resetForm();
          })
          .catch((error) => {
              this.error_message = error.response.data.message;
              this.color = "red";
              this.snackbar = true;
              this.load = false;
          });
      },
  
  
      close() {
          this.dialog = false;
          this.inputType = "Tambah";
          this.dialogConfirm = false;
          this.dialogAddToCart = false;
          this.readData();
      },
  
      cancel() {
          this.resetForm();
          this.readData();
          this.dialog = false;
          this.dialogConfirm = false;
          this.inputType = "Tambah";
      },
  
      resetForm() {
          this.form = {
          nama_produk: null,
          kategori_produk: null,
          jumlah_produk: null,
          harga: null,
          };
      },
  
  },

  computed: {
      formTitle() {
          return this.inputType;
      },
  },

  mounted() {
      this.readData();
      this.idUser = localStorage.getItem("id");
  },
};
</script>

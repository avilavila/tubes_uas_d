<template>
    <v-main>
      <v-card>
        <v-alert outlined color="green">
          <v-list-item>
            <v-list-item-avatar>
              <img src="https://i.pinimg.com/originals/2b/fb/75/2bfb752106320b2ddd94901fc417e9b2.png" />
            </v-list-item-avatar>
            <v-list-item-content>
              <v-list-item-title class="headline">KERANJANG</v-list-item-title>
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
                <v-btn small class="mr-2 green" @click="editItem(item)"> <v-icon color="white">mdi-pencil-circle</v-icon> </v-btn>
              </template>
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
                    label="Nama User" 
                    required
                ></v-text-field>
                <v-text-field 
                    v-model="form.nama_produk" 
                    label="Produk" 
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
    name: "KeranjangList",
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
                    text: "User",
                    align: "start",
                    sortable: true,
                    value: "nama",
                },
                { text: "Produk", value: "nama_produk" },
                { text: "Jumlah", value: "jumlah" },
                { text: "Actions", value: "actions" }
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
      setForm() {
            if (this.inputType !== "Tambah") {
            this.updateData();
            } else {
            this.saveData();
            }
        },

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

        updateData() {
            let newData = {
            nama: this.form.nama,
            nama_produk: this.form.nama_produk,
            jumlah: this.form.jumlah,
            };
            var url = this.$api + "/beli/" + this.idEdit;
            this.load = true;
            this.$http
            .put(url, newData, {
                headers: {
                Authorization: "Bearer " + localStorage.getItem("token"),
                },
            })
            .then((response) => {
                this.error_message = response.data.message;
                this.color = "green";
                this.snackbar = true;
                this.load = false;
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

        editItem(item) {
            this.inputType = "Edit";
            this.idEdit = item.id;
            this.form.nama = item.nama;
            this.form.nama_produk = item.nama_produk;
            this.form.jumlah = item.jumlah;
            this.dialog = true;
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
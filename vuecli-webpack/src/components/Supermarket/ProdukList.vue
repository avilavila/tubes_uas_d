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
          </v-card-title>
          <v-card>
            <v-data-table :headers="headers" :items="produks" :search="search">
            </v-data-table>
          </v-card>
        </v-alert>
      </v-card>
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
                { text: "Harga", value: "harga" }
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
    },
  
    mounted() {
        this.readData();
        this.idUser = localStorage.getItem("id");
    },
  };
  </script>
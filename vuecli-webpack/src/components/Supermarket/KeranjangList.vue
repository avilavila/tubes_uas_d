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
            </v-data-table>
          </v-card>
        </v-alert>
      </v-card>
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
                    value: "id_user",
                },
                { text: "Produk", value: "id_produk" },
                { text: "Jumlah", value: "jumlah" }
            ],
            beli: new FormData(),
            belis: [],
            form: {
                id_user: null,
                id_produk: null,
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
    },
  
    mounted() {
        this.readData();
        this.idUser = localStorage.getItem("id");
    },
  };
  </script>
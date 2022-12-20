<template>
    <v-main>
      <v-card>
        <v-alert outlined color="green">
          <v-list-item>
            <v-list-item-avatar>
              <img src="https://pa-pagaralam.go.id/images/demo/anoun.png" />
            </v-list-item-avatar>
            <v-list-item-content>
              <v-list-item-title class="headline">ANNOUNCEMENT</v-list-item-title>
              <v-list-item-subtitle>MAROL</v-list-item-subtitle>
            </v-list-item-content>
          </v-list-item>
          <v-card-title>
            <v-text-field v-model="search" append-icon="mdi-magnify" label="Search" outlined style="margin-top: 30px"></v-text-field>
            <v-spacer></v-spacer>
          </v-card-title>
          <v-card>
            <v-data-table :headers="headers" :items="announcements" :search="search">
            </v-data-table>
          </v-card>
        </v-alert>
      </v-card>
    </v-main>
  </template>
  
  <script>
  export default {
    name: "AnnouncementList",
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
                { text: "Status", value: "status" },
                { text: "Keterangan", value: "keterangan" }
            ],
            announcement: new FormData(),
            announcements: [],
            form: {
                nama_produk: null,
                status: null,
                keterangan: null,
            },
            idDelete: "",
            idEdit: "",
        };
    },
    methods: {
        readData() {
            var url = this.$api + "/announcement";
            this.$http
            .get(url, {
                headers: {
                Authorization: "Bearer " + localStorage.getItem("token"),
                },
            })
            .then((response) => {
                this.announcements = response.data.data;
            });
        },
    },
  
    mounted() {
        this.readData();
        this.idUser = localStorage.getItem("id");
    },
  };
  </script>
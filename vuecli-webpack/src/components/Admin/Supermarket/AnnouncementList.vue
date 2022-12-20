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
            <v-btn class="white--text" color="green" @click="dialog = true"> Tambah </v-btn>
          </v-card-title>
          <v-card>
            <v-data-table :headers="headers" :items="announcements" :search="search">
              <template v-slot:[`item.actions`]="{ item }">
                <v-btn small class="mr-2 green" @click="editItem(item)"> <v-icon color="white">mdi-pencil-circle</v-icon> </v-btn>
                <v-btn small class="mr-2 red" @click="deleteItem(item.id)"> <v-icon color="white">mdi-delete-circle</v-icon> </v-btn>
              </template>
            </v-data-table>
          </v-card>
        </v-alert>
      </v-card>
      <v-dialog v-model="dialog" persistent max-width="700px">
        <v-card class="white lighten-3">
          <v-card-title>
            <span class="headline">{{ formTitle }} Announcement</span>
          </v-card-title>
          <v-card-text>
            <v-container>
                <v-text-field 
                    v-model="form.nama_produk" 
                    label="Nama Produk" 
                    required
                ></v-text-field>

                <v-select 
                    v-model="form.status" 
                    :items="[`Ready`, `Sold Out`]"
                    label="Status" 
                    required
                ></v-select>

                <v-textarea 
                    v-model="form.keterangan" 
                    label="Keterangan" 
                    required
                ></v-textarea>
            </v-container>
          </v-card-text>
  
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="blue darken-1" text @click="cancel"> Cancel </v-btn>
            <v-btn color="green darken-1" text @click="setForm"> Save </v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
  
      <v-dialog v-model="dialogConfirm" persistent max-width="400px">
        <div class="text-center">
          <v-sheet class="px-7 pt-7 pb-4 mx-auto text-center" >
            <div class="black--text text--lighten-1 text-body-2 mb-4">Ingin menghapus pengumuman ini?</div>
  
            <v-btn plain color="green" @click="setDelete">Yes</v-btn>
            <v-btn plain color="red" @click="dialogConfirm = false">No</v-btn>
            
          </v-sheet>
        </div>
      </v-dialog>
      <v-snackbar v-model="snackbar" :color="color" timeout="2000" bottom>
        {{ error_message }}
      </v-snackbar>
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
                { text: "Keterangan", value: "keterangan" },
                { text: "Actions", value: "actions" },
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
        setForm() {
            if (this.inputType !== "Tambah") {
            this.updateData();
            } else {
            this.saveData();
            }
        },

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
    
        saveData() {
            this.announcement.append("nama_produk", this.form.nama_produk);
            this.announcement.append("status", this.form.status);
            this.announcement.append("keterangan", this.form.keterangan);
    
            var url = this.$api + "/announcement";
            this.load = true;
            this.$http
            .post(url, this.announcement, {
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
    
        updateData() {
            let newData = {
            nama_produk: this.form.nama_produk,
            status: this.form.status,
            keterangan: this.form.keterangan,
            };
            var url = this.$api + "/announcement/" + this.idEdit;
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
    
        setDelete() {
            var url = this.$api + "/announcement/" + this.idDelete;
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
                this.announcements.splice(this.index, 1);
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
            this.form.nama_produk = item.nama_produk;
            this.form.status = item.status;
            this.form.keterangan = item.keterangan;
            this.dialog = true;
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
            status: null,
            keterangan: null,
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
  
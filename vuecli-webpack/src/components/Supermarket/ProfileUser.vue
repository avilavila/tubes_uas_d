<template>
    <v-main>
        <v-card class="col-md-12">
            <v-alert outlined color="green">
            <v-list-item>
                <div>
                <v-list-item>
                    <v-list-item-content>
                    <v-list-item-title class="text-h4 pb-5 green--text">PROFILE USER</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
                <div class="photo-h4 pb-5--photo">
                    <img
                    src="https://assets.kompasiana.com/items/album/2021/03/24/blank-profile-picture-973460-1280-605aadc08ede4874e1153a12.png?t=o&v=770"
                    style="width: 300px; height: 300px"
                    />
                    <v-list-item-content class="ml-2 dark green--text">
                        <v-list-item-title class="headline mb-2 text-left"> Nama : {{ users.name }} </v-list-item-title>
                        <v-list-item-title class="headline mb-2 text-left"> Username : {{ users.username }} </v-list-item-title>
                        <v-list-item-title class="headline mb-2 text-left"> Email : {{ users.email }} </v-list-item-title>
                    </v-list-item-content>
                </div>
                </div>
            </v-list-item>
  
            <v-card-title>
                <v-spacer></v-spacer>
    
                <v-btn color="green lighten-1" dark @click="(dialog = true), editItem(users)"><v-icon>mdi-account-cog</v-icon></v-btn>
                <v-btn color=" ml-1 red" dark @click="deleteItem(users.id)"><v-icon> mdi-delete-circle </v-icon></v-btn>
            </v-card-title>
        </v-alert>
    </v-card>
  
    <v-dialog v-model="dialog" persistent width="500px">
        <v-card>
            <v-card-title>
                <span class="headline">{{ formTitle }} Profile</span>
            </v-card-title>
            <v-card-text>
                <v-container>
                    <v-text-field v-model="form.name" label="Nama" required></v-text-field>
                    <v-text-field v-model="form.username" label="Username" required></v-text-field>
                    <v-text-field v-model="form.email" label="Email" required></v-text-field>
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
            <v-sheet class="px-7 pt-7 pb-4 mx-auto text-center">
                <div class="black--text text--lighten-1 text-body-2 mb-4">Hapus akun?</div>
                <v-btn plain color="red" @click="dialogConfirm = false">No</v-btn>
                <v-btn plain color="green" @click="setDelete">Yes</v-btn>
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
    name: "UserList",
    data() {
      return {
        inputType: "Edit",
        load: false,
        snackbar: false,
        error_message: "",
        color: "",
        search: null,
        dialog: false,
        dialogConfirm: false,
        headers: [
          {
            text: "Nama",
            align: "start",
            sortable: true,
            value: "name",
          },
          { text: "Email", value: "email" },
          { text: "Username", value: "username" },
          { text: "Actions", value: "actions" },
        ],
        user: new FormData(),
        users: [],
        form: {
          name: null,
          email: null,
          username: null,
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
            var url = this.$api + "/userprofile/" + localStorage.getItem("id");
            this.$http
            .get(url, {
                headers: {
                Authorization: "Bearer " + localStorage.getItem("token"),
                },
            })
            .then((response) => {
                this.users = response.data.data;
            });
        },
    
        updateData() {
            let newData = {
            name: this.form.name,
            email: this.form.email,
            username: this.form.username,
            };
            var url = this.$api + "/userupdate/" + localStorage.getItem("id");
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
            var url = this.$api + "/user/" + this.idDelete;
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
                this.close();
                this.readData();
                this.inputType = "Tambah";
                this.$router.push({
                name: "Home",
                });
            })
            .catch((error) => {
                this.error_message = error.response.data.message;
                this.color = "red";
                this.snackbar = true;
                this.load = false;
            });
        },
    
        editItem(users) {
            this.inputType = "Edit";
            this.idEdit = users.id;
            this.form.name = users.name;
            this.form.username = users.username;
            this.form.email = users.email;
            this.dialog = true;
        },
    
        deleteItem(id) {
            this.idDelete = id;
            this.dialogConfirm = true;
        },
    
        close() {
            this.dialog = false;
            this.dialogConfirm = false;
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
            name: null,
            email: null,
            username: null,
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
    },
  };
  </script>
  
  <style>
  .photo {
    margin: auto;
    padding: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 10px;
    text-align: center;
  }
  .photo img {
    width: 100%;
    margin-left: 20%;
  }
  </style>
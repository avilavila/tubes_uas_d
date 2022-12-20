<template>
    <v-main class="list">
        <v-card>
            <v-list-item>
                <v-list-item-avatar color="grey"></v-list-item-avatar>
                <v-list-item-content>
                    <v-list-item-title class="headline">ANNOUNCEMENT</v-list-item-title>
                    <v-list-item-subtitle>Supermarket</v-list-item-subtitle>
                </v-list-item-content>
            </v-list-item>
            <v-card-title>
                <v-text-field
                  v-model="search"
                  append-icon="mdi-magnify"
                  Label="Search"
                  outlined
                  hide 
                  details 
                  style="margin-top: 30px"
                ></v-text-field>
                <v-spacer></v-spacer>
                <!-- <v-btn color="success" dark @click="dialogTambah = true"> Tambah </v-btn> -->
            </v-card-title>
        </v-card>
        <v-card>
            <v-data-table :headers="headers" :items="announcements" :search="search">
              <!-- <template v-slot:[`item.actions`]="{ item }">
                <v-btn small fab dark class="mr-2 red" @click="setFormEdit(item)"><v-icon dark>mdi-pencil-circle</v-icon></v-btn>
                <v-btn small fab dark class="mr-2 green" @click="setDelete(item)"><v-icon dark>mdi-delete-circle</v-icon></v-btn>
              </template> -->
            </v-data-table>
        </v-card>
        <!-- <v-dialog v-model="dialogTambah" persistent max-width="600px">
        <v-card>
            <v-card-title>
                <span class="headline"> ANNOUNCEMENT </span>
            </v-card-title>
            <v-card-text>
                <v-container>
                    <v-text-field
                      v-model="announcement.nama_produk"
                      label="Nama Produk"
                      required 
                    ></v-text-field>

                    <v-textarea
                      v-model="announcement.keterangan"
                      label="Keterangan"
                      required 
                    ></v-textarea>

                    <v-select
                      v-model="announcement.status"
                      :items="[`Ready`, `Sold Out`]"
                      label="Status"
                      required 
                    ></v-select>
                </v-container>
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" text @click="cancel"> Cancel </v-btn>
                <v-btn color="blue darken-1" text @click="save"> Save </v-btn>
            </v-card-actions>
        </v-card>
        </v-dialog>

        <v-dialog v-model="dialogEdit" persistent max-width="600px">
        <v-card>
            <v-card-title>
                <span class="headline"> Edit Announcement </span>
            </v-card-title>
            <v-card-text>
                <v-container>
                    <v-text-field
                      v-model="announcement.nama_produk"
                      label="Nama Produk"
                      required 
                    ></v-text-field>

                    <v-textarea
                      v-model="announcement.keterangan"
                      label="Keterangan"
                      required 
                    ></v-textarea>

                    <v-select
                      v-model="announcement.status"
                      :items="[`Ready`, `Sold Out`]"
                      label="Status"
                      required 
                    ></v-select>
                </v-container>
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" text @click="cancelEdit"> Cancel </v-btn>
                <v-btn color="blue darken-1" text @click="saveEdit"> Save </v-btn>
            </v-card-actions>
        </v-card>
        </v-dialog>

        <v-dialog v-model="dialogDelete" persistent max-width="600px">
        <v-card>
            <v-card-text>
                <v-container>
                    <span class="headline"> Are you sure to delete? </span>
                </v-container>
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="green" text @click="yes(item)"> YES </v-btn>
                <v-btn color="red" text @click="no"> NO </v-btn>
            </v-card-actions>
        </v-card>
        </v-dialog> -->
    </v-main>
</template>

<script>
export default {
    name: "ListItem",
    data() {
        return{
            search: null,
            dialogTambah: false,
            dialogEdit: false,
            dialogDelete: false,
            index: 0,
            headers: [
                {
                    text: "Nama Produk",
                    align: "start",
                    sortable: true,
                    value: "nama_produk",
                },
                { text: "Keterangan", value: "keterangan" },
                { text: "Status", value: "status" },
                // { text: "Actions", value: "actions" },
            ],
            announcements: [
                {
                    nama_produk: "Oreo",
                    keterangan: "Restock minggu depan",
                    status: "Sold Out",
                    open: false,
                },
                {
                    nama_produk: "Lemonilo",
                    keterangan: "Free PC NCT Dream",
                    status: "Ready",
                    open: false,
                },
                {
                    nama_produk: "Ultra Milk",
                    keterangan: "Free PC ITZY",
                    status: "Ready",
                    open: false,
                },
            ],
            announcement: {
                nama_produk: null,
                keterangan: null,
                status: null,
                open: false,
            },
            itemEdit: null,
            itemDelete: null,
        };
    },
    methods: {
        save() {
            this.announcements.push(this.announcement);
            this.resetForm();
            this.dialogTambah = false;
        },
        cancel() {
            this.resetForm();
            this.dialogTambah = false;
        },
        setFormEdit(item){
            this.itemEdit = item;
            this.announcement.nama_produk = this.itemEdit.nama_produk;
            this.announcement.keterangan = this.itemEdit.keterangan;
            this.announcement.status = this.itemEdit.status
            this.dialogEdit = true;
        },
        saveEdit(){
            this.save();
            this.index = this.announcements.indexOf(this.itemEdit);
            this.announcements.splice(this.index, 1);
            this.dialogEdit = false;
        },
        cancelEdit() {
            this.resetForm();
            this.dialogEdit = false;
        },
        yes(){
            this.index = this.announcements.indexOf(this.itemDelete);
            this.announcements.splice(this.index, 1);
            this.dialogDelete = false;
        },
        no(){
            this.dialogDelete = false;
        },
        resetForm() {
            this.announcement = {
                nama_produk: null,
                keterangan: null,
                status: null,
                open: false,
            };
        },
        setDelete(item){
            this.itemDelete = item;
            this.dialogDelete = true;
        },
    },
};
</script>
<style>
  .text {
    font-family: "Franklin Gothic Medium", "Arial Narrow", Arial, sans-serif;
    font-size: 40px;
    font-style: italic;
  }
</style>
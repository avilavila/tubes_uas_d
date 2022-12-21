<template>
    <div class="dashboard">
      <v-navigation-drawer class="fullheight" width="256" v-model="drawer" absolute temporary color="grey lighten-5">
        <v-list-item>
          <v-list-item-content>
            <v-list-item-title class="title">SUPERMARKET</v-list-item-title>
            <v-list-item-subtitle>Kelompok D</v-list-item-subtitle>
          </v-list-item-content>
        </v-list-item>
  
        <v-divider></v-divider>
  
        <v-list dense nav>
          <v-list-item v-for="item in items" :key="item.title" link color="light-green darken-4" tag="router-link" :to="item.to">
            <v-list-item-content>
              <v-list-item-title>{{ item.title }}</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </v-list>
      </v-navigation-drawer>

      <v-app-bar color="green lighten-3" dark>
        <v-app-bar-nav-icon @click="drawer = true" color="white"></v-app-bar-nav-icon>
        <VSpacer />

        <v-toolbar-items>
        <v-btn text router @click="logout()" color="white"><v-icon>mdi-power</v-icon></v-btn>
      </v-toolbar-items>

      </v-app-bar>
      <div class="fullheight pa-5">
        <router-view></router-view>
      </div>
    </div>
  </template>

<script>
  export default {
    name: "DashboardLayout",
    data() {
      return {
        users: [],
        drawer: false,
        items: [
          { title: "Dashboard", to: "/dashboardindex" },
          { title: "Produk", to: "/produk" },
          { title: "Announcement", to: "/announcement" },
          { title: "Keranjang", to: "/keranjang" },
        ],
      };
    },
    methods: {
    logout() {
      localStorage.removeItem("id");
      localStorage.removeItem("token");
      //location.reload();
      this.$router.push({
        name: "HomeDashboard",
      });
    },
    readData() {
      var url = this.$api + "/getuser/" + localStorage.getItem("id");
      this.$http
        .get(url, {
          headers: {
            Authorization: "Bearer" + localStorage.getItem("token"),
          },
        })
        .then((response) => {
          this.users = response.data.data;
        });
    },
  },

  mounted() {
    this.readData();
  },
};
</script>
  <style scoped>
  .fullheight {
    min-height: 100vh !important;
  }
  </style>
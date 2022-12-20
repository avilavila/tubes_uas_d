<template>
    <main>
      <v-header dark padless>
        <v-card flat tile class="black lighten-1 white--text d-flex pb-3">
          <v-card class="pa-2 mr-auto black mt-3 ml-5">
            <v-text class="white--text"> <strong>Kelompok D</strong> </v-text></v-card
          >
          <v-card class="pa-2 black mt-3">
            <v-btn @click="login" class="grey darken-4 large white--text text-right">Login</v-btn>
          </v-card>
          <v-card class="pa-2 black mt-3 mr-5">
            <v-btn @click="register" class="white black--text text-right">Register</v-btn>
          </v-card>
        </v-card>
      </v-header>
      <v-carousel height="90vh" dark cycle show-arrows-on-hover draggable="true" hide-delimiter-background class="text-center">
        <v-carousel-item v-for="(data, carindex) in data" :key="carindex" :src="data.src" class="gradient-fill">
          <v-container fill-height>
            <div style="max-width: 1200px">
              <div class="text-md-h2 mb-3 text-sm-h3 text-h5 font-weight-black white--text">
                {{ data.heading.toUpperCase() }}
              </div>
  
              <p class="mb-5 white--text">{{ data.subHeading }}</p>
  
 
            </div>
          </v-container>
        </v-carousel-item>
      </v-carousel>
      <v-footer dark padless>
        <v-card flat tile class="flex">
          
          <v-divider></v-divider>
  
          <v-card-text class="black white--text text-center"><strong>Kelompok D</strong> </v-card-text>
        </v-card>
      </v-footer>
    </main>
  </template>
  
  <script>
  export default {
    data() {
      return {
        data: [
          {
            src: "https://image.freepik.com/free-vector/supermarket_182089-133.jpg",
            heading: " Market ",
            subHeading:
              "Infographic hypotheses influencer user experience Long madel ture gen-z paradigm shift client partner network product seilans solve management influencer analytics leverage virality. incubator seed round massmarket. buyer agile development growth hacking business-to-consumer ecosystem ",
          },

        ],

      };
    },
    methods: {
      register() {
        this.$router.push({
          name: "RegisterPage",
        });
      },
      login() {
        this.$router.push({
          name: "LoginPage",
        });
      },
    },
  };
  </script>
  
  <style>
  .gradient-fill .v-responsive__content {
    background: linear-gradient(to left, rgba(3, 12, 41, 0.8), rgba(5, 11, 31, 0.65));
  }
  .carousel-item img {
    height: 100vh !important;
  }
  </style>
  
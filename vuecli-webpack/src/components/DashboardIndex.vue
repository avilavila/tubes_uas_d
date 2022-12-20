<template>
  <v-main>
    <v-carousel height="90vh" dark show-arrows-on-hover draggable="true" hide-delimiter-background class="text-center mb-5">
      <v-carousel-item v-for="(data, carindex) in data" :key="carindex" :src="data.src" class="gradient-fill">
        <v-container fill-height>
          <div style="max-width: 1200px">
            <div class="text-md-h2 mb-3 text-sm-h3 text-h5 font-weight-black green--text text-center">
              {{ data.heading.toUpperCase() }}
            </div>
            <p class="mb-5 green --text">{{ data.subHeading }}</p>
          </div>
        </v-container>
      </v-carousel-item>
    </v-carousel>
    <v-item-group>
      <v-container>
        <v-row>
          <v-col v-for="card in cards" :key="card.title" :cols="card.flex">
            <v-card outlined color="green" prominent>
              <v-img height="250" :src="card.src" class="white--text align-end"> <v-card-title v-text="card.title" class="green lighten-1 bold--text"></v-card-title></v-img>

              <v-card-text class="white green--text">
                <v-card-title><strong> MAROL </strong></v-card-title>
                <div class="my-4 text-subtitle-1">Belanja hemat di MAROL</div>
              </v-card-text>
              <v-card-actions class="white">
                <v-btn color="white" class="green ms-auto" @click="reserve">Buy </v-btn>
              </v-card-actions>
            </v-card>
          </v-col>
        </v-row>
      </v-container>
    </v-item-group>
  </v-main>
</template>
<style>
.text {
  font-family: "Franklin Gothic Medium", "Arial Narrow", Arial, sans-serif;
}

.gradient-fill .v-responsive__content {
  background: linear-gradient(to left, rgba(3, 12, 41, 0.8), rgba(5, 11, 31, 0.65));
}
.carousel-item img {
  height: 100vh !important;
}
</style>
<script>
export default {
  data: () => ({
    cards: [
      { title: "Oreo", src: "https://cdn-asset.jawapos.com/wp-content/uploads/2022/12/oreo-chandra.jpg", flex: 3 },
      { title: "Ultra Milk", src: "https://cf.shopee.co.id/file/8d89f6a1bc98492d499caa1d5f08dc1c", flex: 3 },
      { title: "Lemonilo", src: "https://images.tokopedia.net/img/cache/500-square/VqbcmM/2022/1/28/7e02dc36-2047-434b-92a9-60047544491a.jpg", flex: 3 },
      { title: "Indomie", src: "https://awsimages.detik.net.id/community/media/visual/2019/11/11/8b3c99cb-6527-4163-99f9-f6fbce370511_169.jpeg?w=700&q=90", flex: 3 },
    ],
    data: [
      {
        src: "https://image.freepik.com/free-vector/supermarket_182089-133.jpg",
        heading: "PRODUK",
        subHeading: "Belanja apa saja dengan harga terjamin? Hanya di MAROL!",
      },
      {
        src: "https://pa-pagaralam.go.id/images/demo/anoun.png",
        heading: "ANNOUNCEMENT",
        subHeading: "Yuk lihat info terupdate disini.",
      },
      
    ],
  }),

  methods: {
    reserve() {
      this.$router.push({
        name: "Produk",
      });
    },
  },
};
</script>

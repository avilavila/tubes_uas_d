import Vue from "vue";
import VueRouter from "vue-router";

Vue.use(VueRouter);

function importComponent(path) {
  return () => import(`@/components/${path}.vue`);
}

const router = new VueRouter({
  mode: "history",
  routes: [
    {
      path: "/",
      name: "HomeDashboard",
      meta: { title: "HomeDashboard" },
      component: importComponent("HomeDashboard"),
    },

    {
      path: "/login",
      name: "LoginPage",
      meta: { title: "LoginPage" },
      component: importComponent("LoginPage"),
    },

    {
      path: "/register",
      name: "RegisterPage",
      meta: { title: "RegisterPage" },
      component: importComponent("RegisterPage"),
    },
    {
      path: "/",
      component: importComponent("DashboardLayout"),
      children: [
        //Dashboard
        {
          path: "/dashboardindex",
          name: "DashboardIndex",
          meta: { title: "DashboardIndex" },
          component: importComponent("DashboardIndex"),
        },

        //Announcement
        {
          path: "/announcement",
          name: "Announcement",
          meta: { title: "Announcement" },
          component: importComponent("Supermarket/AnnouncementList"),
        },

         //Produk
        {
          path: "/produk",
          name: "Produk",
          meta: { title: "Produk" },
          component: importComponent("Supermarket/ProdukList"),
        },
        
         //Beli
        {
          path: "/keranjang",
          name: "Keranjang",
          meta: { title: "Keranjang" },
          component: importComponent("Supermarket/KeranjangList"),
        },


      ],

      
    },
    {
      path: "/DashboardLayoutAdmin",
      component: importComponent("Admin/Dashboard/DashboardLayout"),
      children: [
        //Dashboard
        {
          path: "/dashboardindexadmin",
          name: "DashboardIndexAdmin",
          meta: { title: "DashboardIndexAdmin" },
          component: importComponent("Admin/Dashboard/DashboardIndex"),
        },

        //Announcement
        { 
          path: "/announcementAdmin",
          name: "AnnouncementAdmin",
          meta: { title: "AnnouncementAdmin" },
          component: importComponent("Admin/Supermarket/AnnouncementList"),
        },


         //Produk
         {
          path: "/produkAdmin",
          name: "ProdukAdmin",
          meta: { title: "ProdukAdmin" },
          component: importComponent("Admin/Supermarket/ProdukList"),
        },


      ],

      
    },
  ],
});

router.beforeEach((to, from, next) => {
  if (to.name != "LoginPage" && localStorage.getItem("token") == null && to.name != "RegisterPage" && to.name != "HomeDashboard") {
    next("homedashboard");
    document.to.meta.title = "HomeDashboard";
  }

  document.title = to.meta.title;
  next();
});

export default router;

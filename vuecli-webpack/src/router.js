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
      path: "/homedashboard",
      name: "HomeDashboard",
      meta: { title: "HomeDashboard" },
      component: importComponent("HomeDashboard"),
    },

    {
      path: "/loginpage",
      name: "LoginPage",
      meta: { title: "LoginPage" },
      component: importComponent("LoginPage"),
    },

    {
      path: "/registerpage",
      name: "RegisterPage",
      meta: { title: "RegisterPage" },
      component: importComponent("RegisterPage"),
    },
    {
      path: "/",
      name: "admin",
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
          component: importComponent("Supermarket/AnnouncementList"),
        },


      ],

      
    },
  ],
});

export default router;

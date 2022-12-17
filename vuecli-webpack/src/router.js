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
      name: "admin",
      component: importComponent("DashboardLayout"),
      children: [
        //Dashboard
        {
          path: "/",
          name: "Root",
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

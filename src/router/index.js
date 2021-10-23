import VueRouter from "vue-router";

import AllForm from "../pages/AllForm.vue";
import NewForm from "../pages/NewForm.vue";
import EditForm from "../pages/EditForm.vue";
import PreviewForm from "../pages/PreviewForm.vue";
import Entries from "../pages/Entries.vue";

const routes = [
  { path: "/", component: AllForm },
  { path: "/new-form", component: NewForm },
  { path: "/edit-form/:id", component: EditForm },
  { path: "/preview-form/:id", component: PreviewForm },
  { path: "/entries", component: Entries },
];

const router = new VueRouter({
  routes,
});

export default router;

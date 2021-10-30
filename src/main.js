import { createApp } from "vue";

import VueClipboard from "vue3-clipboard";

import store from "./store";
import router from "./router";

import App from "./App.vue";

const app = createApp(App).use(router).use(store);

app.config.productionTip = false;

app.use(VueClipboard, {
  autoSetContainer: true,
  appendToBody: true,
});

app.mount("#app");

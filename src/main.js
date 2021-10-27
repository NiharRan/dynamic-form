import Vue from "vue";
import VueRouter from "vue-router";
import Vuex from "vuex";

import VueClipboard from 'vue-clipboard2'

VueClipboard.config.autoSetContainer = true // add this line
Vue.use(VueClipboard)

Vue.use(VueRouter);
Vue.use(Vuex);

import store from "./store";
import alertMixin from "./mixins/alert";
import helperMixin from "./mixins/helper";

Vue.mixin(alertMixin);
Vue.mixin(helperMixin);

import router from "./router";

import App from "./App.vue";

Vue.config.productionTip = false;

new Vue({
  el: "#app",
  router,
  store,
  render: (h) => h(App),
});

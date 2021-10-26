import Vue from "vue";
import Vuex from "vuex";

import { getters } from "./getters";
import { mutations } from "./mutations";
import { actions } from "./actions";

Vue.use(Vuex);

export default new Vuex.Store({
  state: {
    formData: null,
    forms: [],
    form: null,
    entries: [],
    is_updated: false
  },
  actions,
  getters,
  mutations,
});

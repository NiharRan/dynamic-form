import { createStore } from "vuex";

import { getters } from "./getters";
import { mutations } from "./mutations";
import { actions } from "./actions";

export default createStore({
  state: {
    formData: null,
    forms: [],
    form: null,
    entries: [],
    field: {
      id: 0,
      dynamic_form_id: "",
      label: "",
      placeholder: "",
      name: "",
      field_id: "",
      width: "",
      height: "",
      type: "",
      input_type: "",
      rows: "",
      is_required: false,
      options: [],
      is_new: true,
    },
    is_updated: false,
    is_visible: false,
  },
  actions,
  getters,
  mutations,
});

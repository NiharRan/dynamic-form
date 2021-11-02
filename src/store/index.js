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
    headers: [
      { name: "Title", key: "title", classes: "text-left" },
      { name: "Shortcode", key: "shortcode", classes: "text-left" },
      { name: "Classes", key: "classes", classes: "text-left" },
      { name: "Form ID", key: "form_id", classes: "text-left" },
      { name: "Entries", key: "entries", classes: "text-center" },
      { name: "Status", key: "status", classes: "text-center" },
    ],
    is_updated: false,
    is_visible: false,
  },
  actions,
  getters,
  mutations,
});

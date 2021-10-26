import router from "../router";

export const actions = {
  GET_UNIQUE_SHORTCODE: async function({ commit }) {
    const response = await jQuery.ajax({
      type: "GET",
      url: "/wp-json/dynamic-form/v1/shortcodes",
      dataType: "JSON",
    });
    if (response) {
      commit("SET_FORM_SHORTCODE", response.shortcode);
    }
  },
  GENERATE_SLUG: function({ state }) {
    state.form.slug = state.form.title
      .toLowerCase()
      .replace(/ /g, "-")
      .replace(/[^\w-]+/g, "");
  },
  CREATE_NEW_FORM: async function({ state, dispatch }) {
    const response = await jQuery.ajax({
      type: "POST",
      url: "/wp-json/dynamic-form/v1/forms/empty",
      dataType: "JSON",
    });

    if (response) {
      state.form = response;
      router.push(`/edit-form/${response.id}`);
      dispatch("UPDATE_STATUS", true);
    }
  },
  FETCH_ALL_FORMS: async function({ commit }) {
    const response = await jQuery.ajax({
      type: "GET",
      url: `/wp-json/dynamic-form/v1/forms`,
      dataType: "JSON",
    });
    if (response) {
      commit("UPDATE_FORMS", response);
    }
  },

  DESTROY_FORM: async function({ dispatch }, id) {
    const response = await jQuery.ajax({
      type: "DELETE",
      url: "/wp-json/dynamic-form/v1/forms",
      data: { id },
    });
    dispatch("FETCH_ALL_FORMS");
    dispatch("UPDATE_STATUS", true);
  },

  SET_EMPTY_FIELD: function({ state, dispatch }, payload) {
    state.form.fields.unshift(payload);
    dispatch("UPDATE_STATUS", true);
  },
  SET_EMPTY_OPTION: function({ state, dispatch }, payload) {
    state.form.fields[payload.key].options.unshift(payload.option);
    dispatch("UPDATE_STATUS", true);
  },
  REMOVE_OPTION_FROM_LIST: async function({ state, dispatch }, payload) {
    const option = state.form.fields[payload.key].options[payload.k];
    if (option && option.id != 0) {
      await jQuery.ajax({
        type: "DELETE",
        url: "/wp-json/dynamic-form/v1/forms/fields/options",
        data: { id: option.id },
        dataType: "JSON",
      });
    }
    state.form.fields[payload.key].options.splice(payload.k, 1);
    dispatch("UPDATE_STATUS", true);
  },
  REMOVE_FIELD: async function({ state, dispatch }, payload) {
    console.log(payload);
    const field = state.form.fields[payload];
    if (field && field.id != 0) {
      const response = await jQuery.ajax({
        type: "DELETE",
        url: "/wp-json/dynamic-form/v1/forms/fields",
        data: { id: field.id },
        dataType: "JSON",
      });
    }
    state.form.fields.splice(payload, 1);
    dispatch("UPDATE_STATUS", true);
  },

  SET_FORM: async function({ commit, state }, payload) {
    const response = await jQuery.ajax({
      type: "GET",
      url: `/wp-json/dynamic-form/v1/forms/find`,
      data: { id: payload },
      dataType: "JSON",
    });
    if (response) {
      commit("SETING_FORM", response);
    }
  },

  UPDATE_STATUS: function({ state }, payload) {
    state.is_updated = payload;
  },

  UPDATE_FORM: async function({ commit, dispatch }, payload) {
    const response = await jQuery.ajax({
      type: "PUT",
      url: `/wp-json/dynamic-form/v1/forms`,
      data: payload,
      dataType: "JSON",
    });
    if (response) {
      commit("SETING_FORM", response.data);
      dispatch("UPDATE_STATUS", true);
    }
  },

  FETCH_ALL_ENTRIES: async function({ commit }, payload) {
    const response = await jQuery.ajax({
      type: "GET",
      url: `/wp-json/dynamic-form/v1/entries`,
      data: { id: payload },
      dataType: "JSON",
    });
    if (response) {
      commit("UPDATE_ENTRIES", response);
    } else {
      commit("UPDATE_ENTRIES", []);
    }
  },
};

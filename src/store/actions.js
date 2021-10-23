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
  CREATE_NEW_FORM: async function({ commit, state }) {
    const response = await jQuery.ajax({
      type: "POST",
      url: "/wp-json/dynamic-form/v1/forms/empty",
      dataType: "JSON",
    });

    if (response) {
      state.form = response;
      router.push(`/edit-form/${response.id}`);
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

  SET_EMPTY_FIELD: function({ state }, payload) {
    state.form.fields.unshift(payload);
  },
  SET_EMPTY_OPTION: function({ state }, payload) {
    state.form.fields[payload.key].options.unshift(payload.option);
  },
  REMOVE_OPTION_FROM_LIST: async function({ state }, payload) {
    const option = state.form.fields[payload.key].options[payload.k];
    if (option && option.id != 0) {
      const response = await jQuery.ajax({
        type: "DELETE",
        url: "/wp-json/dynamic-form/v1/forms/fields/options",
        data: { id: option.id },
        dataType: "JSON",
      });
    }
    state.form.fields[payload.key].options.splice(payload.k, 1);
  },
  STORE_FIELD: async function({ state, dispatch }, payload) {
    const field = state.form.fields[payload];
    const option_ids = await field.options.map((option) => option.id);
    const option_values = await field.options.map((option) => option.value);
    const option_texts = await field.options.map((option) => option.text);

    field.option_ids = option_ids;
    field.option_values = option_values;
    field.option_texts = option_texts;

    const response = await jQuery.ajax({
      type: "POST",
      url: "/wp-json/dynamic-form/v1/forms/fields",
      data: field,
      dataType: "JSON",
    });

    if (response) {
      dispatch("SET_FORM", response.dynamic_form_id);
    }
  },

  UPDATE_FIELD: async function({ state, dispatch }, payload) {
    const field = state.form.fields[payload];
    const option_ids = await field.options.map((option) => option.id);
    const option_values = await field.options.map((option) => option.value);
    const option_texts = await field.options.map((option) => option.text);
    field.option_ids = option_ids;
    field.option_values = option_values;
    field.option_texts = option_texts;

    const response = await jQuery.ajax({
      type: "PUT",
      url: "/wp-json/dynamic-form/v1/forms/fields",
      data: field,
      dataType: "JSON",
    });

    if (response) {
      dispatch("SET_FORM", response.dynamic_form_id);
      state.field = null;
    }
  },

  REMOVE_FIELD: async function({ state }, payload) {
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
  },

  SAVE_DATA: async function({ commit, state }, payload) {
    const response = await jQuery.ajax({
      type: "POST",
      url: "/wp-json/wp-vue/v1/users",
      data: payload,
      dataType: "JSON",
    });
    if (response) {
      state.changed = true;
      router.push("/");
    }
  },

  UPDATE_DATA: async function({ commit, state }, payload) {
    const response = await jQuery.ajax({
      type: "PUT",
      url: `/wp-json/wp-vue/v1/users`,
      data: payload,
      dataType: "JSON",
    });
    if (response) {
      state.changed = true;
      router.push("/");
    }
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

  UPDATE_FORM: async function({ commit }, payload) {
    const response = await jQuery.ajax({
      type: "PUT",
      url: `/wp-json/dynamic-form/v1/forms`,
      data: payload,
      dataType: "JSON",
    });
    if (response) {
      commit("SETING_FORM", response);
    }
  },

  CHANGED_ACTION: function({ commit, state }, payload) {
    state.changed = payload;
  },
  CHANGED_ACTION_MESSAGE: function({ commit, state }, payload) {
    state.message = payload;
  },
};

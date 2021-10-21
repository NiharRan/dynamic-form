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
    state.formData.slug = state.formData.title
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
      state.formData = response;
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
    state.field = payload;
  },

  STORE_FIELD: async function({ state, dispatch }, payload) {
    const response = await jQuery.ajax({
      type: "POST",
      url: "/wp-json/dynamic-form/v1/forms/fields",
      data: payload,
      dataType: "JSON",
    });

    if (response) {
      dispatch("SET_FORM", response.dynamic_form_id);
      state.field = null;
    }
  },

  UPDATE_FIELD: async function({ state, dispatch }, payload) {
    const response = await jQuery.ajax({
      type: "PUT",
      url: "/wp-json/dynamic-form/v1/forms/fields",
      data: payload,
      dataType: "JSON",
    });

    if (response) {
      dispatch("SET_FORM", response.dynamic_form_id);
      state.field = null;
    }
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

  CHANGED_ACTION: function({ commit, state }, payload) {
    state.changed = payload;
  },
  CHANGED_ACTION_MESSAGE: function({ commit, state }, payload) {
    state.message = payload;
  },
};

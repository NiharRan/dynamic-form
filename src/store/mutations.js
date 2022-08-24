export const mutations = {
  SET_FORM_SHORTCODE: (state, payload) => {
    state.formData.shortcode = payload;
  },
  UPDATE_FORMS: (state, payload) => {
    state.forms = payload;
  },
  SETING_FORM: (state, payload) => {
    state.form = payload;
  },
  UPDATE_ENTRIES: (state, payload) => {
    state.entries = payload;
  },
};

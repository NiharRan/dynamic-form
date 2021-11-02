import { useStore } from "vuex";
import useAlert from "./useAlert";

export default function useFormEdit(form, field) {
  const { $confirm } = useAlert();
  const store = useStore();

  const removeField = async function (key) {
    const result = await $confirm("This field will be removed permanently");
    if (result.isConfirmed) {
      store.dispatch("REMOVE_FIELD", key);
    }
  };
  const addSelectOption = function (key) {
    const field = form.value.fields[key];
    const option = {
      id: 0,
      value: "",
      text: "",
      form_field_id: field.id,
    };

    store.dispatch("SET_EMPTY_OPTION", { option, key });
  };
  const removeSelectedOption = async function (key, k) {
    const result = await $confirm(
      "This field option will be removed permanently"
    );
    if (result.isConfirmed) {
      const payload = { key: key, k: k };
      store.dispatch("REMOVE_OPTION_FROM_LIST", payload);
    }
  };

  const addField = function () {
    field.value.dynamic_form_id = form.value.id;
    store.dispatch("SET_EMPTY_FIELD", field.value);
  };
  const updateForm = function () {
    store.dispatch("UPDATE_FORM", form.value);
  };

  return {
    addField,
    removeField,
    addSelectOption,
    removeSelectedOption,
    updateForm,
  };
}

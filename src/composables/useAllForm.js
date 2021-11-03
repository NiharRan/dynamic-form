import { useStore } from "vuex";
import useAlert from "./useAlert";

export default function useAllForm(form) {
  const store = useStore();
  const { $confirm } = useAlert();
  const showDuplicateForm = function (row) {
    form.id = row.id;
    store.dispatch("UPDATE_MODAL_STATUS", true);
  };

  const duplicate = function () {
    store.dispatch("DEPLICATE_FORM", form);
  };

  const destroy = async function (id) {
    const result = await $confirm("This form will be removed permanently");
    if (result.isConfirmed) {
      store.dispatch("DESTROY_FORM", id);
    }
  };

  const hideModel = function () {
    store.dispatch("UPDATE_MODAL_STATUS", false);
    form.title = "";
    form.slug = "";
    form.id = "";
  };

  return {
    showDuplicateForm,
    duplicate,
    destroy,
    hideModel,
  };
}

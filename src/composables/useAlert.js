import Swal from "sweetalert2";
import { useStore } from "vuex";
import { watch, computed } from "vue";

const Toast = Swal.mixin({
  toast: true,
  position: "top-end",
  showConfirmButton: false,
  timer: 3000,
  timerProgressBar: true,
  didOpen: (toast) => {
    toast.addEventListener("mouseenter", Swal.stopTimer);
    toast.addEventListener("mouseleave", Swal.resumeTimer);
  },
});

export default function () {
  const store = useStore();
  let is_updated = computed(function () {
    return store.state.is_updated;
  });

  watch(is_updated, function (value) {
    $toast("Data updated successfully", "success");
    store.dispatch("UPDATE_STATUS", false);
  });

  const $toast = function (message, type) {
    return Toast.fire({
      icon: type,
      title: message,
    });
  };
  const $confirm = async function (message, confirmText = "Yes, delete it!") {
    return await Swal.fire({
      title: "Are you sure?",
      text: message,
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: confirmText,
    });
  };

  return {
    $toast,
    $confirm,
  };
}

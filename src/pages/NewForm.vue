<template>
  <div class="bg-white shadow-lg p-4 w-full m-auto">
    <h1 class="flex justify-between items-center !p-0">
      <span>Generate New Form</span>
      <div class="flex">
        <router-link
          to="/"
          class="
            px-4
            py-2
            block
            mr-4
            bg-indigo-100
            text-indigo-500
            font-bold
            hover:text-indigo-600 hover:bg-indigo-200
            transition-all
            delay-300
            ease-in-out
          "
        >
          <icon-close />
        </router-link>
        <btn-success v-if="!formData" @click="createNewForm" class="px-4 py-2">
          <icon-plus />
        </btn-success>
      </div>
    </h1>
  </div>
</template>

<script>
import { computed, watch } from "vue";
import { useStore } from "vuex";
import useAlert from "../mixins/useAlert";
import { IconPlus, IconClose } from "../components/icons";
import { BtnSuccess } from "../components/buttons";
export default {
  components: { IconPlus, BtnSuccess, IconClose },
  setup() {
    const store = useStore();
    const { $toast } = useAlert();
    let formData = computed(function () {
      return store.state.formData;
    });
    let is_updated = computed(function () {
      return store.state.is_updated;
    });

    watch(is_updated, function (value) {
      $toast("Data updated successfully", "success");
      store.dispatch("UPDATE_STATUS", false);
    });

    // methods
    const createNewForm = function () {
      store.dispatch("CREATE_NEW_FORM");
    };

    return { formData, is_updated, createNewForm };
  },
};
</script>

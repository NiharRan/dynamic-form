<template>
  <div class="bg-white shadow-lg p-4 w-full m-auto">
    <h1 class="flex justify-between items-center !p-0">
      <span>Generate New Form</span>
      <div class="flex">
        <router-link to="/" class="link-btn">
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
import { computed } from "vue";
import { useStore } from "vuex";
import { IconPlus, IconClose } from "../components/icons";
import { BtnSuccess } from "../components/buttons";
export default {
  components: { IconPlus, BtnSuccess, IconClose },
  setup() {
    const store = useStore();
    let formData = computed(function () {
      return store.state.formData;
    });

    // methods
    const createNewForm = function () {
      store.dispatch("CREATE_NEW_FORM");
    };

    return { formData, createNewForm };
  },
};
</script>

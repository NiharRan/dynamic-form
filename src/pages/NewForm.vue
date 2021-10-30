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
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-5 w-5"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M12 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2M3 12l6.414 6.414a2 2 0 001.414.586H19a2 2 0 002-2V7a2 2 0 00-2-2h-8.172a2 2 0 00-1.414.586L3 12z"
            />
          </svg>
        </router-link>
        <button
          type="button"
          v-if="!formData"
          @click="createNewForm"
          class="
            px-4
            py-2
            bg-green-100
            text-green-500
            hover:text-green-600 hover:bg-green-200
            transition-all
            delay-300
            ease-in-out
          "
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-5 w-5"
            viewBox="0 0 20 20"
            fill="currentColor"
          >
            <path
              fill-rule="evenodd"
              d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z"
              clip-rule="evenodd"
            />
          </svg>
        </button>
      </div>
    </h1>
  </div>
</template>

<script>
import { computed, watch } from "vue";
import { useStore } from "vuex";
import useAlert from "../mixins/useAlert";
export default {
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

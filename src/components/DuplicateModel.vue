<template>
  <div
    class="fixed z-10 inset-0 overflow-y-auto"
    v-if="is_visible"
    aria-labelledby="modal-title"
    role="dialog"
    aria-modal="true"
  >
    <div
      class="
        flex
        items-end
        justify-center
        min-h-screen
        pt-4
        px-4
        pb-20
        text-center
        sm:block sm:p-0
      "
    >
      <div
        class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
        aria-hidden="true"
      ></div>

      <!-- This element is to trick the browser into centering the modal contents -->
      <span
        class="hidden sm:inline-block sm:align-middle sm:h-screen"
        aria-hidden="true"
        >&#8203;</span
      >
      <div
        class="
          inline-block
          align-bottom
          bg-white
          rounded-lg
          text-left
          overflow-hidden
          shadow-xl
          transform
          transition-all
          sm:my-8 sm:align-middle sm:max-w-lg sm:w-full
        "
      >
        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
          <h2>Duplicate Form</h2>
          <div class="grid col-span-2">
            <div>
              <input
                type="text"
                class="w-full"
                @keyup="generateSlug"
                v-model="form.title"
                placeholder="Form Title"
              />
            </div>
            <div class="mt-4">
              <input
                type="text"
                class="w-full"
                v-model="form.slug"
                placeholder="Form Slug"
              />
            </div>
          </div>
        </div>
        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
          <button
            type="button"
            @click="$emit('duplicate')"
            class="
              w-full
              inline-flex
              justify-center
              border border-transparent
              shadow-sm
              px-3
              py-1
              bg-green-100
              text-base
              font-medium
              text-green-500
              hover:bg-green-200 hover:text-green-600
              focus:outline-none
              focus:ring-2
              focus:ring-offset-2
              focus:ring-green-300
              sm:ml-3 sm:w-auto sm:text-sm
            "
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="h-5 w-5"
              viewBox="0 0 20 20"
              fill="currentColor"
            >
              <path
                d="M7 9a2 2 0 012-2h6a2 2 0 012 2v6a2 2 0 01-2 2H9a2 2 0 01-2-2V9z"
              />
              <path d="M5 3a2 2 0 00-2 2v6a2 2 0 002 2V5h8a2 2 0 00-2-2H5z" />
            </svg>
          </button>
          <button
            type="button"
            @click="hideModel"
            class="
              mt-3
              w-full
              inline-flex
              justify-center
              border border-transparent
              shadow-sm
              px-3
              py-1
              bg-red-100
              text-base
              font-medium
              text-red-500
              hover:bg-red-200 hover:text-red-600
              focus:outline-none
              focus:ring-2
              focus:ring-offset-2
              focus:ring-red-300
              sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm
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
                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                clip-rule="evenodd"
              />
            </svg>
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { computed } from "vue";
import { useStore } from "vuex";
export default {
  props: {
    form: {
      type: Object,
      default: () => null,
    },
  },
  setup(props) {
    const store = useStore();
    let form = props.form;
    let is_visible = computed(function () {
      return store.state.is_visible;
    });

    const hideModel = function () {
      $emit("hideModel");
    };

    const generateSlug = function () {
      const slug = form.title
        .toLowerCase()
        .replace(/ /g, "-")
        .replace(/[^\w-]+/g, "");
      form.slug = slug;
    };

    return {
      is_visible,
      form,
      hideModel,
      generateSlug,
    };
  },
};
</script>

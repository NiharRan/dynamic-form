<template>
  <div class="bg-white shadow-lg p-4 w-full m-auto">
    <h1 class="mb-4">
      Generate New Form
      <button
        type="button"
        v-if="!formData"
        @click="createNewForm"
        class="px-4 py-2 mt-5 bg-indigo-600 text-white font-bold rounded-md hover:text-white hover:bg-indigo-500 transition-all delay-300 ease-in-out"
      >
        Create New Form
      </button>
    </h1>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  computed: {
    ...mapGetters(["formData"]),
  },
  methods: {
    createNewForm: function() {
      this.$store.dispatch("CREATE_NEW_FORM");
    },
  },
  created() {},
};
</script>

<template>
  <div class="bg-white shadow-lg p-4 w-full m-auto">
    <h1 class="flex justify-between items-center">
      <span>Generate New Form</span>
      <button
        type="button"
        v-if="!formData"
        @click="createNewForm"
        class="px-3 py-1 bg-indigo-500 text-white rounded-md hover:text-white hover:bg-indigo-600 transition-all delay-300 ease-in-out"
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

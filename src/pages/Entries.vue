<template>
  <div class="bg-white shadow-lg p-4 w-full m-auto">
    <h1 class="flex justify-between items-center !p-0">
      <span>
        All Entries of
        <span class="border border-gray-300 px-2 py-1 rounded bg-gray-100">{{
          form.title
        }}</span>
      </span>
      <router-link
        to="/"
        class="px-4 py-2 bg-indigo-100 text-indigo-500 hover:text-indigo-600 hover:bg-indigo-200 transition-all delay-300 ease-in-out"
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
    </h1>
    <div
      class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg mt-4"
    >
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50" v-if="form.fields.length > 0">
          <tr>
            <th>SN</th>
            <th
              v-for="(field, key) in form.fields"
              :key="key"
              scope="col"
              class="px-3 py-1 text-left text-sm font-medium text-gray-500 uppercase tracking-wider"
            >
              {{ field.label }}
            </th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          <tr v-for="(entry, key) in entries" :key="key">
            <th>{{ key + 1 }}</th>
            <td
              class="px-3 py-1 whitespace-nowrap text-sm"
              v-for="(field, k) in form.fields"
              :key="k"
            >
              {{ entry.data[field.name] }}
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  computed: {
    ...mapGetters(["form", "entries"]),
  },
  methods: {
    destroy: function(id) {
      this.$store.dispatch("DESTROY_ENTRY", id);
    },
  },
  created() {
    const url = window.location.href;
    const url_params = url.split("/");
    const id = url_params[url_params.length - 1];
    this.$store.dispatch("SET_FORM", id);
    this.$store.dispatch("FETCH_ALL_ENTRIES", id);
  },
};
</script>

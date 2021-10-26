<template>
  <div class="bg-white shadow-lg p-4 w-full m-auto">
    <h1 class="flex justify-between items-center !p-0">
      <span>All Forms</span>
      <router-link
        to="/new-form"
        class="px-4 py-2 bg-indigo-100 text-indigo-500 hover:text-indigo-600 hover:bg-indigo-200 transition-all delay-300 ease-in-out"
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
      </router-link>
    </h1>
    <div
      class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg mt-4"
    >
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th
              scope="col"
              class="px-3 py-1 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
            >
              Title
            </th>
            <th
              scope="col"
              class="px-3 py-1 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
            >
              Shortcode
            </th>
            <th
              scope="col"
              class="px-3 py-1 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
            >
              Classes
            </th>
            <th
              scope="col"
              class="px-3 py-1 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
            >
              ID
            </th>
            <th
              scope="col"
              class="px-3 py-1 text-center text-xs font-medium text-gray-500 uppercase tracking-wider"
            >
              Entries
            </th>
            <th
              scope="col"
              class="px-3 py-1 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
            >
              Status
            </th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          <tr v-for="(form, key) in forms" :key="key">
            <td class="px-3 py-1 whitespace-nowrap">
              <p class="text-lg font-semibold">{{ form.title }}</p>
              <div class="row-actions">
                <span class="ff_edit"
                  ><router-link :to="`/edit-form/${form.id}`">
                    Edit</router-link
                  >
                  |
                </span>
                <span class="ff_entries"
                  ><router-link :to="`/entries/${form.id}`">
                    Entries</router-link
                  >
                  |
                </span>
                <!---->
                <span class="ff_entries"
                  ><a target="_blank" :href="`/?page=preview-form&preview_id=${form.id}`">
                    Preview</a
                  >
                  |
                </span>
                <span class="ff_duplicate"><a href="#"> Duplicate</a> | </span>
                <span class="trash text-red-500"
                  ><span>
                    <span class="remove-btn el-popover__reference"
                      ><button type="button" @click="destroy(form.id)">
                        Delete
                      </button></span
                    ></span
                  ></span
                >
              </div>
            </td>
            <td class="px-3 py-1 whitespace-nowrap">
              <span
                class="border border-gray-300 px-2 py-1 rounded bg-gray-100"
                >{{ form.shortcode }}</span
              >
            </td>

            <td class="px-3 py-1 whitespace-nowrap text-sm text-gray-500">
              {{ form.classes }}
            </td>
            <td class="px-3 py-1 whitespace-nowrap text-sm text-gray-500">
              {{ form.form_id }}
            </td>
            <th
              class="px-3 py-1 whitespace-nowrap text-center text-sm text-gray-500"
            >
              {{ form.total_entries }}
            </th>
            <td class="px-3 py-1 whitespace-nowrap">
              <span
                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full"
                :class="[
                  form.status == 1
                    ? 'bg-green-100 text-green-800'
                    : 'bg-red-100 text-red-800',
                ]"
              >
                {{ form.status == 1 ? "Active" : "Inactive" }}
              </span>
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
    ...mapGetters(["forms"]),
  },
  methods: {
    destroy: function(id) {
      this.$store.dispatch("DESTROY_FORM", id);
    },
  },
  created() {
    this.$store.dispatch("FETCH_ALL_FORMS");
  },
};
</script>

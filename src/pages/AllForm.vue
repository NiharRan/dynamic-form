<template>
  <div class="bg-white shadow-lg p-4 w-full m-auto">
    <h1 class="mb-4">
      All Forms
      <router-link
        to="/new-form"
        class="px-4 py-2 mt-5 bg-indigo-600 text-white font-bold rounded-md hover:text-white hover:bg-indigo-500 transition-all delay-300 ease-in-out"
      >
        Create New Form
      </router-link>
    </h1>
    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th
              scope="col"
              class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
            >
              Title
            </th>
            <th
              scope="col"
              class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
            >
              Shortcode
            </th>
            <th
              scope="col"
              class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
            >
              Classes
            </th>
            <th
              scope="col"
              class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
            >
              ID
            </th>
            <th
              scope="col"
              class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
            >
              Status
            </th>
            <th scope="col" class="relative px-6 py-3">
              <span class="sr-only">Edit</span>
            </th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          <tr v-for="form in forms" :key="form.email">
            <td class="px-6 py-4 whitespace-nowrap">
              <h1>{{ form.title }}</h1>
              <p
                class="border bg-gray-100 px-1 font-semibold inline-block rounded"
              >
                {{ form.slug }}
              </p>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              {{ form.shortcode }}
            </td>

            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
              {{ form.classes }}
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
              {{ form.form_id }}
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
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
            <td
              class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium"
            >
              <router-link
                :to="`/edit-form/${form.id}`"
                class="px-4 py-2 bg-purple-600 text-white font-bold rounded-md hover:text-white hover:bg-purple-500 transition-all delay-300 ease-in-out"
                >Edit</router-link
              >
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
  created() {
    this.$store.dispatch("FETCH_ALL_FORMS");
  },
};
</script>

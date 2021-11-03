<template>
  <div class="bg-white shadow-lg p-4 w-full m-auto" v-if="form">
    <h1 class="flex justify-between items-center !p-0">
      <span>
        All Entries of
        <span class="border border-gray-300 px-2 py-1 rounded bg-gray-100">{{
          form.title
        }}</span>
      </span>
      <router-link to="/" class="link-btn">
        <icon-close />
      </router-link>
    </h1>
    <div
      class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg mt-4"
    >
      <app-table :headers="headers">
        <template v-slot:headerColAtStart>
          <app-table-row-col :text="'ID'" />
        </template>
        <app-table-row v-for="(entry, key) in entries" :key="key">
          <app-table-row-col>{{ key + 1 }} </app-table-row-col>
          <app-table-row-col v-for="(field, k) in form.fields" :key="k">
            {{ entry.data[field.name] }}
          </app-table-row-col>
        </app-table-row>
      </app-table>
    </div>
  </div>
</template>

<script>
import { computed } from "vue";
import { useStore } from "vuex";
import { IconClose } from "../components/icons";
import { AppTable, AppTableRow, AppTableRowCol } from "../components/table";
export default {
  components: { IconClose, AppTable, AppTableRow, AppTableRowCol },
  setup() {
    const store = useStore();

    const url = window.location.href;
    const url_params = url.split("/");
    const id = url_params[url_params.length - 1];
    store.dispatch("SET_FORM", id);
    store.dispatch("FETCH_ALL_ENTRIES", id);

    let form = computed(function () {
      return store.state.form;
    });
    let headers = computed(function () {
      return store.state.form.fields.map(function (row) {
        return {
          name: row.label,
          key: row.name,
          classes: "text-left",
        };
      });
    });

    let entries = computed(function () {
      return store.state.entries;
    });

    // methods
    const destroy = function (id) {
      store.dispatch("DESTROY_ENTRY", id);
    };

    return {
      form,
      headers,
      entries,
      destroy,
    };
  },
};
</script>

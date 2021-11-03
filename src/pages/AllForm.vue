<template>
  <div class="bg-white shadow-lg p-4 w-full m-auto">
    <h1 class="flex justify-between items-center !p-0">
      <span>All Forms</span>
      <router-link to="/new-form" class="link-btn">
        <icon-plus />
      </router-link>
    </h1>
    <div
      class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg mt-4"
    >
      <app-table :headers="headers">
        <app-table-row v-for="(form, key) in forms" :key="key">
          <app-table-row-col>
            <p class="text-lg font-semibold">{{ form.title }}</p>
            <!-- Table actons start here -->
            <form-table-action
              :data="form"
              :edit="`/edit-form/${form.id}`"
              @clone="showDuplicateForm"
              @remove="destroy"
            >
              <span class="ff_entries"
                ><router-link :to="`/entries/${form.id}`"> Entries</router-link>
                |
              </span>
              <span class="ff_preview"
                ><a
                  target="_blank"
                  :href="`/?page=preview-form&preview_id=${form.id}`"
                >
                  Preview</a
                >
                |
              </span>
            </form-table-action>
            <!-- Table action end here -->
          </app-table-row-col>
          <app-table-row-col>
            <copyable :text="form.shortcode" />
          </app-table-row-col>
          <app-table-row-col :text="form.classes" />
          <app-table-row-col :text="form.form_id" />
          <app-table-row-col :text="form.total_entries" />
          <app-table-row-col>
            <status-label :status="form.status" />
          </app-table-row-col>
        </app-table-row>
      </app-table>
    </div>
    <!-- This example requires Tailwind CSS v2.0+ -->
    <duplicate-model
      :data="form"
      ref="clone"
      @close="hideModel"
      @keyup="generateSlug"
      @submit="duplicate"
    ></duplicate-model>
  </div>
</template>

<script>
import { computed, reactive } from "vue";
import { useStore } from "vuex";
import Copyable from "../components/Copyable.vue";
import DuplicateModel from "../components/DuplicateModel.vue";
import StatusLabel from "../components/StatusLabel.vue";
import FormTableAction from "../components/form/FormTableAction.vue";
import { AppTable, AppTableRow, AppTableRowCol } from "../components/table";
import { IconPlus, IconCopy } from "../components/icons";
import useSlugable from "../composables/useSlugable";
import useAllForm from "../composables/useAllForm";
export default {
  name: "AllForms",
  components: {
    DuplicateModel,
    FormTableAction,
    AppTable,
    AppTableRow,
    AppTableRowCol,
    IconPlus,
    IconCopy,
    StatusLabel,
    Copyable,
  },
  setup(_, context) {
    console.log(context);
    let form = reactive({
      title: "",
      slug: "",
      id: "",
    });
    const store = useStore();
    store.dispatch("FETCH_ALL_FORMS");

    // computed source codes
    let headers = computed(function () {
      return store.state.headers;
    });
    let forms = computed(function () {
      return store.state.forms;
    });

    const { generateSlug } = useSlugable(form);
    const { duplicate, showDuplicateForm, destroy, hideModel } =
      useAllForm(form);

    return {
      headers,
      forms,
      form,
      showDuplicateForm,
      generateSlug,
      duplicate,
      destroy,
      hideModel,
    };
  },
};
</script>

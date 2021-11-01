<template>
  <div class="bg-white shadow-lg p-4 w-full m-auto">
    <h1 class="flex justify-between items-center !p-0">
      <span>All Forms</span>
      <router-link
        to="/new-form"
        class="
          px-4
          py-2
          bg-indigo-100
          text-indigo-500
          hover:text-indigo-600 hover:bg-indigo-200
          transition-all
          delay-300
          ease-in-out
        "
      >
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
            <span
              class="
                flex
                items-center
                border border-gray-300
                px-2
                py-1
                rounded
                bg-gray-100
              "
            >
              <span
                class="mr-4 cursor-pointer"
                v-clipboard:copy="form.shortcode"
                v-clipboard:success="onCopy"
              >
                <icon-copy :classes="'w-4 h-4'" />
              </span>
              <span class="">{{ form.shortcode }}</span>
            </span>
          </app-table-row-col>
          <app-table-row-col :text="form.classes" />
          <app-table-row-col :text="form.form_id" />
          <app-table-row-col :text="form.total_entries" />
          <app-table-row-col>
            <span
              class="
                px-2
                inline-flex
                text-xs
                leading-5
                font-semibold
                rounded-full
              "
              :class="[
                form.status == 1
                  ? 'bg-green-100 text-green-800'
                  : 'bg-red-100 text-red-800',
              ]"
            >
              {{ form.status == 1 ? "Active" : "Inactive" }}
            </span>
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
import { computed, reactive, toRef, watch } from "vue";
import { useStore } from "vuex";
import DuplicateModel from "../components/DuplicateModel.vue";
import useAlert from "../mixins/useAlert";
import FormTableAction from "../components/form/FormTableAction.vue";
import { AppTable, AppTableRow, AppTableRowCol } from "../components/table";
import { IconPlus, IconCopy } from "../components/icons";
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
  },
  setup(_, context) {
    console.log(context);
    const headers = [
      { name: "Title", key: "title", classes: "text-left" },
      { name: "Shortcode", key: "shortcode", classes: "text-left" },
      { name: "Classes", key: "classes", classes: "text-left" },
      { name: "Form ID", key: "form_id", classes: "text-left" },
      { name: "Entries", key: "entries", classes: "text-center" },
      { name: "Status", key: "status", classes: "text-center" },
    ];
    let form = reactive({
      title: "",
      slug: "",
      id: "",
    });
    const { $confirm, $toast } = useAlert();
    const store = useStore();
    store.dispatch("FETCH_ALL_FORMS");

    // computed source codes
    let forms = computed(function () {
      return store.state.forms;
    });
    let is_updated = computed(function () {
      return store.state.is_updated;
    });

    // watched code
    watch(is_updated, function (value) {
      $toast("Data updated successfully", "success");
      store.dispatch("UPDATE_STATUS", false);
    });

    const generateSlug = function () {
      const slug = form.title
        .toLowerCase()
        .replace(/ /g, "-")
        .replace(/[^\w-]+/g, "");
      form.slug = slug;
    };

    const showDuplicateForm = function (row) {
      form.id = row.id;
      store.dispatch("UPDATE_MODAL_STATUS", true);
    };

    const duplicate = function () {
      store.dispatch("DEPLICATE_FORM", form);
    };

    const destroy = async function (id) {
      const result = await $confirm("This form will be removed permanently");
      if (result.isConfirmed) {
        store.dispatch("DESTROY_FORM", id);
      }
    };

    const hideModel = function () {
      store.dispatch("UPDATE_MODAL_STATUS", false);
      form.title = "";
      form.slug = "";
      form.id = "";
    };

    const onCopy = function () {
      alert("Copied");
    };

    return {
      headers,
      forms,
      form,
      is_updated,
      showDuplicateForm,
      generateSlug,
      duplicate,
      destroy,
      hideModel,
      onCopy,
    };
  },
};
</script>

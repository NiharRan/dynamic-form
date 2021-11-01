<template>
  <div>
    <div class="bg-white shadow-lg p-4 w-full m-auto">
      <h1 class="flex justify-between items-center !p-0">
        <span>Form</span>

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
            <icon-close />
          </router-link>
          <btn-success @click="updateForm" class="px-4 py-2">
            <icon-save />
          </btn-success>
        </div>
      </h1>

      <form @submit.prevent="store" v-if="form">
        <div class="grid grid-cols-5 gap-4">
          <div>
            <label>Title</label>
            <input
              type="text"
              class="w-full"
              @keyup="generateSlug"
              v-model="form.title"
              placeholder="Form Title"
            />
          </div>
          <div>
            <label>Slug</label>
            <input
              type="text"
              class="w-full"
              v-model="form.slug"
              readonly
              placeholder="Form Slug"
            />
          </div>
          <div>
            <label>Shortcode</label>
            <input
              type="text"
              class="w-full"
              v-model="form.shortcode"
              placeholder="Form Shortcode"
            />
          </div>
          <div>
            <label>Classes</label>
            <input
              type="text"
              class="w-full"
              v-model="form.classes"
              placeholder="Form Classes"
            />
          </div>
          <div>
            <label>ID</label>
            <input
              type="text"
              class="w-full"
              v-model="form.form_id"
              placeholder="Form ID"
            />
          </div>
          <div>
            <btn-primary @click="addField" class="px-4 py-2 float-left">
              <icon-plus />
            </btn-primary>
          </div>
        </div>
      </form>
    </div>

    <div v-if="form && form.fields && form.fields.length > 0">
      <div
        class="bg-white shadow-lg p-4 mt-8 w-full flex relative"
        v-for="(field, key) in form.fields"
        :key="key"
      >
        <div class="absolute right-0 top-0">
          <btn-danger
            @click="removeField(key)"
            class="px-2 align-top py-1 float-right"
          >
            <icon-trash :classes="'w-4 h-4'" />
          </btn-danger>
        </div>
        <div class="md:w-8/12 w-full md:!border-r-2 md:pr-4" v-if="field">
          <div class="grid grid-cols-3 gap-4">
            <div>
              <label>Label</label>
              <input
                type="text"
                class="w-full"
                v-model="form.fields[key].label"
                placeholder="Field Label"
              />
            </div>
            <div>
              <label>Placeholder</label>
              <input
                type="text"
                class="w-full"
                v-model="form.fields[key].placeholder"
                placeholder="Field Placeholder"
              />
            </div>
            <div>
              <label>Name</label>
              <input
                type="text"
                class="w-full"
                v-model="form.fields[key].name"
                placeholder="Field Name"
              />
            </div>
            <div>
              <label>ID</label>
              <input
                type="text"
                class="w-full"
                v-model="form.fields[key].field_id"
                placeholder="Field ID"
              />
            </div>
            <div>
              <label>Width</label>
              <input
                type="text"
                class="w-full"
                v-model="form.fields[key].width"
                placeholder="Field Width"
              />
            </div>
            <div>
              <label>Height</label>
              <input
                type="text"
                class="w-full"
                v-model="form.fields[key].height"
                placeholder="Field Height"
              />
            </div>
          </div>
        </div>
        <div class="w-full md:w-4/12 md:pl-4">
          <div class="w-full">
            <label class="block">Type </label>
            <select v-model="form.fields[key].type" class="w-full min-w-full">
              <option value="">Select ...</option>
              <option value="input">Input</option>
              <option value="select">Select</option>
              <option value="textarea">Textarea</option>
              <option value="button">Button</option>
            </select>
          </div>

          <div class="w-6/12 mt-6" v-if="field.type == 'textarea'">
            <label class="block">Rows</label>
            <input
              type="number"
              v-model="field.rows"
              placeholder="Textarea rows"
              class="w-full"
            />
          </div>

          <div class="w-full mt-6" v-if="field.type == 'input'">
            <label class="block">Input Type </label>
            <select
              v-model="form.fields[key].input_type"
              class="w-full min-w-full"
            >
              <option value="">Select ...</option>
              <option
                v-for="(type, key) in input_types"
                :key="key"
                :value="type.value"
              >
                {{ type.text }}
              </option>
            </select>
          </div>

          <div
            class="w-full mt-6"
            v-if="
              field.type === 'select' ||
              field.input_type === 'checkbox' ||
              field.input_type === 'radio'
            "
          >
            <app-table :headers="option_header">
              <template v-slot:headerCol>
                <app-table-row-col>
                  <btn-info
                    @click="addSelectOption(key)"
                    class="px-3 py-1 float-right"
                  >
                    <icon-plus :classes="'w-4 h-4'" />
                  </btn-info>
                </app-table-row-col>
              </template>
              <app-table-row v-for="(option, k) in field.options" :key="k">
                <app-table-row-col :class="'font-medium text-gray-500'">
                  <input
                    type="text"
                    v-model="form.fields[key].options[k].value"
                    class="w-full"
                    placeholder="Option's Value"
                  />
                </app-table-row-col>

                <app-table-row-col
                  :text="option.text"
                  :class="'font-medium text-gray-500'"
                >
                  <input
                    type="text"
                    v-model="form.fields[key].options[k].text"
                    class="w-full"
                    placeholder="Option's Text"
                  />
                </app-table-row-col>
                <app-table-row-col :class="'font-medium text-gray-500'">
                  <btn-danger
                    @click="removeSelectedOption(key, k)"
                    :class="'float-right px-3 py-1'"
                  >
                    <icon-trash :classes="'w-4 h-4'" />
                  </btn-danger>
                </app-table-row-col>
              </app-table-row>
            </app-table>
          </div>
          <div class="w-full">
            <label class="block mt-6">
              <input type="checkbox" v-model="form.fields[key].is_required" />
              <span>Is Required</span>
            </label>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { computed, watch } from "vue";
import { useStore } from "vuex";
import useAlert from "../mixins/useAlert";
import inputTypes from "../helpers/input-types";
import { IconClose, IconPlus, IconSave, IconTrash } from "../components/icons";
import { AppTable, AppTableRowCol, AppTableRow } from "../components/table";
import {
  BtnInfo,
  BtnDanger,
  BtnPrimary,
  BtnSuccess,
} from "../components/buttons";
export default {
  components: {
    IconClose,
    IconPlus,
    IconSave,
    IconTrash,
    AppTable,
    AppTableRowCol,
    AppTableRow,
    BtnInfo,
    BtnPrimary,
    BtnDanger,
    BtnSuccess,
  },
  setup() {
    const store = useStore();
    const { $confirm, $toast } = useAlert();
    const input_types = inputTypes;
    const option_header = [
      { name: "Value", key: "value", classes: "text-left" },
      { name: "Text", key: "text", classes: "text-left" },
    ];
    let form = computed(function () {
      return store.state.form;
    });
    let is_updated = computed(function () {
      return store.state.is_updated;
    });
    let field = computed(function () {
      return store.state.field;
    });

    watch(is_updated, function (value) {
      $toast("Data updated successfully", "success");
      store.dispatch("UPDATE_STATUS", false);
    });

    const url = window.location.href;
    const url_params = url.split("/");
    const id = url_params[url_params.length - 1];
    store.dispatch("SET_FORM", id);

    // methods
    const generateSlug = function () {
      store.dispatch("GENERATE_SLUG");
    };
    const addField = function () {
      field.value.dynamic_form_id = form.value.id;
      store.dispatch("SET_EMPTY_FIELD", field.value);
    };

    const removeField = async function (key) {
      const result = await $confirm("This field will be removed permanently");
      if (result.isConfirmed) {
        store.dispatch("REMOVE_FIELD", key);
      }
    };
    const addSelectOption = function (key) {
      const field = form.value.fields[key];
      const option = {
        id: 0,
        value: "",
        text: "",
        form_field_id: field.id,
      };

      store.dispatch("SET_EMPTY_OPTION", { option, key });
    };
    const updateForm = function () {
      store.dispatch("UPDATE_FORM", form.value);
    };
    const removeSelectedOption = async function (key, k) {
      const result = await $confirm(
        "This field option will be removed permanently"
      );
      if (result.isConfirmed) {
        const payload = { key: key, k: k };
        store.dispatch("REMOVE_OPTION_FROM_LIST", payload);
      }
    };

    return {
      form,
      is_updated,
      input_types,
      option_header,
      generateSlug,
      addField,
      removeField,
      addSelectOption,
      removeSelectedOption,
      updateForm,
    };
  },
};
</script>

<template>
  <div>
    <div class="bg-white shadow-lg p-4 w-full m-auto">
      <h1 class="flex justify-between items-center">
        <span>Form</span>
        <router-link
          to="/"
          class="px-3 py-1 bg-indigo-500 text-white rounded-md hover:text-white hover:bg-indigo-600 transition-all delay-300 ease-in-out"
        >
          Back
        </router-link>
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
            <button
              type="button"
              @click="addField"
              class="px-4 py-2 mt-5 bg-blue-500 text-white font-bold rounded-md hover:text-white hover:bg-blue-600 transition-all delay-300 ease-in-out"
            >
              Add Field
            </button>
            <button
              type="button"
              @click="updateForm"
              class="px-4 py-2 mt-5 bg-green-500 text-white font-bold rounded-md hover:text-white hover:bg-green-600 transition-all delay-300 ease-in-out"
            >
              Update
            </button>
          </div>
        </div>
      </form>
    </div>

    <div v-if="form && form.fields && form.fields.length > 0">
      <div
        class="bg-white shadow-lg p-4 mt-8 w-full flex"
        v-for="(field, key) in form.fields"
        :key="key"
      >
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
          <div class="flex justify-center items-center">
            <button
              type="button"
              @click="field.is_new ? storeField(key) : updateField(key)"
              class="px-4 py-2 mt-6 mr-4 float-right bg-green-500 text-white font-bold rounded-md hover:text-white hover:bg-green-600 transition-all delay-300 ease-in-out"
            >
              {{ field.is_new ? "Add" : "Update" }}
            </button>
            <button
              type="button"
              @click="removeFeild(key)"
              class="px-4 py-2 mt-5 float-right bg-red-500 text-white font-bold rounded-md hover:text-white hover:bg-red-600 transition-all delay-300 ease-in-out"
            >
              Remove
            </button>
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
              <option value="text">Text</option>
              <option value="email">Email</option>
              <option value="button">Button</option>
              <option value="checkbox">Checkbox</option>
              <option value="color">Color</option>
              <option value="date">Date</option>
              <option value="datetime-local">Datetime Local</option>
              <option value="file">File</option>
              <option value="hidden">Hidden</option>
              <option value="number">Number</option>
              <option value="password">Password</option>
              <option value="radio">Radio</option>
              <option value="range">Range</option>
              <option value="reset">Reset</option>
              <option value="search">Search</option>
              <option value="submit">Submit</option>
              <option value="tel">Tel</option>
              <option value="time">Time</option>
              <option value="url">Url</option>
              <option value="week">Week</option>
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
            <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-gray-50">
                <tr>
                  <th
                    class="px-6 py-3 border text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                  >
                    Value
                  </th>
                  <th
                    class="px-6 py-3 border text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                  >
                    Text
                  </th>
                  <th
                    class="px-6 py-3 border text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                  >
                    <button
                      type="button"
                      @click="addSelectOption(key)"
                      class="px-4 py-2 float-right bg-indigo-500 text-white font-bold rounded-md hover:text-white hover:bg-indigo-600 transition-all delay-300 ease-in-out"
                    >
                      New
                    </button>
                  </th>
                </tr>
              </thead>
              <tbody class="bg-gray-50">
                <tr v-for="(option, k) in field.options" :key="k">
                  <td
                    class="px-6 py-3 border text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                  >
                    <input
                      type="text"
                      v-model="form.fields[key].options[k].value"
                      class="w-full"
                      placeholder="Select Value"
                    />
                  </td>
                  <td
                    class="px-6 py-3 border text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                  >
                    <input
                      type="text"
                      v-model="form.fields[key].options[k].text"
                      class="w-full"
                      placeholder="Select Text"
                    />
                  </td>
                  <td
                    class="px-6 py-3 border text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                  >
                    <button
                      type="button"
                      @click="removeSelectedOption(key, k)"
                      class="px-4 py-2 bg-red-500 text-white font-bold rounded-md hover:text-white hover:bg-red-600 transition-all delay-300 ease-in-out"
                    >
                      Delete
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
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
import { mapGetters } from "vuex";
export default {
  computed: {
    ...mapGetters(["form", "field", "select"]),
  },
  methods: {
    generateSlug: function() {
      this.$store.dispatch("GENERATE_SLUG");
    },
    addField: function() {
      const field = {
        dynamic_form_id: this.form.id,
        label: "",
        placeholder: "",
        name: "",
        field_id: "",
        width: "",
        height: "",
        type: "",
        input_type: "",
        rows: "",
        is_required: false,
        options: [],
        is_new: true,
      };

      this.$store.dispatch("SET_EMPTY_FIELD", field);
    },
    removeField: function() {
      this.$store.dispatch("SET_EMPTY_FIELD", null);
    },
    storeField: function(key) {
      this.$store.dispatch("STORE_FIELD", key);
    },
    updateField: function(key) {
      this.$store.dispatch("UPDATE_FIELD", key);
    },
    addSelectOption: function(key) {
      const field = this.form.fields[key];
      const option = {
        id: 0,
        value: "",
        text: "",
        form_field_id: field.id,
      };

      this.$store.dispatch("SET_EMPTY_OPTION", { option, key });
    },
    updateForm: function() {
      const form = {
        title: this.form.title,
        id: this.form.id,
        slug: this.form.slug,
        shortcode: this.form.shortcode,
        classes: this.form.classes,
        form_id: this.form.form_id,
      };
      this.$store.dispatch("UPDATE_FORM", form);
    },
    removeSelectedOption: function(key, k) {
      const payload = { key: key, k: k };
      this.$store.dispatch("REMOVE_OPTION_FROM_LIST", payload);
    },
    removeFeild: function(key) {
      this.$store.dispatch("REMOVE_FIELD", key);
    },
  },
  created() {
    const url = window.location.href;
    const url_params = url.split("/");
    const id = url_params[url_params.length - 1];
    this.$store.dispatch("SET_FORM", id);
  },
};
</script>

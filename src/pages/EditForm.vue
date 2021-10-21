<template>
  <div>
    <div class="bg-white shadow-lg p-4 w-full m-auto">
      <h1 class="mb-4">
        Edit Form
        <router-link
          to="/"
          class="px-4 py-2 mt-5 bg-indigo-600 text-white font-bold rounded-md hover:text-white hover:bg-indigo-500 transition-all delay-300 ease-in-out"
        >
          Back
        </router-link>
      </h1>

      <form @submit.prevent="store" v-if="form">
        <div class="grid grid-cols-3 gap-4">
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
        </div>
        <div class="grid grid-cols-5 gap-4 mt-4">
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
            <label>Action</label>
            <input
              type="text"
              class="w-full"
              v-model="form.action"
              placeholder="Form Action"
            />
          </div>
          <div>
            <label class="mt-6 block text-lg">
              <input type="checkbox" v-model="form.has_file_upload" />
              Has File Input
            </label>
          </div>
          <div>
            <button
              type="button"
              @click="addField"
              class="px-4 py-2 mt-5 float-right bg-blue-600 text-white font-bold rounded-md hover:text-white hover:bg-blue-500 transition-all delay-300 ease-in-out"
            >
              Add Field
            </button>
          </div>
        </div>
      </form>
    </div>

    <div class="bg-white shadow-lg p-4 mt-8 w-full flex" v-if="field">
      <div class="md:w-8/12 w-full md:!border-r-2 md:pr-4">
        <div class="grid grid-cols-3 gap-4">
          <div>
            <label>Label</label>
            <input
              type="text"
              class="w-full"
              v-model="field.label"
              placeholder="Field Label"
            />
          </div>
          <div>
            <label>Placeholder</label>
            <input
              type="text"
              class="w-full"
              v-model="field.placeholder"
              placeholder="Field Placeholder"
            />
          </div>
          <div>
            <label>Name</label>
            <input
              type="text"
              class="w-full"
              v-model="field.name"
              placeholder="Field Name"
            />
          </div>
          <div>
            <label>ID</label>
            <input
              type="text"
              class="w-full"
              v-model="field.field_id"
              placeholder="Field ID"
            />
          </div>
          <div>
            <label>Width</label>
            <input
              type="text"
              class="w-full"
              v-model="field.width"
              placeholder="Field Width"
            />
          </div>
          <div>
            <label>Height</label>
            <input
              type="text"
              class="w-full"
              v-model="field.height"
              placeholder="Field Height"
            />
          </div>
        </div>
      </div>
      <div class="w-full md:w-4/12 md:pl-4">
        <div class="w-full">
          <label class="block">Type </label>
          <select
            v-model="field.type"
            class="w-full min-w-full"
            @change="showReletedFields"
          >
            <option value="">Select ...</option>
            <option value="input">Input</option>
            <option value="select">Select</option>
            <option value="textarea">Textarea</option>
            <option value="button">Button</option>
          </select>
        </div>

        <div class="flex justify-center items-center">
          <button
            type="button"
            @click="storeField"
            class="px-4 py-2 mt-6 mr-4 float-right bg-green-600 text-white font-bold rounded-md hover:text-white hover:bg-green-500 transition-all delay-300 ease-in-out"
          >
            Save
          </button>
          <button
            type="button"
            @click="removeField"
            class="px-4 py-2 mt-5 float-right bg-red-600 text-white font-bold rounded-md hover:text-white hover:bg-red-500 transition-all delay-300 ease-in-out"
          >
            Remove
          </button>
        </div>
      </div>
    </div>

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
      </div>
      <div class="w-full md:w-4/12 md:pl-4">
        <div class="w-full">
          <label class="block">Type </label>
          <select
            v-model="form.fields[key].type"
            class="w-full min-w-full"
            @change="showReletedFields"
          >
            <option value="">Select ...</option>
            <option value="input">Input</option>
            <option value="select">Select</option>
            <option value="textarea">Textarea</option>
            <option value="button">Button</option>
          </select>
        </div>

        <div class="flex justify-center items-center">
          <button
            type="button"
            @click="updateField(key)"
            class="px-4 py-2 mt-6 mr-4 float-right bg-green-600 text-white font-bold rounded-md hover:text-white hover:bg-green-500 transition-all delay-300 ease-in-out"
          >
            Update
          </button>
          <button
            type="button"
            @click="removeFeild(key)"
            class="px-4 py-2 mt-5 float-right bg-red-600 text-white font-bold rounded-md hover:text-white hover:bg-red-500 transition-all delay-300 ease-in-out"
          >
            Remove
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  computed: {
    ...mapGetters(["form", "field"]),
  },
  methods: {
    generateSlug: function() {
      this.$store.dispatch("GENERATE_SLUG");
    },
    showReletedFields: function() {},
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
        is_required: false,
      };

      this.$store.dispatch("SET_EMPTY_FIELD", field);
    },
    removeField: function() {
      this.$store.dispatch("SET_EMPTY_FIELD", null);
    },
    storeField: function() {
      this.$store.dispatch("STORE_FIELD", this.field);
    },
    updateField: function(key) {
      const field = this.form.fields[key];
      this.$store.dispatch("UPDATE_FIELD", field);
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

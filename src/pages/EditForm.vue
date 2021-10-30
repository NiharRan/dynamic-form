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
          <button
            type="button"
            @click="updateForm"
            class="
              px-4
              py-2
              bg-green-100
              text-green-500
              font-bold
              hover:text-text-green-600 hover:bg-green-200
              transition-all
              delay-300
              ease-in-out
            "
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
                d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"
              />
            </svg>
          </button>
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
            <button
              type="button"
              @click="addField"
              class="
                px-4
                py-2
                bg-blue-100
                text-blue-500
                font-bold
                hover:text-blue-600 hover:bg-blue-200
                transition-all
                delay-300
                ease-in-out
                float-left
              "
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
            </button>
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
          <button
            type="button"
            @click="removeField(key)"
            class="
              px-2
              py-1
              float-right
              bg-red-100
              text-red-500
              font-bold
              hover:text-red-600 hover:bg-red-200
              transition-all
              delay-300
              ease-in-out
            "
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="h-4 w-4"
              viewBox="0 0 20 20"
              fill="currentColor"
            >
              <path
                fill-rule="evenodd"
                d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                clip-rule="evenodd"
              />
            </svg>
          </button>
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
                    class="
                      px-6
                      py-3
                      border
                      text-left text-xs
                      font-medium
                      text-gray-500
                      uppercase
                      tracking-wider
                    "
                  >
                    Value
                  </th>
                  <th
                    class="
                      px-6
                      py-3
                      border
                      text-left text-xs
                      font-medium
                      text-gray-500
                      uppercase
                      tracking-wider
                    "
                  >
                    Text
                  </th>
                  <th
                    class="
                      px-6
                      py-3
                      border
                      text-left text-xs
                      font-medium
                      text-gray-500
                      uppercase
                      tracking-wider
                    "
                  >
                    <button
                      type="button"
                      @click="addSelectOption(key)"
                      class="
                        px-3
                        py-1
                        float-right
                        bg-indigo-100
                        text-indigo-500
                        font-bold
                        hover:text-indigo-600 hover:bg-indigo-200
                        transition-all
                        delay-300
                        ease-in-out
                      "
                    >
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-4 w-4"
                        viewBox="0 0 20 20"
                        fill="currentColor"
                      >
                        <path
                          fill-rule="evenodd"
                          d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z"
                          clip-rule="evenodd"
                        />
                      </svg>
                    </button>
                  </th>
                </tr>
              </thead>
              <tbody class="bg-gray-50">
                <tr v-for="(option, k) in field.options" :key="k">
                  <td
                    class="
                      px-6
                      py-3
                      border
                      text-left text-xs
                      font-medium
                      text-gray-500
                      uppercase
                      tracking-wider
                    "
                  >
                    <input
                      type="text"
                      v-model="form.fields[key].options[k].value"
                      class="w-full"
                      placeholder="Select Value"
                    />
                  </td>
                  <td
                    class="
                      px-6
                      py-3
                      border
                      text-left text-xs
                      font-medium
                      text-gray-500
                      uppercase
                      tracking-wider
                    "
                  >
                    <input
                      type="text"
                      v-model="form.fields[key].options[k].text"
                      class="w-full"
                      placeholder="Select Text"
                    />
                  </td>
                  <td
                    class="
                      px-6
                      py-3
                      border
                      text-left text-xs
                      font-medium
                      text-gray-500
                      uppercase
                      tracking-wider
                    "
                  >
                    <button
                      type="button"
                      @click="removeSelectedOption(key, k)"
                      class="
                        px-3
                        py-1
                        bg-red-100
                        text-red-500
                        font-bold
                        hover:text-red-600 hover:bg-red-200
                        transition-all
                        delay-300
                        ease-in-out
                      "
                    >
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-4 w-4"
                        viewBox="0 0 20 20"
                        fill="currentColor"
                      >
                        <path
                          fill-rule="evenodd"
                          d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                          clip-rule="evenodd"
                        />
                      </svg>
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
import { computed, watch } from "vue";
import { useStore } from "vuex";
import useAlert from "../mixins/useAlert";
export default {
  setup() {
    const store = useStore();
    const { $confirm, $toast } = useAlert();

    let form = computed(function () {
      return store.state.form;
    });
    let is_updated = computed(function () {
      return store.state.is_updated;
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
      const field = {
        id: 0,
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
      store.dispatch("SET_EMPTY_FIELD", field);
    };

    const removeField = async function (key) {
      const result = await $confirm("This field will be removed permanently");
      if (result.isConfirmed) {
        store.dispatch("REMOVE_FIELD", key);
      }
    };
    const addSelectOption = function (key) {
      const field = form.fields[key];
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

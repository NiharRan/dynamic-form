<template>
  <div>
    <div class="bg-white shadow-lg p-4 w-full m-auto">
      <h1 class="flex justify-between items-center">
        <span>Preview Form</span>
        <router-link
          to="/"
          class="
            px-3
            py-1
            bg-indigo-500
            text-white
            rounded-md
            hover:text-white hover:bg-indigo-600
            transition-all
            delay-300
            ease-in-out
          "
        >
          Back
        </router-link>
      </h1>

      <div class="w-6/12 mx-auto border p-4 rounded">
        <h1 class="text-center">
          {{ form.title }}
          <span class="border border-gray-300 px-2 py-1 rounded bg-gray-100">{{
            form.shortcode
          }}</span>
        </h1>
        <div v-if="form && form.fields">
          <div
            class="w-full my-4"
            v-for="(field, key) in form.fields"
            :key="key"
          >
            <label class="block" :for="field.field_id">{{ field.label }}</label>
            <input
              v-if="
                field.type == 'input' &&
                field.input_type != 'checkbox' &&
                field.input_type != 'radio'
              "
              :type="field.input_type"
              class="w-full"
              :name="field.name"
              :id="field.field_id"
              :class="field.classes"
              :placeholder="field.placeholder"
              :style="{ width: field.width, height: field.height }"
            />

            <textarea
              v-if="field.type == 'textarea'"
              :rows="field.rows"
              class="w-full border border-gray-400 rounded"
              :name="field.name"
              :id="field.field_id"
              :class="field.classes"
              :placeholder="field.placeholder"
              :style="{ width: field.width, height: field.height }"
            >
            </textarea>

            <div v-if="field.type == 'input' && field.input_type == 'radio'">
              <label
                v-for="(option, k) in field.options"
                :key="k"
                :for="field.form_id"
              >
                <input
                  :type="field.input_type"
                  :name="field.name"
                  :id="field.form_id"
                  :value="option.value"
                />
                {{ option.text }}
              </label>
            </div>

            <div v-if="field.type == 'input' && field.input_type == 'checkbox'">
              <label
                v-for="(option, k) in field.options"
                :key="k"
                :for="field.form_id"
              >
                <input
                  :type="field.input_type"
                  :name="field.name + '[]'"
                  :id="field.form_id"
                  :value="option.value"
                />
                {{ option.text }}
              </label>
            </div>

            <select
              v-if="field.type == 'select'"
              class="w-full min-w-full"
              :name="field.name"
              :id="field.field_id"
              :class="field.classes"
              :style="{ width: field.width, height: field.height }"
            >
              <option value="">Select ...</option>
              <option
                v-for="(option, k) in field.options"
                :key="k"
                :value="option.value"
              >
                {{ option.text }}
              </option>
            </select>
          </div>
          <div class="w-full mt-4">
            <button
              type="submit"
              class="
                px-4
                py-2
                bg-green-500
                text-white
                font-bold
                rounded-md
                hover:text-white hover:bg-green-600
                transition-all
                delay-300
                ease-in-out
              "
            >
              Submit
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { computed } from "vue";
import { useStore } from "vuex";
export default {
  setup() {
    const store = useStore();

    const url = window.location.href;
    const url_params = url.split("/");
    const id = url_params[url_params.length - 1];
    store.dispatch("SET_FORM", id);

    let form = computed(function () {
      return store.state.form;
    });

    return {
      form,
    };
  },
};
</script>

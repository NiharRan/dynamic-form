<template>
  <div class="row-actions">
    <span class="ff_edit" v-if="edit !== ''"
      ><router-link :to="edit"> Edit</router-link>
      |
    </span>

    <slot />

    <span class="ff_duplicate"
      ><a type="button" @click.prevent="$emit('clone', data)"> Duplicate </a>
      |
    </span>
    <span class="trash text-red-500"
      ><span>
        <span class="remove-btn el-popover__reference"
          ><button type="button" @click.once="$emit('remove', data.id)">
            Delete
          </button></span
        ></span
      ></span
    >
  </div>
</template>

<script>
export default {
  props: {
    data: {
      type: Object,
      default: () => null,
    },
    edit: {
      type: String,
      default: "",
    },
  },
  setup(props, { emit }) {
    const destroy = function (id) {
      emit("destroy", id);
    };

    return {
      destroy,
    };
  },
};
</script>

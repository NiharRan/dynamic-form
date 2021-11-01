<template>
  <td class="px-3 text-left py-1 whitespace-nowrap">
    <slot>
      {{ getText() }}
    </slot>
  </td>
</template>

<script>
export default {
  props: {
    text: {
      type: String,
      default: "",
    },
    width: {
      type: String,
      default: "",
    },
  },
  methods: {
    getText() {
      if (this.text == "" || !this.text) {
        return "";
      }
      return this.text;
    },
  },
};
</script>

<template>
  <tr :class="rowClass">
    <slot />
  </tr>
</template>

<script>
export default {
  props: {
    rowClass: {
      type: String,
      default: "",
    },
  },
};
</script>

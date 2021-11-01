<template>
  <button
    type="button"
    :class="`${btnClass} bg-red-100 text-red-500 hover:text-red-600 hover:bg-red-200`"
  >
    <slot />
  </button>
</template>

<script>
import btnClass from "./btn-class";
export default {
  data() {
    return {
      btnClass,
    };
  },
};
</script>

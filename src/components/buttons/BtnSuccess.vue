<template>
  <button
    type="button"
    :class="`${btnClass} bg-green-100 text-green-500 font-bold hover:text-text-green-600 hover:bg-green-200`"
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

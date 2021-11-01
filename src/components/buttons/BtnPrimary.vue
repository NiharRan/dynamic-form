<template>
  <button
    type="button"
    :class="`${btnClass} bg-blue-100 text-blue-500 font-bold hover:text-blue-600 hover:bg-blue-200`"
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

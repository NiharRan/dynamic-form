<template>
  <button
    type="button"
    :class="`${btnClass} bg-indigo-100 text-indigo-500 font-bold hover:text-indigo-600 hover:bg-indigo-200`"
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

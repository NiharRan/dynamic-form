<template>
  <span
    class="
      flex
      items-center
      border border-gray-300
      px-2
      py-1
      rounded
      bg-gray-100
    "
  >
    <span
      class="mr-4 cursor-pointer"
      v-clipboard:copy="text"
      v-clipboard:success="onCopy"
    >
      <icon-copy :classes="'w-4 h-4'" />
    </span>
    <span class="">{{ text }}</span>
  </span>
</template>

<script>
import { IconCopy } from "../components/icons";
import useAlert from "../composables/useAlert";
export default {
  props: ["text"],
  components: {
    IconCopy,
  },
  setup() {
    const { onCopy } = useAlert();

    return {
      onCopy,
    };
  },
};
</script>

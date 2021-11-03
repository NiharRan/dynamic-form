<template>
  <span
    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full"
    :class="[
      status == 1 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800',
    ]"
  >
    {{ status == 1 ? "Active" : "Inactive" }}
  </span>
</template>

<script>
export default {
  name: "StatusLabel",
  props: ["status"],
};
</script>

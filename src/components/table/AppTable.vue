<template>
  <table class="min-w-full divide-y divide-gray-200">
    <thead class="bg-gray-50" v-if="headers && headers.length > 0">
      <tr>
        <slot name="headerColAtStart" />
        <th
          v-for="(header, key) in headers"
          :key="key"
          scope="col"
          :data-key="header.key"
          class="px-3 py-1 font-medium text-gray-500 uppercase tracking-wider"
          :class="header.classes"
        >
          {{ header.name }}
        </th>
        <slot name="headerCol"></slot>
      </tr>
    </thead>
    <tbody class="bg-white divide-y divide-gray-200">
      <slot />
    </tbody>
  </table>
</template>

<script>
export default {
  props: {
    headers: {
      type: Array,
      default: () => [],
    },
  },
  setup(props) {},
};
</script>

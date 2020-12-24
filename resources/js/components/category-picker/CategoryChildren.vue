<template>
  <ul class="children">
    <category-item
      v-for="category in categories"
      :key="category.id"
      :li-class="liClass"
      :initialValue="initialValue"
      @checked="onChecked"
      @unchecked="onUnchecked"
      :level="level+1"
      :category="category" />
  </ul>
</template>

<script>
export default {
  props: {
    initialValue: {
      type: Array,
      default: () => []
    },
    categories: {
      type: Array,
      required: true
    },
    liClass: {
      type: [String, Object, Array],
    },
    level: {
      type: Number,
      default: 1,
    }
  },
  methods: {
    onChecked(category) {
      this.$emit('child-checked', category)
    },
    onUnchecked(category) {
      this.$emit('child-unchecked', category)
    }
  }
}
</script>

<style lang="scss" scoped>

</style>

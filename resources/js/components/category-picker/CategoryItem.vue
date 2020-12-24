<template>
  <li
    :class="localLiClassRoot">
    <div @click="onClick" class="cursor-pointer inline-flex">
      <input type="checkbox" :checked="checked" class="mt-1.5">
      <span class="ml-1 btw">{{ category.name }}</span>
    </div>

    <category-children
      v-if="category.all_children.length > 0"
      :li-class="liClass"
      :initialValue="initialValue"
      @child-checked="onChildChecked"
      @child-unchecked="onChildUnchecked"
      :categories="category.all_children" />
  </li>
</template>

<script>
import { GlobalMixin } from '@mixins'

export default {
  mixins: [
    GlobalMixin
  ],
  props: {
    initialValue: {
      type: Array,
      default: () => []
    },
    category: {
      type: Object,
      required: true
    },
    liClass: {
      type: [String, Object, Array],
    },
    liClassRoot: {
      type: [String, Object, Array],
    },
    level: {
      type: Number,
      default: 1,
    }
  },
  data() {
    return {
      checked: false
    }
  },
  computed: {
    localLiClass() {
      return this.mergeClasses({
        [`level-${this.level}`]: true,
      }, this.liClass)
    },
    localLiClassRoot() {
      return this.mergeClasses(this.localLiClass, this.liClassRoot)
    }
  },
  mounted() {
    if (_.find(this.initialValue, (c) => c.id == this.category.id)) {
      this.checked = true
    }
  },
  methods: {
    onClick(event) {
      this.toggleCheckedItem()
    },
    toggleCheckedItem() {
      if (this.checked) {
        this.checked = false
        this.$emit('unchecked', this.category)
      } else {
        this.checked = true
        this.$emit('checked', this.category)
      }
    },
    onChildChecked(category) {
      this.$emit('checked', category)
    },
    onChildUnchecked(category) {
      this.$emit('unchecked', category)
    }
  }
}
</script>

<style lang="scss" scoped>
  li {
    @apply w-full overflow-hidden;

    &:not(.level-1) {
      @apply pl-2;
    }
  }
</style>

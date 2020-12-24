<template>
  <div>
    <div
      class="category-list"
      @scroll="onScroll"
      ref="categoryPicker">
      <ul>
        <category-item
          :initialValue="initialValue"
          v-for="category in categories"
          @checked="onItemChecked"
          @unchecked="onItemUnchecked"
          :key="category.id"
          :category="category" />
      </ul>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    initialValue: {
      type: Array,
      default: () => []
    }
  },
  data() {
    return {
      categories: [],
      lastFetchPage: 0,
      lastPage: 99999,
      isFetched: false
    }
  },
  beforeMount() {
    this.fetch()
  },
  methods: {
    async fetch() {
      if (this.lastPage <= this.lastFetchPage) {
        return
      }
      const page = ++this.lastFetchPage
      this.isFetched = true

      try {
        const { data } = await axios.get('/api/kategori', {
          params: {
            page
          }
        })

        this.categories = this.categories.concat(data.data)
        this.lastPage = data.meta.last_page
      } catch (e) {
        this.lastFetchPage--
      }

      this.isFetched = false
    },
    onScroll() {
      const ref = this.$refs.categoryPicker

      if (ref.scrollTop + ref.offsetHeight > ref.scrollHeight - 50 && ! this.isFetched) {
        this.fetch()
      }
    },
    onItemChecked(category) {
      this.$emit('item-checked', category)
    },
    onItemUnchecked(category) {
      this.$emit('item-unchecked', category)
    }
  }
}
</script>

<style lang="scss" scoped>
  .category-list {
    @apply h-40 overflow-scroll;

    ul li {
      @apply list-none;
    }
  }
</style>

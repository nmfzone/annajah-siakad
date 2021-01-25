<template>
  <div>
    <vue-select
      class="select-box"
      :options="options"
      @input="setValue"
      @open="onOpen"
      @close="onClose"
      @search="onSearch"
      label="name"
      :filterable="false"
      v-bind="attrs"
      v-on="$listeners">
      <template #list-footer>
        <li ref="load" class="loader" v-show="hasNextPage">
          Loading..
        </li>
      </template>
      <template #no-options>
        {{ noOptionsMessage }}
      </template>
    </vue-select>

    <input type="hidden" :name="name" :value="selectedValue">
  </div>
</template>

<script>
import { GlobalMixin } from '@mixins'
import vSelect from 'vue-select'
import { isEmpty } from '@root/utils'

export default {
  inheritAttrs: false,
  mixins: [
    GlobalMixin,
  ],
  components: {
    'vue-select': vSelect
  },
  props: {
    name: {
      type: String,
      required: true
    }
  },
  data () {
    return {
      observer: new IntersectionObserver(this.onIntersect),
      selectedValue: null,
      currentPage: 0,
      lastPage: 1,
      isFetching: false,
      options: [],
      searchQuery: null
    }
  },
  computed: {
    hasNextPage() {
      return this.currentPage < this.lastPage
    },
    noOptionsMessage() {
      return 'Tahun Akademik tidak tersedia.'
    }
  },
  mounted() {
    this.fetch()
  },
  methods: {
    async fetch(search = null) {
      if (!this.hasNextPage) {
        return
      }
      ++this.currentPage
      this.isFetching = true

      try {
        const { data } = await axios.get('/api/tahun-akademik', {
          params: {
            page: this.currentPage,
            ...!isEmpty(search) && { q: search }
          }
        })

        this.options = this.options.concat(data.data)
        this.lastPage = data.meta.last_page
      } catch (e) {
        //
      }

      this.isFetching = false
    },
    onSearch(search, loading) {
      this.resetData()
      this.searchQuery = search
      this.observer.disconnect()
      loading(true)
      this.doSearch(loading, this)
    },
    doSearch: _.debounce(async (loading, vm) => {
      await vm.fetch(vm.searchQuery)
      loading(false)
      await vm.$nextTick()
      if (vm.hasNextPage && vm.$refs.load) {
        vm.observer.observe(vm.$refs.load)
      }
    }, 1000),
    async onIntersect([{isIntersecting, target}]) {
      if (isIntersecting) {
        const ul = target.offsetParent
        const scrollTop = target.offsetParent.scrollTop
        await this.fetch(this.searchQuery)
        await this.$nextTick()
        ul.scrollTop = scrollTop
      }
    },
    async onOpen () {
      if (this.hasNextPage) {
        await this.$nextTick()
        this.observer.observe(this.$refs.load)
      }
    },
    onClose () {
      this.observer.disconnect()
    },
    resetData() {
      this.currentPage = 0
      this.lastPage = 1
      this.options = []
    },
    setValue(v) {
      this.selectedValue = _.get(v, 'id')
      this.$emit('input', v)
    }
  }
}
</script>

<style lang="scss" scoped>
.select-box {
  background: #fff;

  ::v-deep .vs__dropdown-menu {
    max-height: 210px;

    .vs__dropdown-option {
      white-space: normal;
    }
  }
}

.loader {
  text-align: center;
  color: #bbbbbb;
}
</style>

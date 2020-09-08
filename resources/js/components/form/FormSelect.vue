<template>
  <div>
    <vue-select
      class="select-box"
      @input="setValue"
      v-bind="attrs"
      v-on="$listeners">
      <template v-slot:no-options v-if="noOptionsMessage">
        {{ noOptionsMessage }}
      </template>
    </vue-select>

    <input type="hidden" :name="name" :value="selectedValue">
  </div>
</template>

<script>
import { GlobalMixin } from '@mixins'
import vSelect from 'vue-select'

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
    },
    valueKey: {
      type: String,
      required: true
    },
    noOptionsMessage: String
  },
  data () {
    return {
      selectedValue: null
    }
  },
  methods: {
    setValue(v) {
      this.selectedValue = _.get(v, this.valueKey)
      this.$emit('input', v)
    }
  }
}
</script>

<style lang="scss" scoped>
  .select-box {
    background: #fff;

    ::v-deep .vs__dropdown-menu {
      .vs__dropdown-option {
        white-space: normal;
      }
    }
  }
</style>

<template>
  <button
    ref="button"
    :class="classObject"
    :style="btnStyle"
    :disabled="disabled"
    v-bind="$attrs"
    v-on="$listeners">
    <template v-if="loading">
      <i class="fa fa-spinner fa-spin"/>
    </template>
    <template v-else>
      <slot/>
    </template>
  </button>
</template>

<script>
import _ from 'lodash'

export default {
  props: {
    type: {
      type: String,
      default: 'primary'
    },
    loading: {
      type: Boolean,
      default: false
    },
    disabled: {
      type: Boolean,
      default: false
    },
    adjustWidth: {
      type: Boolean,
      default: true
    }
  },
  data () {
    return {
      buttonWidth: '100%',
      btnStyle: {}
    }
  },
  computed: {
    classObject () {
      return ['btn', 'text-center', this.buttonType]
    },
    buttonType () {
      return `btn-${this.type}`
    }
  },
  watch: {
    loading () {
      if (this.adjustWidth) {
        this.btnStyle.width = this.buttonWidth
      }
    }
  },
  mounted () {
    this.$nextTick(() => {
      this.syncButtonWidth()
      window.addEventListener('resize', this.syncButtonWidth)
    })
  },
  methods: {
    syncButtonWidth () {
      if (!this.loading) {
        const width = _.get(this.$refs.button, 'offsetWidth')
        this.buttonWidth = width ? `${width+1}px` : this.buttonWidth
      }
    }
  }
}
</script>

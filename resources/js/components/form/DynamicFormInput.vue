<template>
  <div>
    <slot
      name="header"
      :canAddForm="canAddForm"
      :addForm="addForm"></slot>
    <div
      v-for="(form, index) in forms"
      :key="form.id">
      <slot
        name="form"
        :form="form"
        :formIndex="index"
        :getInitialValue="getInitialValue"
        :hasError="hasError"
        :getErrorMessages="getErrorMessages"
        :getFirstErrorMessage="getFirstErrorMessage"
        :canRemoveForm="canRemoveForm"
        :removeForm="removeForm"></slot>
    </div>
  </div>
</template>

<script>
import { GlobalMixin } from '@mixins'

export default {
  inheritAttrs: false,
  mixins: [
    GlobalMixin,
  ],
  props: {
    initialValues: {
      type: Array,
      default: []
    },
    errors: {
      type: [Array, Object],
      default: {}
    },
    min: {
      type: Number,
      default: 1,
      validator: (value) => {
        return value >= 0
      }
    },
    max: {
      type: Number,
      default: 5,
      validator: (value) => {
        return value > 0
      }
    }
  },
  data() {
    return {
      lastId: 1,
      forms: []
    }
  },
  computed: {
    canAddForm() {
      return this.forms.length < this.max
    },
    canRemoveForm() {
      return this.forms.length > this.min
    }
  },
  watch: {
    $props: {
      immediate: true,
      handler() {
        this.validateProps()
      }
    }
  },
  mounted() {
    const cnt = this.initialValues.length > 0
      ? this.initialValues.length
      : this.min

    for (const i in _.range(cnt)) {
      this.addForm()
    }
  },
  methods: {
    hasError(key) {
      return _.has(this.errors, key) ? false : null
    },
    getErrorMessages(key) {
      return _.get(this.errors, key)
    },
    getFirstErrorMessage(key) {
      return _.get(this.getErrorMessages(key), 0)
    },
    getInitialValue(index, key) {
      return _.get(this.initialValues, `${index}.${key}`)
    },
    addForm() {
      if (!this.canAddForm) return
      this.forms.push({
        id: this.lastId++
      })
    },
    removeForm(index) {
      if (!this.canRemoveForm) return
      this.forms.splice(index, 1)
    },
    validateProps() {
      if (this.min >= this.max) {
        throw Error('Min harus kurang dari max.')
      } else if (this.max <= this.min) {
        throw Error('Max harus lebih dari min.')
      }
    }
  }
}
</script>

import _ from 'lodash'

export const InitialValueMixin = {
  props: {
    initialValue: {},
    initialType: String,
  },
  computed: {
    castInitialValue() {
      if (this.initialType === 'int') {
        return _.toInteger(this.initialValue)
      } else if (this.initialType === 'array') {
        return _.castArray(this.initialValue)
      }

      return this.typeLower === 'checkbox'
        ? []
        : this.initialValue
    }
  }
}

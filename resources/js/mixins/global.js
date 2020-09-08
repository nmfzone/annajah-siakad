import _ from 'lodash'

export const GlobalMixin = {
  computed: {
    attrs () {
      return {
        ...this.$attrs,
        ...this.$options.propsData,
      }
    }
  },
  methods: {
    mergeClasses (classes, otherClasses, unsets) {
      const convertToObject = (data) => {
        let result = {}

        if (typeof data === 'string') {
          data = data.split(' ')
          data.forEach(v => {
            result[v] = true
          })
        } else if (Array.isArray(data)) {
          data.forEach(v => {
            result[v] = true
          })
        } else if (data != null && typeof data === 'object') {
          result = data
        }

        return result
      }

      classes = convertToObject(classes)
      otherClasses = convertToObject(otherClasses)

      const res = { ...classes, ...otherClasses }

      unsets = convertToObject(unsets)
      Object.entries(unsets).forEach(([k]) => {
        _.unset(res, k)
      })

      return res
    }
  }
}

import _ from 'lodash'


export const inProduction = () => process.env.NODE_ENV === 'production'

export const toBoolean = (value) => {
  return value === 'true' || value === 1 || value === '1' || value === true;
}

export const isEmpty = (value) => {
  if (value instanceof File || value instanceof Date) {
    return false
  }

  if (_.isObject(value)) {
    return _.isEmpty(value)
  }

  return _.isNil(value) || (_.isString(value) && value.trim() === '')
}

export const isNotEmpty = (value) => {
  return !isEmpty(value)
}

export const getValue = (item, path, def = null) => {
  const val = _.get(item, path)

  return isEmpty(val) ? def : _.get(item, path)
}

export const isSet = (value) => {
  return typeof value !== 'undefined' && value !== null
}

export const isUnset = (value) => {
  return !isSet(value)
}

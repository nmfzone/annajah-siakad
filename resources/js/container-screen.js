$(document).ready(function () {
  const el = $('.container-full')
  const childHeight = el.children().height()

  const screenHeight = document.documentElement.clientHeight

  let classes = el.attr('class') ? el.attr('class').split(/\s+/) : []

  let ptol = _.find(classes, (v) => v.startsWith('cf-ptol-')) // padding tolerance
  ptol = ptol ? parseInt(ptol.replace('cf-ptol-', '')) : 0

  if (childHeight + (2 * ptol) > screenHeight) {
    classes = classes.map((val) => {
      if (val.startsWith('cf-ptol')) {
        return null
      } else if (val.startsWith('cf-')) {
        return val.replace('cf-', '')
      }
      return val
    })

    el.attr('class', classes.join(' '))
  }
})

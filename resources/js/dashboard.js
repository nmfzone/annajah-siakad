import './bootstrap'
import './global'
import 'bootstrap'
import 'bootstrap-switch'
import 'overlayscrollbars'
import 'tinymce'
import './vendor/tinymce/langs/id'
import 'datatables.net-bs4'
import 'datatables.net-responsive-bs4'
import 'datatables.net-buttons-bs4'
import './vendor/datatable/buttons.server-side'
import '@vendor/almasaeed2010/adminlte/dist/js/adminlte'
import './vendor/datatable/datatables'


import CreateOrUpdateArticle from './components/CreateOrUpdateArticle'
import ThumbnailPicker from './components/ThumbnailPicker'

Vue.component('create-or-update-article', CreateOrUpdateArticle)
Vue.component('thumbnail-picker', ThumbnailPicker)

const app = new Vue({
  el: '#app',
})

function submitThis(prefix = '', isDeleteAction = false) {
  const suffix = isDeleteAction ? '.delete-this' : '.submit-this'
  $(`${prefix} ${suffix}`).click(function (e) {
    e.preventDefault()
    let message = $(this).data('message')
    const deleteAction = isDeleteAction || $(this).data('delete-action')

    if (!message) {
      if (deleteAction) {
        message = 'Apakah anda yakin ingin menghapus item ini?'
      } else {
        message = 'Apakah anda yakin ingin melakukan ini?'
      }
    }

    if (confirm(message)) {
      let form =
        $('<form>', {
          'method': 'POST',
          'action': $(this).attr('href')
        })

      const token =
        $('<input>', {
          'type': 'hidden',
          'name': '_token',
          'value': $('meta[name=csrf-token]').attr('content')
        })

      form = form.append(token)

      if (deleteAction) {
        const hiddenInput =
          $('<input>', {
            'name': '_method',
            'type': 'hidden',
            'value': 'DELETE'
          })

        form = form.append(hiddenInput)
      }

      form.appendTo('body').submit()
    }
  })
}

$(document).ready(function () {
  submitThis('')
  submitThis('', true)
})

// Bootstrap
$('input[data-bootstrap-switch]').each(function() {
  $(this).bootstrapSwitch('state', $(this).prop('checked'))
})

$('.form-control.is-invalid').each(function() {
  const invalidFeedback = $(this).parent().find('.invalid-feedback')

  if (invalidFeedback) {
    invalidFeedback.show()
  }
})

// AdminLTE Plugins
import bsCustomFileInput from '@vendor/almasaeed2010/adminlte/plugins/bs-custom-file-input/bs-custom-file-input'
import '@vendor/almasaeed2010/adminlte/plugins/inputmask/jquery.inputmask.bundle'

$(document).ready(function () {
  bsCustomFileInput.init()
  $('.mask-input').inputmask()
})
// AdminLTE Plugins

$(document).on('init.dt', function (e, settings) {
  submitThis('.dataTable')
  submitThis('.dataTable', true)
})

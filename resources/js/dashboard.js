import './bootstrap'
import './global'
import 'bootstrap'
import 'bootstrap-switch'
import 'overlayscrollbars'
import 'datatables.net-bs4'
import 'datatables.net-responsive-bs4'
import 'datatables.net-buttons-bs4'
import './vendor/datatable/buttons.server-side'
import '@vendor/almasaeed2010/adminlte/dist/js/adminlte'
import './vendor/datatable/datatables'


const app = new Vue({
  el: '#app',
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
  $('.dataTable .delete-this').click(function (e) {
    e.preventDefault()
    let message = $(this).data('message')

    if (!message) {
      message = 'Apakah anda yakin ingin menghapus item ini?'
    }

    if (confirm(message)) {
      const form =
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

      const hiddenInput =
        $('<input>', {
          'name': '_method',
          'type': 'hidden',
          'value': 'DELETE'
        })

      form.append(token, hiddenInput).appendTo('body').submit()
    }
  })
})

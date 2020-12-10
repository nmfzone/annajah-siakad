$.extend(true, $.fn.dataTable.defaults, {
  dom:
    "<'row'<'col-md-12'B>>" +
    "<'row mt-2'<'col-sm-12 col-md-6'i><'col-sm-12 col-md-6'f>>" +
    "<'row'<'col-sm-12'tr>>" +
    "<'row mt-2'<'col-sm-12 col-md-5'l><'col-sm-12 col-md-7'p>>",
  searchDelay: 1500,
  deferRender: true,
  autoWidth: false,
  pageLength: 25,
  pagingType: 'full_numbers',
  language: {
    'mptyTable': 'Tidak ada data yang tersedia pada tabel ini',
    'sProcessing': 'Sedang memproses...',
    'sLengthMenu': 'Tampilkan _MENU_ entri',
    'sZeroRecords': 'Tidak ditemukan data yang sesuai',
    'sInfo': 'Menampilkan _START_ sampai _END_ dari _TOTAL_ entri',
    'sInfoEmpty': 'Menampilkan 0 sampai 0 dari 0 entri',
    'sInfoFiltered': '(disaring dari _MAX_ entri keseluruhan)',
    'sInfoPostFix': '',
    'sSearch': 'Cari:',
    'sUrl': '',
    'oPaginate': {
      'sFirst': 'Pertama',
      'sPrevious': 'Sebelumnya',
      'sNext': 'Selanjutnya',
      'sLast': 'Terakhir'
    }
  }
})

$.fn.dataTable.ext.errMode = 'none'

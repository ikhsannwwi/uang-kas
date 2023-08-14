<!-- Modal Total Kas-->
<div class="modal fade" id="totalKas" tabindex="-1" aria-labelledby="totalKasLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="totalKasLabel">Total Transaksi</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="totalKasBody">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
@push('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endpush
@push('js')
<script>
  $('#totalKas').on('show.bs.modal', function(event) {
    var button = $(event.relatedTarget);

    var modalBody = $('#totalKasBody');
    modalBody.html('<div id="loadingSpinner" style="display: none;">' +
      '<i class="fas fa-spinner fa-spin"></i> Sedang memuat...' +
      '</div>')
    var loadingSpinner = $('#loadingSpinner');

    loadingSpinner.show();

    $.ajax({
      url: '{{ route("admin.kas.total") }}',
      method: 'GET',
      success: function(data) {
        var jumlah = data.total;

        var pemasukanHTML = '<span class="color-green">' + formatCurrency(data.pemasukan) + '</span>';
        var pengeluaranHTML = '<span class="color-red">' + formatCurrency(-data.pengeluaran) + '</span>';
        if (jumlah < 0) {
          var jumlahHTML = '<span class="color-red">' + formatCurrency(jumlah) + '</span>';
        } else {
          var jumlahHTML = '<span class="color-green">' + formatCurrency(jumlah) + '</span>';
        }

        modalBody.html(
          '<p>Pemasukan: ' + pemasukanHTML + '</p>' +
          '<p>Pengeluaran: ' + pengeluaranHTML + '</p>' +
          '<p>Jumlah: ' + jumlahHTML + '</p>'
        );
        loadingSpinner.hide();
      }
    });
  });

  function formatCurrency(amount) {
  if (typeof amount !== 'undefined' && amount !== null) {
    return amount.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' });
  } else {
    return 'N/A'; // Atau teks lain yang sesuai untuk nilai yang tidak valid
  }
}
</script>
@endpush

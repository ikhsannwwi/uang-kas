<!-- Modal Detail Kas-->
  <div class="modal fade" id="detailKas" tabindex="-1" aria-labelledby="detailKasLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="detailKasLabel">Detail Transaksi</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="detailKasBody">
            
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
        </div>
      </div>
    </div>
  </div>
@push('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endpush
  @push('js')
  <script>
    
    
    $('#detailKas').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        
        var modalBody = $('#detailKasBody');
        modalBody.html('<div id="loadingSpinner" style="display: none;">' +
                '<i class="fas fa-spinner fa-spin"></i> Sedang memuat...' +
            '</div>')
        var loadingSpinner = $('#loadingSpinner');
        
        loadingSpinner.show(); // Tampilkan elemen animasi
        
        $.ajax({
            url: '{{ route("admin.kas.detail", ":id") }}'.replace(':id', id),
            method: 'GET',
            success: function(data) {
              var tipeTransaksi = (data.status === 1) ? 'Pemasukan' : 'Pengeluaran';
              var tanggal = moment(data.tanggal).format('D MMMM YYYY');
              var amountData = parseFloat(data.pemasukan_pengeluaran);
              var jumlah = (data.status === 1) ? formatCurrency(amountData) : formatCurrency(-amountData);

              var jumlahHTML = '<span class="' + ((data.status === 0) ? 'color-red' : 'color-green') + '">' + jumlah + '</span>';

              modalBody.html(
                  '<p>ID: ' + data.id + '</p>' +
                  '<p>Nama Pengguna: ' + data.user.name + '</p>' +
                  '<p>Tipe Transaksi: ' + tipeTransaksi + '</p>' +
                  '<p>Jumlah: ' + jumlahHTML + '</p>' +
                  '<p>Keterangan: ' + data.keterangan + '</p>' +
                  '<p>Tanggal Transaksi: ' + tanggal + '</p>'
              );

                loadingSpinner.hide(); // Sembunyikan elemen animasi setelah data dimuat
            }
        });
    });
    function formatCurrency(amount) {
        return amount.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' });
    }
    
</script>


  @endpush
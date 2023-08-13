<!-- Modal -->
<div class="modal fade" id="detailUser" tabindex="-1" aria-labelledby="detailUserLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="detailUserLabel">Detail User</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="detailUserBody">
            
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
    
    
    $('#detailUser').on('show.bs.modal', function(event) {
    var button = $(event.relatedTarget);
    var kode = button.data('kode');
    
    var modalBody = $('#detailUserBody');
    modalBody.html('<div id="loadingSpinner" style="display: none;">' +
            '<i class="fas fa-spinner fa-spin"></i> Sedang memuat...' +
        '</div>')
    var loadingSpinner = $('#loadingSpinner');
    
    loadingSpinner.show(); // Tampilkan elemen animasi
    
    $.ajax({
        url: '{{ route("admin.users.detail", ":kode") }}'.replace(':kode', kode),
        method: 'GET',
        success: function(data) {
            console.log(data);
            
            var content = '<p>kode: ' + (data.kode || '') + '</p>' +
                '<p>Nama Pengguna: ' + (data.name || '') + '</p>' +
                '<p>E-Mail: ' + (data.email || '') + '</p>';
            
            if (data.user_profile) {
                content += '<p>Nama Lengkap: ' + data.user_profile.nama_lengkap + '</p>' +
                    '<p>Nomor Telepon: ' + data.user_profile.nomor_telepon + '</p>' +
                    '<p>Hobi: ' + data.user_profile.hobi + '</p>' +
                    '<p>Riwayat Pendidikan: ' + data.user_profile.riwayat_pendidikan + '</p>' +
                    '<p>Tempat/Tanggal Lahir: ' + data.user_profile.tempat_lahir + ', ' + data.user_profile.tanggal_lahir + '</p>' +
                    '<p>Alamat: ' + data.user_profile.alamat + '</p>' +
                    '<p>Instagram: ' + data.user_profile.instagram_link + '</p>';
            } else {
                content += '<p>User profile data not available.</p>';
            }
            
            modalBody.html(content);
            loadingSpinner.hide(); // Hide the loading spinner after data is loaded
        }
    });
});

    function formatCurrency(amount) {
        return amount.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' });
    }
    
</script>


  @endpush
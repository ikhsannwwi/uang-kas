<!-- Modal Profile-->
  <div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Profile</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
                <a href="javascript:void(0)" class="btn btn-primary edit-button mb-3" id="editProfileButton">
                    <i class="mdi mdi-lead-pencil"></i> Edit Profil
                </a>
            <div class="profile-container">
                <div class="profile-name-picture">
                    @if (File_exists(public_path('administrator/users/' . auth()->user()->foto)))
                    <img class="profile-picture" src="{{asset('administrator/users/'.auth()->user()->foto)}}" alt="">
                    @else
                    <img class="profile-picture" src="{{asset('administrator/users/default.svg')}}" alt="">
                    @endif
                    <h3 class="profile-name">{{auth()->user()->user_profile->nama_lengkap ?? 'N/A'}}</h3>
                </div>
                <div class="profile-details">
                    <p class="profile-detail-items">TTL :  {{ auth()->user()->user_profile->tanggal_lahir ?? 'N/A' }}</p>
                    <p class="profile-detail-items">Alamat : {{ auth()->user()->user_profile->alamat ?? 'N/A' }}</p>
                    <p class="profile-detail-items">Riwayat Pendidikan : {{ auth()->user()->user_profile->riwayat_pendidikan ?? 'N/A' }}</p>
                    <p class="profile-detail-items">Hobi : {{ auth()->user()->user_profile->hobi ?? 'N/A' }}</p>
                    <p class="profile-detail-items">Kontak : {{ auth()->user()->nomor_telepon ?? 'N/A'}}</p>
                    <p class="profile-detail-items">Instagram : {{ auth()->user()->user_profile->instagram_link ?? 'N/A' }}</p>
                </div>
            </div>
            <div class="edit-profile-container">
                <a href="javascript:void(0)" class="btn btn-primary edit-button" id="profileButton">
                    <i class="mdi mdi-eye"></i> Lihat
                </a>
                <div class="form-edit-profile">
                    <form action="{{route('admin.users.updateProfile',auth()->user()->kode)}}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group mt-4">
                            <label for="nama_lengkap">Nama Lengkap:</label>
                            <input type="text" class="form-control" 
                            id="nama_lengkap" name="nama_lengkap" 
                            autocomplete="off"
                            value="{{ auth()->user()->user_profile->nama_lengkap ?? '' }}">
                        </div>
                        <div class="form-group mt-4">
                            <label for="tempat_lahir">Tempat Lahir:</label>
                            <input type="text" class="form-control" 
                            id="tempat_lahir" name="tempat_lahir" 
                            autocomplete="off"
                            value="{{ auth()->user()->user_profile->tempat_lahir ?? '' }}">
                        </div>
                        <div class="form-group">
                            <label for="tanggal_lahir">Tanggal Lahir:</label>
                            <input type="date" class="form-control" 
                            id="tanggal_lahir" name="tanggal_lahir" 
                            autocomplete="off"
                            value="{{ auth()->user()->user_profile->tanggal_lahir ?? '' }}">
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat:</label>
                            <input type="text" class="form-control" 
                            id="alamat" name="alamat" 
                            autocomplete="off"
                            value="{{ auth()->user()->user_profile->alamat ?? '' }}">
                        </div>
                        <div class="form-group">
                            <label for="riwayat_pendidikan">Riwayat Pendidikan:</label>
                            <select class="form-control" id="riwayat_pendidikan" name="riwayat_pendidikan">
                                <option value="" {{ (auth()->user()->user_profile->riwayat_pendidikan ?? '') === '' ? 'selected' : '' }}>Pilih data</option>
                                <option value="SMA" {{ (auth()->user()->user_profile->riwayat_pendidikan ?? '') === 'SMA' ? 'selected' : '' }}>SMA</option>
                                <option value="Diploma" {{ (auth()->user()->user_profile->riwayat_pendidikan ?? '') === 'Diploma' ? 'selected' : '' }}>Diploma</option>
                                <option value="Sarjana" {{ (auth()->user()->user_profile->riwayat_pendidikan ?? '') === 'Sarjana' ? 'selected' : '' }}>Sarjana</option>
                                <!-- Tambahkan opsi pendidikan lainnya sesuai kebutuhan -->
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="hobi">Hobi:</label>
                            <input type="text" class="form-control" 
                            id="hobi" name="hobi" 
                            autocomplete="off"
                            value="{{ auth()->user()->user_profile->hobi ?? '' }}">
                        </div>
                        <div class="form-group">
                            <label for="nomor_telepon">Nomor Telepon:</label>
                            <input type="text" class="form-control" 
                            id="nomor_telepon" name="nomor_telepon" 
                            autocomplete="off"
                            value="{{ auth()->user()->user_profile->nomor_telepon ?? '' }}">
                        </div>
                        <div class="form-group">
                            <label for="instagram_link">Username Instagram:</label>
                            <input type="text" class="form-control" 
                            id="instagram_link" name="instagram_link" 
                            autocomplete="off"
                            value="{{ auth()->user()->user_profile->instagram_link ?? '' }}">
                        </div>

                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                          <button type="submit" class="btn btn-primary d-none" id="saveButton">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
       </div>
    </div>
  </div>

  @push('modaljs')
  <script type="text/javascript">
      $(document).ready(function() {
          const editProfileButton = $("#editProfileButton"); // Menggunakan ID
          const profileButton = $("#profileButton"); // Menggunakan ID
          const saveButton = $("#saveButton"); // Menggunakan ID
          const profileContainer = $(".profile-container");
          const editProfileContainer = $(".edit-profile-container");
  
          editProfileButton.click(function() {
              profileContainer.css("display", "none");
              editProfileContainer.css("display", "block");
              saveButton.removeClass('d-none');
              editProfileButton.addClass('d-none');
          });
          profileButton.click(function() {
              profileContainer.css("display", "flex");
              editProfileContainer.css("display", "none");
              saveButton.addClass('d-none');
              editProfileButton.removeClass('d-none');
          });
      });
  </script>
  @endpush
  
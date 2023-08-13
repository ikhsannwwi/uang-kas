<!-- Modal Reset PIN-->
<div class="modal fade" id="resetPINModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Reset PIN</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="{{route('admin.users.resetPIN',auth()->user()->id)}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
              <label for="exampleInputPIN1" class="form-label">PIN Baru</label>
              <div class="input-group">
                <input type="password" name="pin" class="form-control" id="exampleInputPIN1" aria-describedby="emailHelp">
                <div class="input-group-append">
                  <button class="btn btn-outline-secondary toggle-password" 
                          type="button" 
                          data-target="#exampleInputPIN1">
                    <i class="fa fa-eye"></i>
                  </button>
                </div>
              </div>
            </div>
            <div class="mb-3">
              <label for="exampleInputPIN2" class="form-label">Konfirmasi PIN Baru</label>
              <div class="input-group">
                <input type="password" name="konfirmasi_pin" class="form-control" id="exampleInputPIN2">
                <div class="input-group-append">
                  <button class="btn btn-outline-secondary toggle-password" 
                          type="button" 
                          data-target="#exampleInputPIN2">
                    <i class="fa fa-eye"></i>
                  </button>
                </div>
              </div>
            </div>
            <div class="mb-3">
              <label for="exampleInputPassword3" class="form-label">Password</label>
              <div class="input-group">
                <input type="password" name="password" class="form-control" id="exampleInputPassword3">
                <div class="input-group-append">
                  <button class="btn btn-outline-secondary toggle-password" 
                          type="button" 
                          data-target="#exampleInputPassword3">
                    <i class="fa fa-eye"></i>
                  </button>
                </div>
              </div>
            </div>
            {{-- <button type="submit" class="btn btn-primary">Submit</button> --}}
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>
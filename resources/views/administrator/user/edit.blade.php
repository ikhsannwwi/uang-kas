@extends('administrator.layout.main')

@section('content')

@push('title')
    Edit User
@endpush

@section('content')
<div class="col-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Users</h4>
        <p class="card-description"> Form Edit User <strong>{{$data->name}}</strong></p>
        <form class="forms-sample" id="myForm"
        action="{{route('admin.users.update',$data->id)}}"
        method="post"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')
            <div class="form-group">
              <label for="kode">Kode</label>
              <input type="text" class="form-control @error('kode') is-invalid @enderror" 
              name="kode" id="kode" value="{{$data->kode}}"
              placeholder="Masukkan Kode">
                @error('kode')
                    <span class="invalid-feedback d-block">{{$message}}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="exampleInputName1">Name</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                name="name" id="name" value="{{$data->name}}"
                placeholder="Masukkan Nama">
                @error('name')
                    <span class="invalid-feedback d-block">{{$message}}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="exampleInputEmail3">Email address</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                name="email" id="email" value="{{$data->email}}"
                placeholder="Masukkan E-Mail">
                @error('email')
                    <span class="invalid-feedback d-block">{{$message}}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="exampleInputPassword4">Password</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                name="password" id="password"
                placeholder="Masukkan Password">
                @error('password')
                    <span class="invalid-feedback d-block">{{$message}}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="konfirmasi_password">Password Konfirmasi</label>
                <input type="password" class="form-control @error('konfirmasi_password') is-invalid @enderror" 
                name="konfirmasi_password" id="konfirmasi_password"
                placeholder="Masukkan Konfirmasi Password">
                @error('konfirmasi_password')
                    <span class="invalid-feedback d-block">{{$message}}</span>
                @enderror
            </div>
            <div class="form-group">
                <label>Foto</label>
                <input type="file" name="foto" 
                class="file-upload-default"
                id="fotoUpload"
                accept="image/*">
                <div class="input-group col-xs-12">
                    <input name="foto"  class="form-control file-upload-info @error('foto') is-invalid @enderror" disabled placeholder="Upload Image">
                    <span class="input-group-append">
                        <label class="file-upload-browse btn btn-primary" 
                        type="button"
                        for="fotoUpload">Select Image</label>
                    </span>
                </div>
                @error('foto')
                    <span class="invalid-feedback d-block">{{$message}}</span>
                @enderror
            </div>
          <button type="submit" class="btn btn-primary mr-2" id="submitForm">Submit</button>
          <a href="{{route('admin.users')}}" class="btn btn-light">Cancel</a>
        </form>
      </div>
    </div>
  </div>
@endsection

@push('js')
<script type="text/javascript">
    $(document).ready(function() {
        const form = document.getElementById("myForm");

            var validator = FormValidation.formValidation(form, {
                fields: {
                    kode: {
                        validators: {
                            notEmpty: {
                                message: "Silahkan isi Kode",
                            },
                            // remote: {
                            //     message: "Kode ini sudah dipakai",
                            //     method: "POST",
                            //     url: "{{ route('admin.users.isExistKode') }}",
                            //     data: function(){
                            //         return {
                            //             _token: "{{ csrf_token() }}",
                            //         }
                            //     },
                            // },
                        },
                    },
                    name: {
                        validators: {
                            notEmpty: {
                                message: "Silahkan isi Nama",
                            },
                        },
                    },
                    email: {
                        validators: {
                            notEmpty: {
                                message: "Silahkan isi Email",
                            },
                            emailAddress: {
                                message: "Format email tidak valid",
                            },
                            // remote: {
                            //     message: "Email ini sudah dipakai",
                            //     method: "POST",
                            //     url: "{{ route('admin.users.isExistEmail') }}",
                            //     data: function(){
                            //         return {
                            //             _token: "{{ csrf_token() }}",
                            //         }
                            //     },
                            // },
                        },
                    },
                    password: {
                        validators: {
                            notEmpty: {
                                message: "Silahkan isi Password",
                            },
                            stringLength: {
                                min: 8,
                                message: "Password minimal harus terdiri dari 8 karakter",
                            },
                        },
                    },
                    konfirmasi_password: {
                        validators: {
                            notEmpty: {
                                message: "Silahkan Konfirmasi Password",
                            },
                            identical: {
                                compare: function() {
                                    return form.querySelector('[name="password"]').value;
                                },
                                message: "Konfirmasi Password harus sama dengan Password",
                            },
                        },
                        
                    },
                },

                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    // trigger: new FormValidation.plugins.Trigger(),
                    bootstrap: new FormValidation.plugins.Bootstrap5({
                        rowSelector: ".form-group",
                        eleInvalidClass: "is-invalid",
                        eleValidClass: "",
                    }),
                },
            });
            const submitButton = document.getElementById("submitForm");
            submitButton.addEventListener("click", function (e) {
                e.preventDefault();
            });
    });
    </script>


@endpush
@endsection

@push('js')
    
@endpush
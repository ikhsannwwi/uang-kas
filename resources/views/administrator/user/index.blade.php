@extends('administrator.layout.main')

@push('title')
    Users
@endpush

@section('content')
<div class="col-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <h5 class="card-title">List User</h5>
            </div>
            <div class="col-md-6">
                <div class="d-flex float-end gap-2">
                    <button type="button" id="btn_filter" class="btn btn-primary label-button-master my-3">
                        <i class="bi bi-filter"></i> Filter
                    </button>
                    <a href="{{ route('admin.users.add')}}" class="btn btn-primary label-button-master my-3">
                        <i class="mdi mdi-file-check btn-icon-prepend"></i> Tambah
                    </a>
                </div>
            </div>
        </div>
        <div class="row mb-3" id="filter_section" style="display: none;">
            <div class="col-md-12">
                <form id="filter_form">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-12 pt-3">
                                    <div class="form-group fv-row">
                                        <label class="required form-label">User</label>
                                        <select class="form-select btn-sm form-select-solid"
                                            data-hide-search="true" id="filteruser">
                                            <option value="">Semua Status</option>
                                            <option value="active">Aktif</option>
                                            <option value="non-active">Tidak Aktif</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row my-3">
                            <div class="col-md-12">
                                <div class="d-flex gap-1 float-end">
                                    <button type="reset" id="reset-btn" class="btn btn-danger text-white">Reset</button>
                                    <button id="filter_submit" class="btn btn-primary">Filter</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        <!--end::Card toolbar-->
        </div>
        <table class="table table-hover" id="datatable">
          <thead>
            <tr>
              <th>No</th>
              <th>Kode</th>
              <th>Nama</th>
              <th>Email</th>
              <th width="15px">Action</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
@endsection
@php
    $Route = route('admin.users');
@endphp
<!-- ... Your HTML code ... -->

@push('js')
<script type="text/javascript">
    $(document).ready(function() {
      
        var data_table = $('#datatable').DataTable({
            "oLanguage": {
                "oPaginate": {
                    "sFirst": "<i class='ti-angle-left'></i>",
                    "sPrevious": "&#8592;",
                    "sNext": "&#8594;",
                    "sLast": "<i class='ti-angle-right'></i>"
                }
            },
            processing: true,
            serverSide: true,
            order: [[0, 'desc']],
            ajax: {
                url: '{{ route('admin.users.getdata') }}',
                dataType: "JSON",
                type: "GET",
            },
            columns: [
                {
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    },
                },
                { data: 'kode', name: 'kode' },
                { data: 'name', name: 'name' },
                { data: 'email', name: 'email' },
                {
                    data: 'action', name:'action',
                    'searchable': false
                }
            ],
        });
    });

    $(document).on('click', '.delete', function(event) {
    var id = $(this).data('id');
    var title = $(this).data('title');
    // var data_table = data_table;
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success mx-4',
            cancelButton: 'btn btn-danger'
        },
        buttonsStyling: false
    });

    swalWithBootstrapButtons.fire({
        title: 'Apakah anda yakin ingin menghapus data ini : ' + title,
        icon: 'warning',
        buttonsStyling: false,
        showCancelButton: true,
        confirmButtonText: 'Ya, Saya yakin!',
        cancelButtonText: 'Tidak, Batalkan!',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "POST",
                url: "{{ route('admin.users.delete') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "_method": "DELETE",
                    "id": id,
                },
                success: function() {
                    swalWithBootstrapButtons.fire(
                        'Berhasil dihapus!',
                        'Data berhasil dihapus.',
                        'success'
                    );
                    // data_table.ajax.reload(null,false)
                    window.location.href = "<?php echo $Route; ?>";
                }
            });
        }
    });
});


@if (session()->has('success'))
    toastr.options = {
    "closeButton": true,
    "debug": false,
    "newestOnTop": false,
    "progressBar": true,
    "rtl": false,
    "positionClass": "toast-top-right",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": 1000,
    "hideDuration": 1700,
    "timeOut": 8000,
    "extendedTimeOut": 1000,
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
  };
      toastr["success"]("{{ Session::get('success') }}",{ class: 'toast-success' })
      @endif
      </script>
    <script>
        @if (session()->has('error'))
    toastr.options = {
    "closeButton": true,
    "debug": false,
    "newestOnTop": false,
    "progressBar": true,
    "rtl": false,
    "positionClass": "toast-top-right",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": 1000,
    "hideDuration": 1700,
    "timeOut": 8000,
    "extendedTimeOut": 1000,
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
  };
      toastr["error"]("{{ Session::get('error') }}",{ class: 'toast-error' })
      @endif
    </script>
@endpush

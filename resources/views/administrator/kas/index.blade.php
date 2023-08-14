@extends('administrator.layout.main')

@section('content')
<div class="col-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <h5 class="card-title">List Kas</h5>
            </div>
            <div class="col-md-6">
                <div class="d-flex float-end gap-2">
                    <button type="button" id="btn_filter" class="btn btn-primary label-button-master my-3">
                        <i class="mdi mdi-filter-variant"></i> Filter
                    </button>
                    <button type="button" id="totalKasButton" 
                    class="btn btn-primary label-button-master my-3"
                    data-bs-toggle="modal" data-bs-target="#totalKas">
                        <i class="mdi mdi-cash-usd"></i> Total Kas
                    </button>
                    <a href="{{ route('admin.kas.add')}}" class="btn btn-primary label-button-master my-3">
                        <i class="mdi mdi-file-check btn-icon-prepend"></i> Tambah
                    </a>
                </div>
            </div>
        </div>
        <div class="row mb-3" id="filter_section" style="display: none;">
            <div class="col-md-12">
                <form id="filter_form">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6 pt-3">
                                    <div class="form-group fv-row">
                                        <label class="required form-label">Status</label>
                                        <select class="form-select btn-sm form-select-solid"
                                            data-hide-search="true" id="filterstatus">
                                            <option value="">Semua</option>
                                            <option value="pemasukan">Pemasukan</option>
                                            <option value="Pengeluaran">Pengeluaran</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 pt-3">
                                    <div class="form-group fv-row">
                                        <label class="required form-label">User</label>
                                        <select class="form-select btn-sm form-select-solid"
                                            data-hide-search="true" id="filteruser">
                                            <option value="">Semua</option>
                                            @foreach ($data_user as $row)
                                            <option value="{{$row->kode}}">{{$row->name}}</option>
                                            @endforeach
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
              <th>User</th>
              <th>Jumlah</th>
              <th>Tanggal</th>
              <th>Action</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>

  @include('administrator.kas.modal.detail')
  @include('administrator.kas.modal.total')
@endsection
@php
    $Route = route('admin.kas');
@endphp
<!-- ... Your HTML code ... -->

@push('js')
@stack('modalJs')
<script type="text/javascript">
    $(document).ready(function() {

        $('#btn_filter').on('click', function(){
            $('#filter_section').slideToggle();
        });

      
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
            order: [[3, 'desc']],
            scrollX: true, // Enable horizontal scrolling
            ajax: {
                url: '{{ route('admin.kas.getdata') }}',
                dataType: "JSON",
                type: "GET",
                data: function(d) {
                    d.status = getStatus();
                    d.user = getUser();
                }

            },
            columns: [
                {
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    },
                },
                { data: 'user.name', name: 'user.name' },
                {
                    data: 'pemasukan_pengeluaran',
                    name: 'pemasukan_pengeluaran',
                    render: function(data, type, row) {
                        let formattedValue = parseFloat(data).toLocaleString('id-ID', { style: 'currency', currency: 'IDR' });
                        
                        if (row.status === 0) { // Jika status adalah "pengeluaran"
                            formattedValue = '-' + formattedValue;
                            return '<span style="color: red; float: right;">' + formattedValue + '</span>';
                        } else if (row.status === 1) { // Jika status adalah "pemasukan"
                            return '<span style="color: green; float: right;">' + formattedValue + '</span>';
                        } else {
                            return formattedValue;
                        }
                    }
                },
                {
                    data: 'tanggal',
                    name: 'tanggal',
                    render: function(data, type, row) {
                        return moment(data).format('D MMMM YYYY');
                    }
                },
                {
                    data: 'action', name:'action',
                    searchable: false
                }
            ],
        });
        $('#filter_submit').on('click', function(event) {
            event.preventDefault(); // Prevent the default form submission behavior

            // Get the filter value using the getStatus() function
            var filterValue = getStatus();
            var filterUser = getUser();

            // Update the DataTable with the filtered data
            data_table.ajax.url('{{ route('admin.kas.getdata') }}?status=' + filterValue + '|user=' + filterUser).load();
        });

    
    
        function getStatus() {
            return $("#filterstatus").val();
        }
        
        function getUser() {
            return $("#filteruser").val();
        }
    
        $('#searchdatatable').keyup(function() {
            data_table.search($(this).val()).draw();
        })

        $(document).on('click', '.delete', function(event) {
        var id = $(this).data('id');
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success mx-4',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
        });
    
        swalWithBootstrapButtons.fire({
            title: 'Apakah anda yakin ingin menghapus data ini',
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
                    url: "{{ route('admin.kas.delete') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "_method": "DELETE",
                        "id": id,
                    },
                    success: function() {
                        data_table.ajax.url('{{ route('admin.kas.getdata') }}').load();

                        swalWithBootstrapButtons.fire(
                            'Berhasil dihapus!',
                            'Data berhasil dihapus.',
                            'success'
                        );
    
                        // Remove the deleted row from the DataTable without reloading the page
                        // data_table.row($(this).parents('tr')).remove().draw();
                    }
                });
            }
        });
    });
    });
    
</script>

@foreach ($notifikasiTerakhir as $notifikasi)
      @php
          $bulanNames = [
              1 => 'Januari', 2 => 'Februari', 3 => 'Maret',
              4 => 'April', 5 => 'Mei', 6 => 'Juni',
              7 => 'Juli', 8 => 'Agustus', 9 => 'September',
              10 => 'Oktober', 11 => 'November', 12 => 'Desember'
          ];
      @endphp
  
      <script>
          var bulanNames = @json($bulanNames);
          
          toastr["warning"]("{{ $notifikasi->user->name }} terakhir bayar pada tanggal {{ $notifikasi->tanggal->day }} " + bulanNames[{{ $notifikasi->tanggal->month }}] + " {{ $notifikasi->tanggal->year }}", { class: 'toast-warning' });
      </script>
  @endforeach
@endpush

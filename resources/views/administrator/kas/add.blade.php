@extends('administrator.layout.main')

@section('content')
<div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Kas</h4>
            <p class="card-description"> Form Add Kas </p>
            <form class="forms-sample" id="myForm" action="{{ route('admin.kas.save') }}" method="post"
                enctype="multipart/form-data">
                @csrf
                <div id="records">
                    <!-- Input fields will be added here -->
                </div>
                <button type="submit" class="btn btn-primary mr-2" id="submitForm">Submit</button>
                <a href="{{ route('admin.kas') }}" class="btn btn-light">Cancel</a>
                <button type="button" class="btn btn-primary mr-2 float-end" id="addRecord">Add Record</button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('css')
<link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/css/bootstrap-datepicker.min.css"
    integrity="sha512-34s5cpvaNG3BknEWSuOncX28vz97bRI59UnVtEEpFX536A7BtZSJHsDyFoCl8S7Dt2TPzcrCEoHBGeM4SUBDBw=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        .button-width-100 {
            width: 100%;
        }
    </style>
@endpush

@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/js/bootstrap-datepicker.min.js"
    integrity="sha512-LsnSViqQyaXpD4mBBdRYeP6sRwJiJveh2ZIbW41EBrNmKxgr/LFZIiWT6yr+nycvhvauz8c2nYMhrP80YhG7Cw=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script type="text/javascript">
    $(document).ready(function () {
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd', // Format tanggal yang diinginkan (sesuaikan dengan kebutuhan)
            autoclose: true, // Menutup datepicker setelah memilih tanggal
            orientation: 'bottom', // Menunjukkan datepicker ke bawah
        });

        

        // Create an empty array to store added records
        var recordsArray = [];

        

        // Function to add a new record input row
        function addRecordInput() {
            var index = recordsArray.length; // Define the index here
            recordsArray.push({}); // Add an empty object for now
            

            var recordInput = `
            <div class="record">
            <div class="row">
                <div class="col-12">
                    <button type="button" id="btn_dropdown_record_${index}" 
                    class="btn btn-secondary label-button-master my-3 button-width-100">
                        <i class="bi bi-filter"></i> Klik disini untuk melihat
                    </button>
                </div>
            </div>
            <div class="row" id="dropdown_record_section_${index}" style="display: none;">
                @if (auth()->user()->kode == 'K000')
                <div class="form-group col-md-3 col-12">
                    <label for="user[${index}]" class="label-required">User</label>
                    <select class="form-control @error('user_kode') is-invalid @enderror" name="user_kode[${index}]" id="user[${index}]" >
                        <option value="" selected>Pilih User</option>
                        @foreach ($data_user as $row)
                        <option value="{{$row->kode}}">{{$row->name}}</option>
                        @endforeach
                    </select>
                    @error('user_kode')
                        <span class="invalid-feedback d-block">{{$message}}</span>
                    @enderror
                </div>
                @else
                    <input type="hidden" name="user_kode[${index}]" value="{{auth()->user()->kode}}">
                @endif
                <div class="form-group col-md-6 col-12">
                    <label for="pemasukan_pengeluaran[${index}]" class="label-required">Pemasukan atau Pengeluaran</label>
                    <input type="text" class="form-control @error('pemasukan_pengeluaran') is-invalid @enderror" 
                    name="pemasukan_pengeluaran[${index}]" id="pemasukan_pengeluaran[${index}]" autocomplete="off" 
                    placeholder="Masukkan Jumlah Pemsukan atau Pengeluaran">
                        @error('pemasukan_pengeluaran')
                            <span class="invalid-feedback d-block">{{$message}}</span>
                        @enderror
                </div>
                <div class="form-group col-md-3 col-12">
                    <label for="tanggal[${index}]" class="label-required">Tanggal</label>
                    <input type="text" class="form-control datepicker @error('tanggal') is-invalid @enderror" 
                    name="tanggal[${index}]" id="tanggal[${index}]" placeholder="Pilih Tanggal" autocomplete="off">
                    @error('tanggal')
                        <span class="invalid-feedback d-block">{{$message}}</span>
                    @enderror
                </div>
                <div class="form-group col-md-3 col-12">
                    <label for="status" class="label-required">Status</label>
                    <div class="form__status d-flex @error('status') is-invalid @enderror">
                        <div class="form-check ml-3">
                            <input class="form-check-input" type="radio" name="status[${index}]" id="status_pemasukan_${index}" value="1">
                            <label class="form-check-label" for="status_pemasukan_${index}" 
                            style="margin: 0;">Pemasukan</label>
                        </div>
                        <div class="form-check ml-5">
                            <input class="form-check-input" type="radio" name="status[${index}]" id="status_pengeluaran_${index}" value="0">
                            <label class="form-check-label" for="status_pengeluaran_${index}" 
                            style="margin: 0;">Pengeluaran</label>
                        </div>
                    </div>
                    @error('status')
                        <span class="invalid-feedback d-block">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-md-9 col-12">
                    <label for="keterangan[${index}]">Keterangan</label>
                    <input type="text" class="form-control @error('keterangan') is-invalid @enderror" 
                    name="keterangan[${index}]" id="keterangan[${index}]" placeholder="Masukan Keterangan" autocomplete="off">
                    @error('keterangan')
                        <span class="invalid-feedback d-block">{{$message}}</span>
                    @enderror
                </div>
            </div>
            </div>
            `;

            $('#records').append(recordInput);
            $('.datepicker').datepicker('destroy'); // Destroy previous datepickers
            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                orientation: 'bottom',
            });

            $('#btn_dropdown_record_' + index).on('click', function(){
                $('#dropdown_record_section_' + index).slideToggle();
            });
        }

        // Add record input on button click
        $('#addRecord').on('click', function () {
            var index = recordsArray.length;
            recordsArray.push({}); // Add an empty object for now
            addRecordInput(index); // Pass the index to the function
        });

        // Submit form
        $('#submitForm').on('click', function () {
            $('#myForm').submit(); // Submit the form
        });

        // Initialize with one record input row
        addRecordInput();
    });
</script>
@endpush

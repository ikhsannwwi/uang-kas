@extends('administrator.layout.main')

@section('content')
<div class="col-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Kas</h4>
        <p class="card-description"> Form Edit Kas </p>
        <form class="forms-sample" id="myForm"
        action="{{route('admin.kas.update',$data->id)}}"
        method="post"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')
            <div class="row">
                @if (auth()->user()->kode == 'K000')
                <div class="form-group col-12">
                    <label for="user" class="label-required">User</label>
                    <select class="form-control @error('user_kode') is-invalid @enderror" name="user_kode" id="user" >
                        <option value="{{$data->user_kode}}" selected>{{$data->user->name}}</option>
                        @foreach ($data_user as $row)
                        <option value="{{$row->kode}}">{{$row->name}}</option>
                        @endforeach
                    </select>
                    @error('user_kode')
                        <span class="invalid-feedback d-block">{{$message}}</span>
                    @enderror
                </div>
                @else
                    <input type="hidden" name="user_kode" value="{{auth()->user()->kode}}">
                @endif
                <div class="form-group col-6">
                    <label for="pemasukan_pengeluaran" class="label-required">Pemasukan atau Pengeluaran</label>
                    <input type="text" class="form-control @error('pemasukan_pengeluaran') is-invalid @enderror" 
                    name="pemasukan_pengeluaran" id="pemasukan_pengeluaran" autocomplete="off" 
                    placeholder="Masukkan Jumlah Pemsukan atau Pengeluaran" value="{{$data->pemasukan_pengeluaran}}">
                        @error('pemasukan_pengeluaran')
                            <span class="invalid-feedback d-block">{{$message}}</span>
                        @enderror
                </div>
                <div class="form-group col-6">
                    <label for="tanggal" class="label-required">Tanggal</label>
                    <input type="text" class="form-control datepicker @error('tanggal') is-invalid @enderror" 
                    name="tanggal" id="tanggal" placeholder="Pilih Tanggal" value="{{$data->tanggal}}" autocomplete="off">
                    @error('tanggal')
                        <span class="invalid-feedback d-block">{{$message}}</span>
                    @enderror
                </div>
                <div class="form-group col-12">
                    <label for="keterangan">Keterangan</label>
                    <input type="text" class="form-control @error('keterangan') is-invalid @enderror" 
                    name="keterangan" id="keterangan" value="{{$data->keterangan}}" placeholder="Masukan Keterangan" autocomplete="off">
                    @error('keterangan')
                        <span class="invalid-feedback d-block">{{$message}}</span>
                    @enderror
                </div>
                <div class="form-group col-12">
                    <label for="status" class="label-required">Status</label>
                    <div class="form__status d-flex @error('status') is-invalid @enderror">
                        <div class="form-check ml-3">
                            <input class="form-check-input" type="radio" name="status" id="status_pemasukan" value="1">
                            <label class="form-check-label" for="status_pemasukan" 
                            style="margin: 0;">Pemasukan</label>
                        </div>
                        <div class="form-check ml-5">
                            <input class="form-check-input" type="radio" name="status" id="status_pengeluaran" value="0">
                            <label class="form-check-label" for="status_pengeluaran" 
                            style="margin: 0;">Pengeluaran</label>
                        </div>
                    </div>
                    @error('status')
                        <span class="invalid-feedback d-block">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <button type="submit" class="btn btn-primary mr-2" id="submitForm">Submit</button>
          <a href="{{route('admin.kas')}}" class="btn btn-light">Cancel</a>
        </form>
      </div>
    </div>
  </div>
@endsection

@push('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/css/bootstrap-datepicker.min.css" integrity="sha512-34s5cpvaNG3BknEWSuOncX28vz97bRI59UnVtEEpFX536A7BtZSJHsDyFoCl8S7Dt2TPzcrCEoHBGeM4SUBDBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

@endpush
@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/js/bootstrap-datepicker.min.js" integrity="sha512-LsnSViqQyaXpD4mBBdRYeP6sRwJiJveh2ZIbW41EBrNmKxgr/LFZIiWT6yr+nycvhvauz8c2nYMhrP80YhG7Cw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd', // Format tanggal yang diinginkan (sesuaikan dengan kebutuhan)
            autoclose: true, // Menutup datepicker setelah memilih tanggal
            orientation: 'bottom', // Menunjukkan datepicker ke bawah
            startDate: '{{$data->tanggal}}'
        });

        var dataValue = {{$data->status}}; // Echo the PHP variable

        // Check the appropriate radio button based on the data value
        if (dataValue === 1) { // Remove the quotes around the number
            document.getElementById("status_pemasukan").checked = true;
        } else if (dataValue === 0) { // Remove the quotes around the number
            document.getElementById("status_pengeluaran").checked = true;
        }
    });
</script>



@endpush
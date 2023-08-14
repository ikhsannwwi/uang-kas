<?php

namespace App\Http\Controllers\admin;

use DataTables;
use App\Models\User;
use App\Models\admin\kas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class kasController extends Controller
{
    public function index(){

        $data_user = User::all();

        $notifikasiTerakhirSetiapUser = kas::with('user')
            ->select('user_kode', DB::raw('MAX(tanggal) as tanggal_terakhir'))
            ->groupBy('user_kode')
            ->orderBy('tanggal_terakhir', 'desc')
            ->get();

        $notifikasiTerakhir = [];

        foreach ($notifikasiTerakhirSetiapUser as $notifikasiUser) {
            $notifikasi = kas::where('user_kode', $notifikasiUser->user_kode)
                ->where('tanggal', $notifikasiUser->tanggal_terakhir)
                ->with('user')
                ->first();

            if ($notifikasi) {
                $notifikasi->tanggal = \Carbon\Carbon::parse($notifikasi->tanggal); // Ubah ke objek Carbon
                $notifikasiTerakhir[] = $notifikasi;
            }
        }


        // $notifikasi = kas::with('user')
        //     ->where('user_kode', auth()->user()->kode)
        //     ->orderBy('tanggal', 'desc')
        //     ->first();
        //         # code...
        // // Session::flash('notifikasi', $notifikasi);
        // session(['notifikasi' => $notifikasi]);

        // dd($notifikasi);

        return view('administrator.kas.index',compact('data_user','notifikasiTerakhir'));
    }

    public function getdata(Request $request) {
        $data = kas::query()->with('user');
    
        if ($request->status) {
            $status = $request->status == "pemasukan" ? 1 : 0;
            $data = $data->where("status", $status);
        }
        if ($request->user) {
            $filter_user = $request->user;
            $data = $data->where("user_kode", $filter_user);
        }
    
        return Datatables::eloquent($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = '';
                $btn .= '<a href="#" data-id="' . $row->id . '" class="btn btn-danger btn-sm delete me-3 label-button-crud">
                    Delete
                </a>';
    
                $btn .= '<a href="' . route('admin.kas.edit', $row->id) . '" class="btn btn-primary btn-sm me-3 label-button-crud">
                    Edit
                </a>';
    
                $btn .= '<a href="#" class="btn btn-secondary btn-sm me-3 label-button-crud" data-id="' . $row->id . '" data-bs-toggle="modal" data-bs-target="#detailKas">
                    Detail
                </a>';
    
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    

    public function add()
    {
        if (auth()->user()->kode == 'K000') {
            # code...
            $data_user = User::all();
        } else {
            $data_user = '';
        }
        
        return view("administrator.kas.add",compact('data_user'));
    }


    public function save(Request $request)
    {
        // Validasi data yang dikirimkan dalam request
        $validator = Validator::make($request->all(), [
            'pemasukan_pengeluaran' => 'required',
            'tanggal' => 'required',
            'status' => 'required',
            // Tambahkan aturan validasi lainnya yang Anda butuhkan
        ]);

        if ($request->keterangan) {
            $validator->addRules([
                'keterangan' => 'required',
            ]);
        }

        if (auth()->user()->kode == 'K000') {
            $validator->addRules([
                'user_kode' => 'required',
            ]);
        }

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }




        $user_kode = $request->user_kode;
        $pemasukan_pengeluaran = $request->pemasukan_pengeluaran;
        $tanggal = $request->tanggal;
        $statusArray = $request->status;
        $keterangan = $request->keterangan;
    
        // Loop through the data and create records
        foreach ($statusArray as $index => $status) {
            $data = kas::create([
                'user_kode' => $user_kode[$index],
                'pemasukan_pengeluaran' => $pemasukan_pengeluaran[$index],
                'tanggal' => $tanggal[$index],
                'status' => $status,
            ]);
    
            // Additional processing if needed
            if ($keterangan[$index]) {
                # code...
                $data->keterangan = $keterangan[$index];
            }
            // dd($pemasukan_pengeluaran[$index]);
        }

        $data->save();

        return redirect()->route('admin.kas')->with('success','Data berhasil ditambahkan');
    }

    public function edit($id) {
        $data = kas::find($id);

        if (auth()->user()->kode == 'K000') {
            # code...
            $data_user = User::all();
        } else {
            $data_user = '';
        }

        return view('administrator.kas.edit',compact('data','data_user'));
    }
    
    public function update(Request $request, $id){
        $data = kas::find($id);
        
        // Validasi data yang dikirimkan dalam request
        $validator = Validator::make($request->all(), [
            'pemasukan_pengeluaran' => 'required|integer|min:500',
            'tanggal' => 'required',
            'status' => 'required',
            // Tambahkan aturan validasi lainnya yang Anda butuhkan
        ]);

        if ($request->keterangan) {
            $validator->addRules([
                'keterangan' => 'required|min:3|max:255',
            ]);
        }

        if (auth()->user()->kode == 'K000') {
            $validator->addRules([
                'user_kode' => 'required',
            ]);
        }

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        
        

        $data->update([
            'user_kode' => $request->user_kode,
            'pemasukan_pengeluaran' => $request->pemasukan_pengeluaran,
            'tanggal' => $request->tanggal,
            'status' => $request->status,
        ]);
        if ($request->keterangan) {
            # code...
            $data->keterangan = $request->keterangan;
        }
        
        $data->update();
        
        return redirect()->route('admin.kas')->with('success','Data berhasil diupdate');
    }
    
    public function detail($id) {
        $data = kas::where('id',$id)->with('user')->first();

        return response()->json($data);
    }
    
    public function total() {
        $data = kas::with('user')->get();
        $pemasukan = $data->where('status', 1)->sum('pemasukan_pengeluaran'); // Menggunakan sum() untuk menghitung jumlah pemasukan
        $pengeluaran = $data->where('status', 0)->sum('pemasukan_pengeluaran'); // Menggunakan sum() untuk menghitung jumlah pengeluaran
        $total = $pemasukan - $pengeluaran;
    
        // Mengembalikan data dalam format JSON
        return response()->json([
            'pemasukan' => $pemasukan,
            'pengeluaran' => $pengeluaran,
            'total' => $total
        ]);
    }
    
    
    
    public function delete(Request $request) {
        $id = $request->id;
        
        $data = kas::find($id);

        $data->delete();

        return redirect()->route('admin.kas')->with('succes','Data berhasil dihapus');
    }

    
}

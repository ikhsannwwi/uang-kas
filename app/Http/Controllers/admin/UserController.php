<?php

namespace App\Http\Controllers\admin;

use DB;
use DataTables;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\admin\userProfile;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{
    public function index(){
        return view('administrator.user.index');
    }

    public function getdata(){
        $data = User::query();
        if (auth()->user()->kode != 'K000') {
            # code...
            $data->where('kode',auth()->user()->kode);
        } else {
            $data;
        }

        return Datatables::eloquent($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $btn = "";
                if (auth()->user()->kode == 'K000') {
                    # code...
                    $btn .= '<a href="#" data-id="' . $row->id . '" data-title="' . $row->name . '" class="btn btn-danger btn-sm delete me-3 label-button-crud">
                        Delete
                    </a>';
                }
                
                $btn .= '<a href="'.route('admin.users.edit',$row->id).'" class="btn btn-primary btn-sm me-3 label-button-crud">
                    Edit
                </a>';
                $btn .= '<a href="#" class="btn btn-secondary btn-sm me-3 label-button-crud" data-kode="' . $row->kode . '" data-bs-toggle="modal" data-bs-target="#detailUser">
                    Detail
                </a>';

                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function add()
    {
        return view("administrator.user.add");
    }


    public function save(Request $request)
    {
        // Validasi data yang dikirimkan dalam request
        $validator = Validator::make($request->all(), [
            'kode' => 'required|max:4|string|unique:users,kode',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|min:8|max:255',
            'konfirmasi_password' => 'required|min:8|max:255|same:password',
            // Tambahkan aturan validasi lainnya yang Anda butuhkan
        ]);
        if ($request->foto) {
            $validator->addRules([
                'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
        }
        

        
        // dd($validator);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data = User::create([
            'kode' => $request->kode,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'pin' => Hash::make(000000),
            'remember_token' => Str::random(60),
        ]);
        if (!$request->foto) {
            # code...
            $data->foto = 'default.svg';
        } elseif ($request->hasFile('foto')) {
            $filename = Str::random(8). '.' . $request->file('foto')->extension();
            $request->file('foto')->move('images/banner', $filename);
            $data->foto = $filename;
        }

        $data->save();

        return redirect()->route('admin.users')->with('success','Data berhasil ditambahkan');
    }

    public function edit($id) {
        $data = User::find($id);

        return view('administrator.user.edit',compact('data'));
    }
    
    public function update(Request $request, $id){
        $data = User::find($id);
        
        // Validasi data yang dikirimkan dalam request
        $validator = Validator::make($request->all(), [
            'kode' => 'required|max:4|string|unique:users,kode,' . $id,
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            // Tambahkan aturan validasi lainnya yang Anda butuhkan
        ]);

        if ($request->password || $request->konfirmasi_password) {
            $validator->addRules([
                'password' => 'required|min:8|max:255',
                'konfirmasi_password' => 'required|min:8|max:255|same:password',
            ]);
        }
        
        if ($request->pin) {
            $validator->addRules([
                'pin' => 'required|integer|min:6|max:6',
            ]);
        }

        if ($request->foto) {
            $validator->addRules([
                'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
        }

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        
        

        $data->update([
            'kode' => $request->kode,
            'name' => $request->name,
            'email' => $request->email,
            'remember_token' => Str::random(60),
        ]);
        
        if ($request->password) {
            # code...
            $data->password = Hash::make($request->password);
        }
        if ($request->pin) {
            # code...
            $data->pin = Hash::make($request->pin);
        }
        
        if (!$request->foto) {
            # code...
            if (File_exists(public_path('administrator/users/' . $data->foto))) { //either you can use file path instead of $data->image
                $data->foto = $data->foto;
            }else {
                # code...
                $data->foto = 'default.svg';
            }
        } elseif ($request->hasFile('foto')) {
            if ($data->foto != 'default.svg') {
                # code...
                if (File_exists(public_path('administrator/users/' . $data->foto))) { //either you can use file path instead of $data->image
                    unlink(public_path('administrator/users/' . $data->foto)); //here you can also use path like as ('uploads/media/welcome/'. $data->image)
                }
            }
            $filename = Str::random(8). '.' . $request->file('foto')->extension();
            $request->file('foto')->move('administrator/users', $filename);
            $data->foto = $filename;
        }

        $data->update();
        
        return redirect()->route('admin.users')->with('success','Data berhasil diupdate');
    }
    
    public function detail($kode) {
        $data = User::where('kode',$kode)->with('user_profile')->first();

        return response()->json($data);
    }
    
    public function delete(Request $request) {
        $id = $request->id;
        
        $data = User::find($id);
        if ($data->foto != 'default.svg') {
            # code...
            if (File_exists(public_path('administrator/users/' . $data->foto))) { //either you can use file path instead of $data->image
                unlink(public_path('administrator/users/' . $data->foto)); //here you can also use path like as ('uploads/media/welcome/'. $data->image)
            }
        }

        $data->delete();

        return redirect()->route('admin.users')->with('succes','Data berhasil dihapus');
    }

    public function resetPassword(Request $request,$id){

        $data = User::find($id);

        // Validasi data yang dikirimkan dalam request
        $validator = Validator::make($request->all(), [
            'password' => 'required|min:8|max:255',
            'konfirmasi_password' => 'required|min:8|max:255|same:password',
            'pin' => 'required|min:6|max:6',
            // Tambahkan aturan validasi lainnya yang Anda butuhkan
        ]);

        if ($validator->fails()) {
            $errorMessages = $validator->errors()->all();
            Session::flash('errors', $errorMessages);
            return back();
        }

        if (auth()->user()->pin == $request->pin) {
            # code...
            $data->update([
                'password' => $request->password,
                'remember_token' => Str::random(60),
            ]);
            $data->update();

            $statusMessage = 'success';
            $message = 'Password telah diubah';
        } else {
            # code...
            $statusMessage = 'error';
            $message = 'PIN Anda salah';
        }
        
        return back()->with($statusMessage,$message);
    }
    
    public function resetPIN(Request $request,$id){

        $data = User::find($id);

        // Validasi data yang dikirimkan dalam request
        $validator = Validator::make($request->all(), [
            'pin' => 'required|min:6',
            'konfirmasi_pin' => 'required|min:6|same:pin',
            'password' => 'required|min:8',
            // Tambahkan aturan validasi lainnya yang Anda butuhkan
        ]);

        // dd([auth()->user()->password]);
        if ($validator->fails()) {
            $errorMessages = $validator->errors()->all();
            Session::flash('errors', $errorMessages);
            return back();
        }

        if (Hash::check($request->password, auth()->user()->password)) {
            # code...
            $data->update([
                'pin' => $request->pin,
                'remember_token' => Str::random(60),
            ]);
            $data->update();
            $statusMessage = 'success';
            $message = 'PIN telah diubah';
        } else {
            # code...
            $statusMessage = 'error';
            $message = 'Password Anda salah';
        }
        
        return back()->with($statusMessage,$message);
    }

    public function updateProfile(Request $request, $kode){
        $data = userProfile::where('user_kode',$kode);
        
        // Validasi data yang dikirimkan dalam request
        $validator = Validator::make($request->all(), [
        ]);

        if ($request->password || $request->konfirmasi_password) {
            $validator->addRules([
                'password' => 'required|min:8|max:255',
                'konfirmasi_password' => 'required|min:8|max:255|same:password',
            ]);
        }
        
        if ($request->nama_lengkap) {
            $validator->addRules([
                'nama_lengkap' => 'required|string|max:255',
            ]);
        }

        if ($request->tempat_lahir) {
            $validator->addRules([
                'tempat_lahir' => 'required||string|max:255',
            ]);
        }
        
        if ($request->tanggal_lahir) {
            $validator->addRules([
                'tanggal_lahir' => 'required||date|max:255',
            ]);
        }
        
        if ($request->alamat) {
            $validator->addRules([
                'alamat' => 'required||string|min:5|max:500',
            ]);
        }
        
        if ($request->hobi) {
            $validator->addRules([
                'hobi' => 'required||string|min:2|max:50',
            ]);
        }
        
        if ($request->nomor_telepon) {
            $validator->addRules([
                'nomor_telepon' => 'required|min:11|max:15',
            ]);
        }
        
        if ($request->instagram_link) {
            $validator->addRules([
                'instagram_link' => 'required||string|min:2|max:255',
            ]);
        }

        if ($validator->fails()) {
            $errorMessages = $validator->errors()->all();
            Session::flash('errors', $errorMessages);
            return back();
        }

        
        if ($data) { // Check if the data exists before attempting updates
            $data->update([
                'user_kode' => auth()->user()->kode,
                'nama_lengkap' => $request->nama_lengkap,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'alamat' => $request->alamat,
                'riwayat_pendidikan' => $request->riwayat_pendidikan,
                'hobi' => $request->hobi,
                'nomor_telepon' => $request->nomor_telepon,
                'instagram_link' => $request->instagram_link,
            ]);
            // $data->update();
            $statusMessage = 'success';
            $message = 'Data berhasil disimpan';
        
            return back()->with($statusMessage, $message);
        } else {
            $statusMessage = 'error';
            $message = 'Data not found'; // Or any appropriate message
            return back()->with($statusMessage, $message);
        }
    }
}

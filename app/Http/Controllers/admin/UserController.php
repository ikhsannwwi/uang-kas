<?php

namespace App\Http\Controllers\admin;

use DB;
use DataTables;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{
    public function index(){
        return view('administrator.user.index');
    }

    public function getdata(){
        $data = User::query();

        return Datatables::eloquent($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $btn = "";
                $btn .= '<a href="#" data-id="' . $row->id . '" data-title="' . $row->name . '" class="btn btn-danger btn-sm delete me-3 label-button-crud">
                    Delete
                </a>';
                
                $btn .= '<a href="'.route('admin.users.edit',$row->id).'" class="btn btn-primary btn-sm me-3 label-button-crud">
                    Edit
                </a>';
                
                $btn .= '<a href="'.route('admin.users.detail',$row->id).'" class="btn btn-secondary btn-sm me-3 label-button-crud">
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

//     public function uploadImage(Request $request){
//     $request->validate([
//         'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
//     ]);

//     if ($request->hasFile('image')) {
//         $image = $request->file('image');
//         $imageName = time() . '.' . $image->getClientOriginalExtension();

//         // Tampilkan gambar sebelum disimpan
//         return view('show_image')->with('image', $image);
//     }

//     // Tangani jika tidak ada gambar yang dipilih
// }

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

        
        // dd($validator);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data = User::create([
            'kode' => $request->kode,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
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
            'kode' => 'required|max:4|string|unique:users,kode,' .$id,
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' .$id,
            // Tambahkan aturan validasi lainnya yang Anda butuhkan
        ]);
        if ($request->password) {
            # code...
            $validator = Validator::make($request->all(), [
                'password' => 'required|min:8|max:255',
                'konfirmasi_password' => 'required|min:8|max:255',
            ]);
        }
        if ($request->foto) {
            # code...
            $validator = Validator::make($request->all(), [
                'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
        }
        
        
        // dd($validator);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        
        

        $data->update([
            'kode' => $request->kode,
            'name' => $request->name,
            'email' => $request->email,
            'remember_token' => Str::random(60),
        ]);
        
        if ($request->has('password')) {
            # code...
            $data->password = Hash::make($request->password);
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
    
    public function detail($id) {
        $data = User::find($id);

        return view('administrator.user.detail',compact('data'));
    }
    
    public function delete(Request $request) {
        $id = $request->id;
        
        $data = User::find($id);
        if (File_exists(public_path('administrator/users/' . $data->foto))) { //either you can use file path instead of $data->image
            unlink(public_path('administrator/users/' . $data->foto)); //here you can also use path like as ('uploads/media/welcome/'. $data->image)
        }

        $data->delete();

        return redirect()->route('admin.users')->with('succes','Data berhasil dihapus');
    }


    public function isExistEmail(){
        
    }
    
    public function isExistKode(){

    }
}

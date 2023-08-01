<?php

namespace App\Http\Controllers\admin;

use App\Models\admin\kas;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class kasController extends Controller
{
    public function index()
    {
        return view("administrator.kas.index");
    }

    public function getData(Request $request)
    {
        $query = kas::select(DB::raw('kas.*, user.name as user'))
        ->Join(DB::raw('user'), 'user.id', '=', 'kas.user');

        $data = $query->get();

        return DataTables::of($data)
            ->addColumn('action', function ($row) {
                $btn = "";
                $btn .= '<a href="'.route('admin.kas.edit',$row->id).'" class="btn btn-primary btn-sm me-3 label-button-crud">
                Edit
            </a>';
                $btn .= '<a href="#" data-ix="' . $row->id . '" class="btn btn-danger btn-sm delete me-3 label-button-crud">
                Delete
            </a>';
                return $btn;
            })->rawColumns(['user', 'kas' , 'action'])->make(true);
    }

    public function add()
    {
        

        $user_groups = UserGroup::where("user_groups.status", 1)->get();
        return view("administrator.users.add",compact("user_groups"));
        // return view("administrator.users.example.add",compact("user_groups"));
    }

    public function save(Request $request)
    {
        

        // dd($request);
        $this->validate($request, [
            'name'      => ['required', 'string', 'max:255'],
            'email'     => ['required', 'string', 'email', 'max:255'],
            'password'  => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $data = [
            'user_group_id'     => $request->user_group,
            'name'              => $request->name,
            'email'             => $request->email,
            'customer_id'       => $request->customer_id,
            'password'          => Hash::make($request->password),
            'status'            => $request->has('status') ? 1 : 0,
        ];

        $user = User::create($data);
        
        //Write log
        createLog(static::$module, __FUNCTION__, $user->id);
        return redirect(route('admin.users'))->with(['success' => 'Data berhasil ditambahkan.']);
    }

    public function detail($id)
    {
        

        $detail = User::find($id);
        if (!$detail) {
            return abort(404);
        }

        return view('administrator.users.detail', compact("detail"));
    }

    public function edit($id)
    {
        
        
        $edit = User::find($id);
        if (!$edit) {
            return abort(404);
        }
        $user_groups = UserGroup::where("user_groups.status", 1)->get();
        $getCustomer = User::select('customers.*', 'customers.name as customer_name', 'customers.company_name as company_name')
        ->join(('customers'), 'customers.id', '=', 'users.customer_id')
        ->where(['users.id' => $id])
        ->first();
        // dd($getCustomer);

        // return view("administrator.users.example.edit", compact("user_groups", "edit", "getCustomer"));
        return view("administrator.users.edit", compact("user_groups", "edit", "getCustomer"));
    }

    public function update(Request $request)
    {
        

        $this->validate($request, [
            'name' => 'required'
        ]);

        // dd($request);
        $data = [
            'user_group_id'     => $request->user_group,
            'name'              => $request->name,
            'email'             => $request->email,
            'customer_id'       => $request->customer_id,
            'status'            => $request->has('status') ? 1 : 0,
        ];

        if($request->has('password') && $request->password != ""){
            $data['password'] = Hash::make($request->password);
        }

        $id = $request->id;
        $user = User::find($id);

        User::where('id', $id)->update($data);
        //Write log
        createLog(static::$module, __FUNCTION__, $id);
        return redirect(route('admin.users'))->with(['success' => 'Data berhasil diupdate.']);
    }

    public function delete(Request $request)
    {
        

        $id = $request->ix;
        $user_group = User::find($id);
        $data = User::destroy($request->ix);
        //Write log
        createLog(static::$module, __FUNCTION__, $id);
        return response()->json($data);
    }

    public function changeStatus(Request $request)
    {
        $data['status'] = $request->status == "active" ? 1 : 0;
        $id = $request->ix;
        if (auth()->user()->id == $id) {
            return response()->json(['massage' => 'You can'."'".'t change your own status.']);
        }
        User::where(["id" => $id])->update($data);
        //Write log
        createLog(static::$module, __FUNCTION__, $id);
        return redirect(route('admin.users'))->with(['success' => 'Status has changed.']);
    }

    public function getCustomer(Request $request)
    {        
        $query = Customers::select('customers.*')->get();
                        
        return DataTables::of($query)->make(true);
    }

    public function isExistEmail(Request $request){
        if($request->ajax()){
            $users = User::select("*");

            if(isset($request->email)){
                $users->where('email', $request->email);
            }

            if(isset($request->id)){
                $users->where('id', '<>', $request->id);
            }

            $data = [ 'valid' => ( $users->count() == 0)  ];
            if(!empty($users)){
                return $data;
            }else{
                return $data;
            }
        }
    }
}

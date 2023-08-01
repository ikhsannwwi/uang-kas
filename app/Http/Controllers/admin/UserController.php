<?php

namespace App\Http\Controllers\admin;

use DB;
use DataTables;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class UserController extends Controller
{
    public function index(){
        return view('administrator.user.index');
    }

    public function getdata(){
        $query = User::select(DB::raw('*'));
        $data = $query;

        return Datatables::eloquent($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $btn = "";
                $btn .= '<a href="#" data-ix="' . $row->id . '" class="btn btn-danger btn-sm delete me-3 label-button-crud">
                    Delete
                </a>';
                
                $btn .= '<a href="'.route('admin.users.edit',$row->id).'" class="btn btn-primary btn-sm me-3 label-button-crud">
                    Edit
                </a>';

                return $btn;
            })
            ->make(true);

    }
}

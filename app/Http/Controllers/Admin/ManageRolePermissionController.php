<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ManageRolePermissionController extends Controller
{
    protected $admin;

    public function staff()
    {
        $data['title'] = 'Manage Admin & Permission';
        $data['admins'] = Admin::where('id','!=',auth()->guard('admin')->id())->get();
        $data['admins'] = Admin::get();
        return view('admin.staff.index', $data);
    }

    public function storeStaff(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|max:191',
            'username' => 'required|alpha_dash|unique:admins,username',
            'email' => 'required|email|max:191|unique:admins,email',
            'password' => 'nullable|min:5',
            'status' => 'required'
        ]);

        $item = new Admin();
        $item->name = $request->name;
        $item->username = $request->username;
        $item->email = $request->email;
        $item->phone = $request->phone;
        if(isset($request->password)){
            $item->password = Hash::make($request->password);
        }
        $item->admin_access = (isset($request->access)) ? explode(',',join(',',$request->access)) : [];
        $item->status = $request->status;
        $item->save();

        session()->flash('success','Added Successfully');
        return back();
    }


    public function updateStaff(Request $request, $id)
    {

        $this->validate($request,[
            'name' => 'required|max:191',
            'username' => 'required|alpha_dash|unique:admins,username,'.$id,
            'email' => 'required|email|max:191|unique:admins,email,'.$id,
            'password' => 'nullable|min:5',
            'status' => 'required'
        ]);

        $item = Admin::findOrFail($id);
        $item->name = $request->name;
        $item->username = $request->username;
        $item->email = $request->email;
        $item->phone = $request->phone;
        if(isset($request->password)){
            $item->password = Hash::make($request->password);
        }
        $item->admin_access = (isset($request->access)) ? explode(',',join(',',$request->access)) : [];
        $item->status = $request->status;
        $item->save();

        session()->flash('success','Updated Successfully');
        return back();
    }
}

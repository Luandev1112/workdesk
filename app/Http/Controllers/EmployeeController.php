<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\UserRole;
use App\Models\Address;
use App\User;
use Hash;
use Gate;

class EmployeeController extends Controller
{
    public function index($type)
    {
        $role = Role::where('name', $type)->first();
        $user_roles = UserRole::where('role_id', $role->id)->paginate(10);
        return view('admin.default.employees.index', compact('user_roles', 'role'));
    }

    public function create()
    {
        if (Gate::allows('employee_create')) {
            return view('admin.default.employees.create');
        }
        else {
            flash(translate('You do not have access permission!'))->warning();
            return back();
        }
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->photo = $request->avatar;
        if ($user->save()) {
            $user_role = new UserRole;
            $user_role->user_id = $user->id;
            $user_role->role_id = $request->designation;
            $user_role->permissions = "[]";
            $user_role->save();
            $address = new Address(['street' => $request->street, 'country_id' => $request->country_id, 'city_id' => $request->city_id, 'postal_code' => $request->postal_code, 'phone' => $request->phone]);
            $user->address()->save($address);
            flash('New Employee has been appointed successfully')->success();
            return redirect()->route('employees.index', Role::find($request->designation)->name);
        }
        else {
            flash('Sorry! Something went wrong.')->error();
            return back();
        }
    }

    public function show($id)
    {
        if (Gate::allows('employee_edit')) {
            $user_role = UserRole::findOrFail(decrypt($id));
            return view('admin.default.employees.set_access_permission', compact('user_role'));
        }
        else {
            flash(translate('You do not have access permission!'))->warning();
            return back();
        }
    }

    public function edit($id)
    {
        if (Gate::allows('employee_edit')) {
            $user = User::findOrFail(decrypt($id));
            return view('admin.default.employees.edit', compact('user'));
        }
        else {
            flash(translate('You do not have access permission!'))->warning();
            return back();
        }
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->name = $request->name;

        if(strlen($request->password) > 0){
             $user->password = Hash::make($request->password);
        }
        if ($request->hasFile('avatar')) {
            $user->photo = $request->file('avatar')->store('uploads/avatar');
        }
        if ($user->save()) {
            $user_role = UserRole::where('user_id', $user->id)->first();
            $user_role->role_id = $request->designation;
            $user_role->save();
            $address = Address::where('addressable_id', $user->id)->first();
            $address->street = $request->street;
            $address->country_id = $request->country_id;
            $address->city_id = $request->city_id;
            $address->postal_code = $request->postal_code;
            $address->phone = $request->phone;
            $user->address()->save($address);
            flash('Employee Info has been updated successfully')->success();
            return redirect()->route('employees.index', Role::find($request->designation)->name);
        }
        else {
            flash('Sorry! Something went wrong.')->error();
            return back();
        }
    }

    public function destroy($id)
     {
         if (Gate::allows('employee_delete')) {
             $user_role = UserRole::where('user_id', $id)->first();
             $user = User::findOrFail($id);
             if (UserRole::destroy($user_role->id)) {
                 $user->address()->where('addressable_id', $id)->delete();
                 User::destroy($id);
                 flash(translate('Employee has been deleted successfully'))->success();
                 return redirect()->back();
             }
             else {
                 flash(translate('Something went wrong'))->error();
                 return back();
             }
         }
         else {
             flash(translate('You do not have access permission!'))->warning();
             return back();
         }
     }

    public function permission_update(Request $request, $id)
    {
        $user_role = UserRole::findOrFail($id);
        if($request->has('permissions')){
            $user_role->permissions = json_encode($request->permissions);
            if($user_role->save()){
                flash(translate('Permission has been updated successfully'))->success();
                return redirect()->back();
            }
        }
        else {
            flash(translate('Something went wrong'))->error();
            return back();
        }
    }
}

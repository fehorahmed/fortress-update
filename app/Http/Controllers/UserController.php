<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Stakeholder;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    public function index() {

        $users = User::where('role','!=', 1)->where('id','!=', 1)->orderBy('name')->get();
        //$users = User::orderBy('name')->get();
        return view('administrator.user.all', compact('users'));
    }

    public function add() {
        $projects = Project::where('status',1)->get();
        return view('administrator.user.add',compact('projects'));
    }

    public function addPost(Request $request) {

        $request->validate([
            'project' => 'required',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed'
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->project_id = $request->project;
        $user->email = $request->email;
        $user->role = 2;
        $user->user_id = Auth::id();
        $user->password = bcrypt($request->password);
        $user->save();

        $user->syncPermissions($request->permission);

        return redirect()->route('user.all')->with('message', 'User add successfully.');
    }

    public function edit(User $user) {
        $projects = Project::where('status',1)->get();
        return view('administrator.user.edit', compact('user','projects'));
    }

    public function editPost(User $user, Request $request) {
        //dd($user);
//        $request->validate([
//            'name' => 'required|string|max:255',
//            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
//            'password' => 'nullable|string|min:8|confirmed'
//        ]);

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'password' => 'nullable|string|min:8|confirmed'
        ];


        if ($user->role != 0) {
            $rules = [
                'project' => 'required',
            ];
        }

        $request->validate($rules);
//
//        //$validator = Validator::make($rules);
//
//        if ($validator->fails()) {
//            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
//        }

        $user->project_id = $request->project??null;
        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->password) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        $user->syncPermissions($request->permission);

        return redirect()->route('user.all')->with('message', 'User edit successfully.');
    }

    public function accessPermissionRole(Request $request)
    {
        $rules = [
            'role' => 'required',
        ];

        if ($request->role == 1 || $request->role == 2){
            $rules['project'] = 'required';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
        }

        if ($request->role == 2){
            $user = User::where('project_id',$request->project)
                ->where('role',2)->first();
        }else{
            $user = '';
        }
        $admin = User::where('id', Auth::id())->where('admin_status',1)->first();

        $permissions = Permission::select('name')->pluck('name')->toArray();

        if ($user && $admin) {
            $admin->project_id = $user->project_id;
            $admin->role = $user->role;
            $admin->save();
            $admin->syncPermissions($permissions);
        }elseif ($admin){
            $admin->project_id = null;
            $admin->role = 3;
            $admin->save();
            $permissions = null;
            $admin->syncPermissions($permissions);

        }
        return response()->json(['success' => true, 'message' => 'Access Permission Changed']);

    }
}

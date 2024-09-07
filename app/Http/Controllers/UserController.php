<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Table;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function __construct()
    {
        //
        $this->middleware(['role:operation'])->except(['profile', 'editProfile']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $users = User::with('role')
            ->whereHas('role', function ($query) {
                $query->where('id', '<>', 1)
                    ->orWhere('name', '<>', 'admin');
            })
            ->withTrashed()->get();
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::where('id', '<>', 1)
            ->orWhere('name', '<>', 'admin')->get();
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'employee_no' => ['required'],
            'first_name' => ['required'],
            'middle_name' => ['nullable'],
            'last_name' => ['required'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'confirmed', 'min:4'],
            'role_id' => ['required', 'exists:roles,id'],
        ]);

        do {
            $random = mt_rand(100000, 999999);
        } while (User::where('passcode', $random)->exists());

        User::create([
            'employee_no' => $request->employee_no,
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
            'passcode' => $random,
        ]);


        return redirect()->route('admin.users.index')->with('message', 'User created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
        $tables = Table::all();
        return view('admin.users.show', compact('user', 'tables'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
        $roles = Role::where('id', '<>', 1)
            ->orWhere('name', '<>', 'admin')->get();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
        $request->validate([
            'employee_no' => ['required'],
            'first_name' => ['required'],
            'middle_name' => ['nullable'],
            'last_name' => ['required'],
            'email' => ['required', 'email', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'confirmed', 'min:4'],
            'role_id' => ['required', 'exists:roles,id'],
        ]);

        $user->update([
            'employee_no' => $request->employee_no,
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'role_id' => $request->role_id,
        ]);

        if (!empty($request->password)) {
            $user->update([
                'password' => Hash::make($request->password),
            ]);
        }

        return redirect()->route('admin.users.index')->with('message', 'User updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
        if (auth()->user() == $user || $user->role_id == 1) {
            return redirect()->route('admin.users.index')->with('message', 'You cannot delete this account!');
        }

        $user->delete();
        return redirect()->route('admin.users.index')->with('message', 'User deactivated successfully!');
    }

    public function activate($user)
    {

        $user =  User::withTrashed()->find($user);
        $user->restore();
        return redirect()->route('admin.users.index')->with('message', 'User activated successfully!');
    }

    public function profile()
    {
        $user = Auth::user();
        return view('profile', compact('user'));
    }

    public function editProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([

            'first_name' => ['required'],
            'middle_name' => ['nullable'],
            'last_name' => ['required'],
            'email' => ['required', 'email', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'confirmed', 'min:4'],
        ]);

        $user->update([
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
        ]);

        if (!empty($request->password)) {
            $user->update([
                'password' => Hash::make($request->password),
            ]);
        }

        return redirect()->back()->with('message', 'Profile updated successfully!');
    }

    public function assignTable(Request $request, User $user)
    {
        //
        $user->assignTables()->sync($request->tables);

        return redirect()->back()->with('message', 'Table assigned successfully!');
    }
}

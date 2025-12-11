<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables; // Yajra DataTables for AJAX tables
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class UserController extends Controller
{
    /**
     * Constructor to apply permissions for CRUD actions
     */
    public function __construct()
    {
        $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index', 'getUsers']]);
        $this->middleware('permission:user-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:user-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);
    }

    /**
     * Display the user listing page (DataTables will load via AJAX)
     */
    public function index(): View
    {
        return view('admin.users.index'); // Blade file will handle DataTables AJAX
    }

    /**
     * Return JSON for DataTables AJAX
     */
    public function getUsers(Request $request)
    {
        if ($request->ajax()) {
            $users = User::with('roles')->latest(); // Load roles for each user

            return DataTables::of($users)
                ->addIndexColumn() // Adds DT_RowIndex
                ->addColumn('roles', function ($user) {
                    // Format roles as badges
                    return $user->roles->map(fn($role) =>
                        '<span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded mr-1">'
                        . $role->name . '</span>'
                    )->implode('');
                })
                ->addColumn('actions', function ($user) {
                    // Show action buttons based on permissions
                    $view = auth()->user()->can('user-view') ?
                        '<a href="'.route('users.show', $user->id).'" class="text-blue-600 hover:text-blue-800 mr-2">
                            <iconify-icon icon="heroicons:eye" width="22"></iconify-icon>
                        </a>' : '';

                    $edit = auth()->user()->can('user-edit') ?
                        '<a href="'.route('users.edit', $user->id).'" class="text-yellow-600 hover:text-yellow-800 mr-2">
                            <iconify-icon icon="heroicons:pencil-square" width="22"></iconify-icon>
                        </a>' : '';

                    $delete = auth()->user()->can('user-delete') ?
                        '<form action="'.route('users.destroy', $user->id).'" method="POST" style="display:inline-block;" onsubmit="return confirm(\'Are you sure?\')">
                            '.csrf_field().method_field('DELETE').'
                            <button class="text-red-600 hover:text-red-800">
                                <iconify-icon icon="heroicons:trash" width="22"></iconify-icon>
                            </button>
                        </form>' : '';

                    return '<div class="flex justify-center space-x-2">'.$view.$edit.$delete.'</div>';
                })
                ->rawColumns(['roles', 'actions']) // Allow HTML in these columns
                ->make(true);
        }
    }

    /**
     * Show the form for creating a new user
     */
    public function create(): View
    {
        $roles = Role::pluck('name', 'name')->all(); // List of roles for select
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created user
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required'
        ]);

        $input = $request->all();
        $input['password'] = Hash::make($input['password']); // Hash password

        $user = User::create($input);
        $user->assignRole($request->roles); // Assign roles

        return redirect()->route('users.index')
            ->with('success', 'User created successfully.');
    }

    /**
     * Display the specified user
     */
    public function show($id): View
    {
        $user = User::with('roles')->findOrFail($id); // Load roles
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user
     */
    public function edit($id): View
    {
        $user = User::findOrFail($id);
        $roles = Role::pluck('name', 'name')->all();
        $userRoles = $user->roles->pluck('name')->toArray(); // Roles assigned to user

        return view('admin.users.edit', compact('user', 'roles', 'userRoles'));
    }

    /**
     * Update the specified user
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|same:confirm-password',
            'roles' => 'required'
        ]);

        $input = $request->all();

        // Hash password only if provided
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = Arr::except($input, ['password']);
        }

        $user = User::findOrFail($id);
        $user->update($input);

        // Sync roles
        $user->syncRoles($request->roles);

        return redirect()->route('users.index')
            ->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified user
     */
    public function destroy($id): RedirectResponse
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'User deleted successfully.');
    }
}

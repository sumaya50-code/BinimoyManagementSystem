<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;


class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:role-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:role-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }

    /**
     * Display the role listing page (DataTables will load via AJAX)
     */
    public function index(): View
    {
        return view('admin.roles.index'); // Blade file will handle DataTables AJAX
    }

    /**
     * Return JSON for DataTables AJAX
     */
    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $roles = Role::with('permissions')->latest();

            return DataTables::of($roles)
                ->addIndexColumn() // Adds DT_RowIndex
                ->addColumn('permissions', function ($role) {
                    $count = $role->permissions->count();
                    return '<span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded">' . $count . ' permissions</span>';
                })
                ->addColumn('actions', function ($role) {
                    // Show action buttons based on permissions
                    $edit = auth()->user()->can('role-edit') ?
                        '<a href="'.route('roles.edit', $role->id).'" class="text-yellow-600 hover:text-yellow-800 mr-2">
                            <iconify-icon icon="heroicons:pencil-square" width="22"></iconify-icon>
                        </a>' : '';

                    $delete = auth()->user()->can('role-delete') ?
                        '<form action="'.route('roles.destroy', $role->id).'" method="POST" style="display:inline-block;" onsubmit="return confirm(\'Are you sure?\')">
                            '.csrf_field().method_field('DELETE').'
                            <button class="text-red-600 hover:text-red-800">
                                <iconify-icon icon="heroicons:trash" width="22"></iconify-icon>
                            </button>
                        </form>' : '';

                    return '<div class="flex justify-center space-x-2">'.$edit.$delete.'</div>';
                })
                ->rawColumns(['permissions', 'actions']) // Allow HTML in these columns
                ->make(true);
        }
    }

    public function create()
    {
        // Group permissions by module (role, product, user)
        $permissions = Permission::all()->groupBy(function ($item) {
            return explode('-', $item->name)[0]; // 'role', 'product', 'user'
        });

        return view('admin.roles.create', compact('permissions'));
    }

    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|unique:roles,name',
        'permission' => 'required|array',
    ]);

    $role = Role::create(['name' => $request->input('name')]);
    $role->syncPermissions($request->input('permission'));

    return redirect()->route('roles.index')->with('success', 'Role created successfully');
}


    public function edit(int $id): View
    {
        $role = Role::findOrFail($id);
        $permissions = Permission::all();
        $rolePermissions = $role->permissions->pluck('id')->toArray();

        return view('admin.roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $role = Role::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id,
            'permission' => 'required|array',
        ]);

        $role->update(['name' => $validated['name']]);
        $role->syncPermissions($validated['permission']); // names sent from form

        return redirect()->route('roles.index')
            ->with('success', 'Role updated successfully.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return redirect()->route('roles.index')
            ->with('success', 'Role deleted successfully.');
    }

}

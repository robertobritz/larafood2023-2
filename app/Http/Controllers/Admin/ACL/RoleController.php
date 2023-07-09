<?php

namespace App\Http\Controllers\Admin\ACL;

use App\Http\Requests\StoreUpdateRole;
use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{

    protected $repository;

    public function __construct(Role $role)
    {
        $this->repository = $role;

        $this->middleware(['can:roles']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = $this->repository->paginate();

        return view('admin.pages.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.roles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUpdateRole $request)
    {
        $this->repository->create($request->all());

        return redirect()->route('roles.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if(!$role = $this->repository->find($id)){
            return redirect()->back();
        }
        return view('admin.pages.roles.show', compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if(!$role = $this->repository->find($id)){
            return redirect()->back();
        }

        return view('admin.pages.roles.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreUpdateRole $request, string $id)
    {
        if(!$role = $this->repository->find($id)){
            return redirect()->back();
        }

        $role->update($request->all());

        return redirect()->route('roles.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(!$role = $this->repository->find($id)){
            return redirect()->back();
        }

        $role->delete();

        return redirect()->route('roles.index');
    }

    public function search(Request $request)
    {
        $filters = $request->only('filter');

        $roles = $this->repository
                            ->where(function($query) use ($request) {
                                if($request->filter){
                                    $query->where('name', 'LIKE',"%{$request->filter}%");
                                    $query->orWhere('description','LIKE',"%{$request->filter}%");
                                }

                            })
                            ->paginate();

        return view('admin.pages.roles.index', compact('roles', 'filters'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->requirePermission('view groups');

        $groups = Group::orderBy('name')->get();

        return view('pages.groups.index', [
            'groups' => $groups,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->requirePermission('create groups');

        return view('pages.groups.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->requirePermission('create groups');
        $request->validate([
            'name' => 'required',
        ]);

        $group = new Group;
        $group->name = $request->name;
        $this->setUserId($group);
        $group->save();

        return redirect()->route('groups.show', $group->id)->with('success', 'Группа успешно создана');
    }

    /**
     * Display the specified resource.
     */
    public function show(Group $group)
    {
        $this->requirePermission('view groups');

        return view('pages.groups.show', [
            'group' => $group,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Group $group)
    {
        $this->requirePermission('edit groups');

        return view('pages.groups.edit', [
            'group' => $group,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Group $group)
    {
        $this->requirePermission('edit groups');
        $request->validate([
            'name' => 'required',
        ]);

        $group->name = $request->name;
        $group->save();

        return redirect()->route('groups.show', $group->id)->with('success', 'Группа успешно изменена');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Group $group)
    {
        $this->requirePermission('delete groups');

        $group->delete();

        return redirect()->route('groups.index')->with('success', 'Группа успешно удалена');
    }
}

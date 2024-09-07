<?php

namespace App\Http\Controllers;

use App\Models\Table;
use Illuminate\Http\Request;

class TableController extends Controller
{

    public function __construct()
    {
        //
        $this->middleware('role:admin,operation');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.tables.index', ['tables' => Table::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.tables.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'pax' => 'required|numeric|min:1',
            'description' => 'required',
        ]);

        Table::create($request->input());

        return redirect()->route('admin.tables.index')->with('message', 'Table created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Table  $table
     * @return \Illuminate\Http\Response
     */
    public function show(Table $table)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Table  $table
     * @return \Illuminate\Http\Response
     */
    public function edit(Table $table)
    {
        return view('admin.tables.edit', compact('table'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Table  $table
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Table $table)
    {
        $this->validate($request, [
            'name' => 'required',
            'pax' => 'required|numeric|min:1',
            'description' => 'required',
        ]);

        $table->update($request->input());

        return redirect()->route('admin.tables.index')->with('message', 'Table updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Table  $table
     * @return \Illuminate\Http\Response
     */
    public function destroy(Table $table)
    {
        $table->delete();

        return redirect()->route('admin.tables.index')->with('message', 'Table deleted successfully');
    }
}

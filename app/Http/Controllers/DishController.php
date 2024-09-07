<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Dish;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class DishController extends Controller
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
        return view('admin.dishes.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('admin.dishes.create', ['categories' => Category::all()]);
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
            'properties' => 'required',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
        ]);

        try {
            $category = Category::findOrFail($request->category_id);
        } catch (ModelNotFoundException $e) {
            dd(get_class_methods($e)); // lists all available methods for exception object
            dd($e);
        }

        $category->dishes()->create([
            'name' => $request->name,
            'properties' => $request->properties,
            'price' => $request->price,
        ]);

        return redirect()->route('admin.dishes.index')->with('message', 'Dish successfully added');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Dish  $dish
     * @return \Illuminate\Http\Response
     */
    public function show(Dish $dish)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Dish  $dish
     * @return \Illuminate\Http\Response
     */
    public function edit(Dish $dish)
    {

        return view('admin.dishes.edit', [
            'categories' => Category::all(),
            'dish' => $dish,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Dish  $dish
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Dish $dish)
    {
        $this->validate($request, [
            'name' => 'required',
            'properties' => 'required',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
        ]);

        $dish->update([
            'name' => $request->name,
            'properties' => $request->properties,
            'price' => $request->price,
            'category_id' => $request->category_id,
        ]);

        return redirect()->route('admin.dishes.index')->with('message', 'Dish updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Dish  $dish
     * @return \Illuminate\Http\Response
     */
    public function destroy(Dish $dish)
    {
        // $dish->delete();

        // return redirect()->route('admin.dishes.index')->with('message', 'Dish deleted successfully');
    }

    public function deactivate(Dish $dish)
    {
        $dish->status = '0';
        $dish->save();

        return redirect()->route('admin.dishes.index')->with('message', 'Dish removed successfully');
    }

    public function restore(Dish $dish)
    {
        $dish->status = '1';
        $dish->save();

        return redirect()->route('admin.dishes.index')->with('message', 'Dish restored successfully!');
    }
}

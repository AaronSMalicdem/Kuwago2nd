<?php

namespace App\Http\Controllers;

use Storage;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class CategoryController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.menus.index', ['menus' => Category::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.menus.create');
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
            'description' => 'required',
            'type' => 'required|in:foods,drinks,alcoholic',
            'add_on' => 'nullable',
            'side_dish' => 'nullable',
            'icon' => 'nullable|image',
        ]);

        if (!empty($request->icon)) {
            $icon = $request->file('icon');
            $extension = $icon->extension();
            $icon_name = Str::slug($request->name) . "." . $extension;
            $path = $icon->storeAs('icons', $icon_name, 'public');
        }

        Category::create([
            'name' => $request->name,
            'description' => $request->description,
            'type' => $request->type,
            'icon' => $path ?? null,
        ]);

        return redirect()->route('admin.menus.index')->with('message', 'Menu added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $menu)
    {
        //
        return view('admin.dishes.index', ['dishes' => $menu->dishes]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $menu)
    {
        return view('admin.menus.edit', compact('menu'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $menu)
    {
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            'type' => 'required|in:foods,drinks,alcoholic',
            'icon' => 'nullable|image',
        ]);

        if (!empty($menu->icon)) {
            Storage::delete($menu->icon);
        }

        if (!empty($request->icon)) {
            $icon = $request->file('icon');
            $extension = $icon->extension();
            $icon_name = Str::slug($request->name) . "." . $extension;
            $path = $icon->storeAs('icons', $icon_name, 'public');
        }

        $menu->update([
            'name' => $request->name,
            'description' => $request->description,
            'type' => $request->type,
            'icon' => $path ?? $menu->icon,
        ]);

        return redirect()->route('admin.menus.index')->with('message', 'Menu updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $menu)
    {
        $menu->status = 0;
        $menu->save();

        foreach($menu->dishes as $dish) {
            $dish->status = 0;
            $dish->save();
        }

        return back();
    }

    public function restore(Category $menu) {
        $menu->status = 1;
        $menu->save();

        foreach($menu->dishes as $dish) {
            $dish->status = 1;
            $dish->save();
        }


        return back();

    }
}

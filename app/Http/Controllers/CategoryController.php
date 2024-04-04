<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Category;


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::get();
        return view('admin.category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name'=>'required|unique:categories',
            'description'=>'required',
            'duration' => 'required',
            'amount' => 'required|numeric',
            'from_date' => 'required|date',
            'to_date' => 'required|date|after_or_equal:from_date'
        ]);
        Category::create([
            'name'=>$request->name,
            'slug'=>Str::slug($request->name),
            'description'=>$request->description,
            'duration' => $request->duration,
            'amount' => $request->amount,
            'from_date' => $request->from_date,
            'to_date' => $request->to_date
        ]);
        return redirect()->route('categories.index')->with('message', 'Budget created successfully!');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = Category::findOrFail($id);
        return view('admin.category.update', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'name' => 'required|unique:categories,name,' . $id,
            'description' => 'required',
            'duration' => 'required',
            'amount' => 'required|numeric',
            'from_date' => 'required|date',
            'to_date' => 'required|date|after_or_equal:from_date',
        ]);

        $category = Category::findOrFail($id);
        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'duration' => $request->duration,
            'amount' => $request->amount,
            'from_date' => $request->from_date,
            'to_date' => $request->to_date,
        ]);

        return redirect()->route('categories.index')->with('message', 'Category updated successfully!');
    }

    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return back()->with('message', 'Category deleted successfully!');
    }

}

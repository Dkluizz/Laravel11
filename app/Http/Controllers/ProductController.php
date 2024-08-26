<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function create()
    {
        $this->authorize('is_admin');
        $data = [];
        $listCat = Category::all();
        $data['list'] = $listCat;

        return view('products.create', $data);
    }

    public function store(Request $request)
    {
        $this->authorize('is_admin');
       
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'name' => 'required',
            'value' => 'required', 'regex:/^\d+(\,\d{1,2})?$/',
            'quantity' => 'required',
            'description' => 'required',
            'id_category' => 'required',
        ]);
        $value = str_replace(['.', ','], ['', '.'], $request->input('value'));
        $data = $request->only('name', 'value', 'photo', 'description', 'quantity', 'id_category');
        $data['value'] = $value;

        if ($request->hasFile('photo')) {
            $nameImage = time() . '_' . $request->file('photo')->getClientOriginalName();
        
            $path = $request->file('photo')->storeAs('images/products', $nameImage, 'public');
    
            $data['photo'] = "/storage/$path";
        }
        Product::create($data);

        return redirect()->route('users.index');
    }

    public function show($product)
    {
        $show = Product::find($product);

        return view('products.show', compact('show'));
    }

    public function edit($product)
    {
        $this->authorize('is_admin');
        $catList = Category::all();
        $prod = Product::find($product);

        return view('products.edit', compact('prod', 'catList'));
    }

    public function update(Request $request, $product)
{
    $this->authorize('is_admin');
    
    $request->validate([
        'photo' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg', 
        'name' => 'required|string|max:255',
        'value' => ['required', 'regex:/^\d+(\,\d{1,2})?$/'], 
        'quantity' => 'required|integer|min:1',
        'description' => 'required|string|max:1000',
        'id_category' => 'required|integer|exists:categories,id',
    ]);
    
    $value = str_replace(['.', ','], ['', '.'], $request->input('value'));
    $data = $request->all();
    $data['value'] = $value;
    if ($request->hasFile('photo')) {
        $nameImage = time() . '_' . $request->file('photo')->getClientOriginalName();
        $path = $request->file('photo')->storeAs('images/products', $nameImage, 'public');
        $data['photo'] = "/storage/$path";
    }
    
    Product::findOrFail($product)->update($data);

    return redirect()->route('users.index')->with('success', 'Produto atualizado com sucesso!');
}


    public function destroy($product)
    {
        $this->authorize('is_admin');

        Product::findOrFail($product)->delete();

        return redirect()->route('users.index');
    }
}

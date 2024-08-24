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

        $data = [];
        $listCat = Category::all();
        $data['list'] = $listCat;

        return view('products.create', $data);
    }

    public function store(Request $request)
    {
        $data = $request->only('name', 'value', 'photo', 'description', 'id_category');

        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'name' => 'required',
            'value' => 'required',
            'description' => 'required',
            'id_category' => 'required',
        ]);

        if ($request->has('photo') && $request->photo->isValid()) { 
        $nameImage = $request->file('photo')->getClientOriginalName();

        Storage::put("/public/images/produtos/{$nameImage}", file_get_contents($request->photo));

        $data['photo'] = "/storage/images/produtos/{$nameImage}";
        }
        Product::create($data);

        return redirect()->route('users.index');
    }

    public function show($product)
    {
        $show = Product::find($product);

        // dd($show);
        return view('products.show', compact('show'));
    }

    public function edit($product)
    {
        // $this->authorize('is_admin');

        // lista Categorias
        $catList = [];
        $cat = Category::all();
        $catList['cat'] = $cat;

        //lista Produtos
        $edit = Product::find($product);

        return view('products.edit', compact('edit'), $catList);
    }

    public function update($product, Request $request)
    {
        // $this->authorize('is_admin');

        $data = $request->all();

        //upload IMAGE
        if ($request->has('photo') && $request->photo->isValid()) {

            $nameImage = $request->file('photo')->getClientOriginalName();

            Storage::put("/public/images/produtos/{$nameImage}", file_get_contents($request->photo));

            $data['photo'] = "/storage/images/produtos/{$nameImage}";
        }

        Product::find($product)->update($data);

        return redirect()->route('users.index');
    }

    public function destroy($product)
    {
        // $this->authorize('is_admin');

        Product::findOrFail($product)->delete();

        return redirect()->route('users.index');
    }
}

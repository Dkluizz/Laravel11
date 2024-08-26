<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function index( Request $request)
    {
        $search = request('search');
        if($search){
            $listProduct = Product::where([
                ['name', 'like', '%'.$search.'%']])->get();

        }else{
            $listProduct = Product::all();
        }

        $data=[];        
        $listCat = Category::all();
        $listProduct = Product::filterByCategory($request->id_category??null)->get();

        $data['catlist']=$listCat;
        $data['list']= $listProduct;
        
        

        return view('categories.index', $data,['list'=> $listProduct]);
    }

    public function create()
    {
        $this->authorize('is_admin');
        $listCat = Category::all();
        return view('categories.create',compact('listCat'));
    }

    public function store(Request $request)
    {
        $this->authorize('is_admin');
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'icon' => 'required|image|max:2048',
        ]);
    
        $data = $request->only(['name', 'description']);
    
        if ($request->hasFile('icon')) {
            $nameImage = time() . '_' . $request->file('icon')->getClientOriginalName();
        
            $path = $request->file('icon')->storeAs('images/iconCategory', $nameImage, 'public');
    
            $data['icon'] = "/storage/$path";
        }
    
        Category::create($data);
    
        return redirect()->route('categories.create')->with('success', 'Categoria criada com sucesso!');
    }
    

    public function edit(Category $category)
    {
        $this->authorize('is_admin');
        $listCat = Category::all();
        $cat = Category::find($category->id);
        return view('categories.edit', compact('listCat', 'cat'));
    }       

    public function update(Request $request, Category $category)
    {
        $this->authorize('is_admin');
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'icon' => 'sometimes|image|max:2048',
        ]);
    
        $data = $request->only(['name', 'description']);
    
        if ($request->hasFile('icon')) {
            $nameImage = time() . '_' . $request->file('icon')->getClientOriginalName();
        
            $path = $request->file('icon')->storeAs('images/iconCategory', $nameImage, 'public');
    
            $data['icon'] = "/storage/$path";
        }

        Category::find($category->id)->update($data); 
        return  redirect()->route('categories.create');
    }       

    public function destroy(Category $category)
    {
        $this->authorize('is_admin');
        $category->delete();
        return redirect()->route('categories.create');
    }       
}

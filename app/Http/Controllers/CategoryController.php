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
        $listCat = Category::all();
        return view('categories.create',compact('listCat'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        if ($request->has('photo') && $request->photo->isValid()) {

            $nameImage = $request->file('photo')->getClientOriginalName();

            Storage::put("/public/images/produtos/{$nameImage}", file_get_contents($request->photo));

            $data['photo'] = "/storage/images/produtos/{$nameImage}";
        }


        Category::create($request->all());
        return redirect('/categories');
    }       

    public function edit(Category $category)
    {
        $data = [];
        $listCat = Category::all();
        $data['list'] = $listCat;
        $data['cat'] = $category;
        return view('categories.edit', $data);
    }       

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $category->update($request->all());
        return redirect('/categories.create');
    }       

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect('/categories.delete');
    }       
}

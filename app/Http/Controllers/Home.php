<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class Home extends Controller
{
    public function index()
        
    {
        $search = request('search');

        if($search){
            $listProduct = Product::where([
                ['name', 'like', '%'.$search.'%']

        ])->get();

        }else{
            $listProduct = Product::all();
        }
        
        return view('home', compact('listProduct'));
    }
}

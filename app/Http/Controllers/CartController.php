<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $cartItems = Cart::where('id_user', Auth::user()->id)->get();

        $total = $cartItems->sum(function ($item) {
            return $item->value * $item->quantity;
        });

        return view('cart.index', compact('cartItems', 'total'));
    }


    public function store(Request $request)
    {
        $product = Product::findOrFail($request->product_id);
        if ($request->quantity > $product->quantity) {
            return redirect()->back()->with('error', 'Quantidade selecionada superior ao estoque!');
        }
        $quantity = $request->quantity > $product->quantity ? $product->quantity : $request->quantity;
        if ($quantity == 0 or $quantity == null) {
            $quantity = 1;
        }
        Cart::create([
            'id_user' => $request->id_user,
            'product_id' => $request->product_id,
            'name' => $product->name,
            'photo' => $product->photo,
            'value' => $product->value,
            'description' => $product->description,
            'quantity' => $quantity,
        ]);

        return redirect()->back()->with('success', 'Produto adicionado ao carrinho!');
    }

    public function destroy($cart)
    {
        Cart::findOrFail($cart)->delete();

        return redirect()->route('cart.index');
    }


    public function clear()
    {

        Cart::where('id_user', Auth::user()->id)->delete();
        return redirect(route('cart.index'))->with('mensagem', 'Compra realizada com sucesso');
    }

    public function update(Request $request, $cartId)
{
    $cart = Cart::findOrFail($cartId);

    $cart->quantity = $request->input('quantity');
    $cart->save(); 

    return redirect()->back()->with('success', 'Quantidade atualizada com sucesso!');
}

}
